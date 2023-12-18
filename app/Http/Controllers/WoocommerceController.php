<?php

namespace App\Http\Controllers;

use App\Services\WoocommerceService;
use Illuminate\Http\Request;

class WoocommerceController extends Controller
{
    protected $woocommerceService;

    public function __construct(WoocommerceService $woocommerceService)
    {
        $this->woocommerceService = $woocommerceService;
    }

    public function getProducts()
    {
        try {
            $products = $this->woocommerceService->getProducts();

            return response()->json(['data' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
