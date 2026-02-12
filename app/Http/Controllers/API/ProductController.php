<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SupplierResource;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Okriiza\ApiResponseFormatter\ApiResponse;

class ProductController extends Controller
{
    public function categories()
    {
        try {
            $categories = DB::table('categories')->get();
            if ($categories->isEmpty()) {
                return ApiResponse::error([
                    'errors' => [
                        'message' => 'No categories found'
                    ]
                ], 404);
            }

            return ApiResponse::success(CategoryResource::collection($categories), 'Categories retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    public function supplier()
    {
        try {
            $suppliers = DB::table('suppliers')->get();
            if ($suppliers->isEmpty()) {
                return ApiResponse::error([
                    'errors' => [
                        'message' => 'No suppliers found'
                    ]
                ], 404);
            }

            return ApiResponse::success(SupplierResource::collection($suppliers), 'Suppliers retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    public function products(Request $request)
    {
        try {
            $search = $request->query('search');
            $products = Products::with('category', 'supplier');

            // search by product name
            $products->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('product_name', 'LIKE', "%{$search}%");
                });
            });

            // filter by category
            if ($request->has('category_id')) {
                $products->where('category_id', $request->query('category_id'));
            }

            // filter by supplier
            if ($request->has('supplier_id')) {
                $products->where('supplier_id', $request->query('supplier_id'));
            }

            // Filter by min_price dan max_price (optional)
            if ($request->has('min_price')) {
                $products->where('unit_price', '>=', $request->query('min_price'));
            }
            if ($request->has('max_price')) {
                $products->where('unit_price', '<=', $request->query('max_price'));
            }


            $result = $products->paginate(10);

            if ($result->isEmpty()) {
                return ApiResponse::error([
                    'errors' => [
                        'message' => 'No products found'
                    ]
                ], 404);
            }

            $pagination = [
                'page' => $result->currentPage(),
                'limit' => $result->perPage(),
                'total' => $result->total(),
                'total_pages' => $result->lastPage(),
            ];

            return ApiResponse::success([
                'data' => ProductResource::collection($result),
                'meta' => ['pagination' => $pagination]
            ]);
        } catch (\Exception $e) {
            return ApiResponse::error([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    public function show($id)
    {
        try {
            $product = Products::with('category', 'supplier')
                ->where('product_id', $id)->first();

            $totalPurchase = DB::table('order_details')
                ->where('product_id', $id)
                ->sum('quantity');

            $product->total_purchase = $totalPurchase;

            if (!$product) {
                return ApiResponse::error([
                    'errors' => [
                        'message' => 'Product not found'
                    ]
                ], 404);
            }

            return ApiResponse::success(new ProductDetailResource($product), 'Product retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    public function storeProduct(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'product_name'  => 'required|min:3',
            'supplier_id'   => 'required|exists:suppliers,supplier_id',
            'category_id'   => 'required|exists:categories,category_id',
            'unit_price'    => 'required|min:0',
            'units_in_stock' => 'nullable|numeric|min:0',
            'discontinued'  => 'nullable|boolean',
        ]);

        if ($validation->fails()) {
            return ApiResponse::failedValidation(
                $validation->errors(),
            );
        }

        try {
            Products::create([
                'product_name'  => $request->product_name,
                'supplier_id'  => $request->supplier_id,
                'category_id'  => $request->category_id,
                'unit_price'  => $request->unit_price,
                'units_in_stock'  => $request->units_in_stock,
                'discontinued'  => $request->discontinued,
            ]);

            return ApiResponse::created(
                'null',
                'data saved successfully',
                true
            );
        } catch (\Exception $e) {
            return ApiResponse::error([
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }
}
