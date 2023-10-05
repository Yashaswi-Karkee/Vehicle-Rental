<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Posts;
use App\Models\Review;
use Illuminate\Http\Request;

class postController extends Controller
{
    public function postDescription($id)
    {
        $p = Posts::where('id', $id)->first();
        $user = Agency::where('email', $p->agencyEmail)->first();
        $reviews = Review::where('postId', $p->id)->get();
        if (count($reviews) == 0) {
            $reviews = null;
        }
        return view('posts.descriptionPost', compact('p', 'user', 'reviews'));
    }
}