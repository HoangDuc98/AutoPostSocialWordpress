<?php

namespace App\Http\Controllers;

use App\Services\PinterestService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $pinterestService;

    public function __construct(PinterestService $pinterestService)
    {
        $this->pinterestService = $pinterestService;
    }

    public function postImage(Request $request)
    {
        $validationRules = [
            'cookie' => 'required',
            'board_id' => 'required',
            'image_url' => 'required',
            'title' => 'required',
        ];

        $request->validate($validationRules);

        $response = $this->pinterestService->postImage(
            $request->input('cookie'),
            $request->input('board_id'),
            $request->input('image_url'),
            $request->input('title'),
            $request->input('alt_text', null),
            $request->input('note', null),
            $request->input('link', null),
            $request->input('proxy', null)
        );

        if ($response->getStatusCode() === 200) {
            return response()->json(['message' => 'Image posted successfully', 'data' => $response], 200);
        } else {
            return response()->json(['error' => 'Failed to post image'], $response->getStatusCode());
        }
    }
}
