<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Posts;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class reviewController extends Controller
{
    public function showWriteReview($id)
    {
        $order = Order::where('id', $id)->first();
        $user = User::where('email', $order->orderedBy)->first();
        $review = Review::where('UserID', $user->id)->first();
        if ($review == null) {
            return view('review.writeReview', compact('id'));
        } else {
            return back()->with('fail', 'Already reviewed this product');
        }
    }
    //Post Review
    public function postReview(Request $request, $id)
    {

        $order = Order::where('id', $id)->first();
        $user = User::where('email', $order->orderedBy)->first();
        $review = new Review();
        $review->description = $request->description;
        $review->postId = $order->productId;
        $review->UserID = $user->id;
        $review->rating = $request->rating;
        $review->save();
        return redirect()->to(route('show.order.history'))->with('success', 'Review Created!');
    }
}