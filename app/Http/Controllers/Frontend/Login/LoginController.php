<?php

namespace App\Http\Controllers\Frontend\Login;

use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Popup;

class LoginController extends Controller
{
    use Common;

    function landing()
    {
        $banners_up = Banner::where('banner_position_id', 1)->get();
        // Check if there are any records with banner_position_id = 2
        $banners_down = Banner::where('banner_position_id', 2)->latest('id')->first();
        $categories = Category::all();
        $uniqueCategoryNames = $categories->pluck('category_name')->unique();
        $collections = Collection::select('collections.*', 'collection_image_sizes.id as sizeid')
            ->join('collection_image_sizes', 'collection_image_sizes.id', '=', 'collections.size_id')
            ->get();
        $popup = Popup::first();
        return view('frontend.landing.landing', compact('banners_up', 'categories', 'banners_down', 'collections', 'uniqueCategoryNames', 'popup'));
    }
}
