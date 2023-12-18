<?php

namespace App\Console\Commands;

use App\Services\PinterestService;
use App\Services\WoocommerceService;
use Illuminate\Console\Command;

class PostToPinterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:pinterest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post new products to Pinterest';

    /**
     * Execute the console command.
     */

    protected $pinterestService;
    protected $woocommerceService;

    public function __construct(PinterestService $pinterestService, WoocommerceService $woocommerceService)
    {
        parent::__construct();

        $this->pinterestService = $pinterestService;
        $this->woocommerceService = $woocommerceService;
    }
    public function handle()
    {
        try {
            $newWoocommerceProducts = $this->woocommerceService->getProducts();

            if (count($newWoocommerceProducts) > 0) {
                foreach ($newWoocommerceProducts as $product) {
                    $boardId = 'ao';

                    $images = $product['images'];
                    foreach ($images as $image) {
                        $imageUrl = $image['src'];
                        $description = $product['description'];
                        $title = $product['name'];

                        $this->pinterestService->postImage($boardId, $imageUrl, $title, $description);
                    }
                }

                $this->info('New products posted to Pinterest successfully!');
            } else {
                $this->info('No new products to post on Pinterest.');
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
