<?php

namespace App\Http\Controllers;

use App\Comment;

use Laravel\Lumen\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return \View::make('index', [
            'comments' => Comment::orderByDesc('published_at')->limit(20)->get()
        ]);
    }
}
