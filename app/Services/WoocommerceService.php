<?php

namespace App\Services;

use Automattic\WooCommerce\Client;

class WoocommerceService
{
    protected $client;

    public function __construct()
    {
        $this->client =  new Client(
            config('woocommerce.api_url'),
            config('woocommerce.api_key'),
            config('woocommerce.api_secret'),
            [
                'wp_api' => true,
                'version' => 'wc/v3',
            ]
        );
    }

    public function getProducts()
    {
        $result = $this->client->get('products');

        if ($result instanceof \stdClass) {
            $result = json_decode(json_encode($result), true);
        }

        $today = now()->toDateString();
        $newProducts = [];

        if (count($result) > 0) {
            if (is_array($result)) {
                foreach ($result as $product) {
                    if (is_object($product) && property_exists($product, 'date_created')) {
                        $productDate = substr($product->date_created, 0, 10);
                        if ($productDate == $today) {
                            $newProducts[] = $product;
                        }
                    }
                }
            }
        }
        return $newProducts;
    }
}
