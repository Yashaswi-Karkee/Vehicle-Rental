<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Agency;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $vehicleType = $request->input('vehicleType');
        if ($query == null && $vehicleType != "all") {
            $result = Posts::where('type', $vehicleType)->get();
            return redirect()->to(route('homepage'))->with('result', $result);
        } else if ($query != null && $vehicleType == "all") {
            $result = Posts::join('agencies', 'posts.agencyEmail', '=', 'agencies.email')
                ->where('posts.title', 'like', '%' . $query . '%')
                ->orWhere('agencies.name', 'like', '%' . $query . '%')->get();
            return redirect()->to(route('homepage'))->with('result', $result);
        } else if ($query != null && $vehicleType != "all") {
            $temp = Posts::join('agencies', 'posts.agencyEmail', '=', 'agencies.email')
                ->where('posts.type', $vehicleType);
            $result = $temp->where('posts.title', 'like', '%' . $query . '%')
                ->orWhere('agencies.name', 'like', '%' . $query . '%')->get();
            return redirect()->to(route('homepage'))->with('result', $result);
        } else {
            return redirect()->to(route('homepage'));
        }
    }
}
