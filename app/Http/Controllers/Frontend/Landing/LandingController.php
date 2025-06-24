<?php

namespace App\Http\Controllers\Frontend\Landing;

use App\Console\Commands\Products;
use App\Enums\Projects;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    private $paginate = 42;
    use Common;

    function landing()
    {
        $banner = Banner::where('banner_position_id', 1)->where('project', 'RMS')->first();
        $mobilebanner = Banner::where('banner_position_id', 4)->where('project', 'RMS')->first();
        return view('dealer.landing.landing', compact('banner', 'mobilebanner'));
    }

    function category()
    {
        return view('dealer.category.category');
    }

    function ganesha(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::ELECTROFORMING)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%GANESH%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::ELECTROFORMING;
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'GANESHA';
        $request->session()->put('ret_ses', 'GANESH');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function hanuman(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::ELECTROFORMING)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%HANUMAN%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::ELECTROFORMING;
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'HANUMAN';
        $request->session()->put('ret_ses', 'HANUMAN');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function krishna(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::ELECTROFORMING)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%KRISHNA%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::ELECTROFORMING;
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'KRISHNA';
        $request->session()->put('ret_ses', 'KRISHNA');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function lakshmi(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::ELECTROFORMING)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%LAKSHMI%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::ELECTROFORMING;
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'LAKSHMI';
        $request->session()->put('ret_ses', 'LAKSHMI');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function buddha(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::ELECTROFORMING)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%BUDDHA%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::ELECTROFORMING;
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'BUDDHA';
        $request->session()->put('ret_ses', 'BUDDHA');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siGanesh(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::SOLIDIDOL)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%GANESH%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::SOLIDIDOL;
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'GANESH';
        $request->session()->put('ret_ses', 'GANESH');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siHanuman(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::SOLIDIDOL)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%HANUMAN%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::SOLIDIDOL;
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'HANUMAN';
        $request->session()->put('ret_ses', 'HANUMAN');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siKrishna(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::SOLIDIDOL)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%KRISHNA%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::SOLIDIDOL;
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'KRISHNA';
        $request->session()->put('ret_ses', 'KRISHNA');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siLakshmi(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::SOLIDIDOL)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%LAKSHMI%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::SOLIDIDOL;
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'LAKSHMI';
        $request->session()->put('ret_ses', 'LAKSHMI');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siVishnu(Request $request)
    {
        $product = $this->getproducts(Auth::user()->id)
            ->where('products.project_id', Projects::SOLIDIDOL)
            ->where('products.qty', '>', 0)
            ->where('products.keywordtags', 'like', '%VISHNU%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);
        $project_id = Projects::SOLIDIDOL;
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = 'VISHNU';
        $request->session()->put('ret_ses', 'VISHNU');
        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }
}
