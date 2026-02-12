<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::with(['category', 'supplier'])->get();

        return view('products.index', [
            'products' => $products
        ]);
    }

    public function show($id)
    {
        $product = Products::with(['category', 'supplier'])->findOrFail($id);

        return view('products.show', [
            'product' => $product
        ]);
    }
}
