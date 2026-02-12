<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Okriiza\ApiResponseFormatter\ApiResponse;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = DB::table('customers')->select('company_name', 'country')->get();

            // calculate total purchase for each customer
            $customerPurchases = DB::table('orders')
                ->select('customers.company_name', DB::raw('SUM(orders.order_id) as total_purchase'))
                ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                ->groupBy('customers.company_name')
                ->get()
                ->keyBy('company_name');

            // merge total purchase into customers
            foreach ($customers as $customer) {
                $customer->total_purchase = $customerPurchases->has($customer->company_name)
                    ? $customerPurchases->get($customer->company_name)->total_purchase
                    : 0;
            }

            // convert to collection for resource transformation
            $customers = collect($customers);

            // orderByDesc total_purchase & limit 10
            $customers = $customers->sortByDesc('total_purchase')->values()->take(10);

            $customers = CustomerResource::collection($customers);

            if ($customers->isEmpty()) {
                return ApiResponse::error('No customers found.', 404);
            }

            return ApiResponse::success($customers, 'Customers retrieved successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'errors' => [$e->getMessage()],
            ]);
        }
    }
}
