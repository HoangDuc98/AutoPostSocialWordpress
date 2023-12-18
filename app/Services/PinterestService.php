<?php

namespace App\Services;

use GuzzleHttp\Client;

class PinterestService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function postImage($cookie, $boardId, $imageUrl, $title, $altText = null, $note = null, $link = null, $proxy = null)
    {
        $response = $this->client->post('https://api.pinterest.com/v3/boards', [
            'form_params' => [
                'board' => $boardId,
                'image_url' => $imageUrl,
                'title' => $title,
                'alt_text' => $altText,
                'note' => $note,
                'link' => $link,
                'proxy' => $proxy,
            ],
            'headers' => [
                'Cookie' => $cookie,
            ],
        ]);

        return $response;
    }
}
