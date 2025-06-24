<?php

namespace App\Http\Controllers\Retailer\Landing;

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
    private $paginate = 50;
    use Common;

    function landing()
    {
        $banner = Banner::where('banner_position_id', 1)->where('project', 'RMS')->first();
        $mobilebanner = Banner::where('banner_position_id', 4)->where('project', 'RMS')->first();
        return view('retailer.landing.landing', compact('banner', 'mobilebanner'));
    }

    function category()
    {
        return view('retailer.category.category');
    }

    function ganesha(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Electroforming';
        $breadcrumUrl = route('retailerefreadystock');
        $search = 'Ganesha';
        $request->session()->put('ret_ses', 'GANESH');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function hanuman(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Electroforming';
        $breadcrumUrl = route('retailerefreadystock');
        $search = 'Hanuman';
        $request->session()->put('ret_ses', 'HANUMAN');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function krishna(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Electroforming';
        $breadcrumUrl = route('retailerefreadystock');
        $search = 'Krishna';
        $request->session()->put('ret_ses', 'KRISHNA');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function lakshmi(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Electroforming';
        $breadcrumUrl = route('retailerefreadystock');
        $search = 'Lakshmi';
        $request->session()->put('ret_ses', 'LAKSHMI');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function buddha(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Electroforming';
        $breadcrumUrl = route('retailerefreadystock');
        $search = 'Buddha';
        $request->session()->put('ret_ses', 'BUDDHA');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siGanesh(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Solid Idol';
        $breadcrumUrl = route('retailersireadystock');
        $search = 'Ganesha';
        $request->session()->put('ret_ses', 'GANESH');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siHanuman(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Solid Idol';
        $breadcrumUrl = route('retailersireadystock');
        $search = 'Hanuman';
        $request->session()->put('ret_ses', 'HANUMAN');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siKrishna(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Solid Idol';
        $breadcrumUrl = route('retailersireadystock');
        $search = 'Krishna';
        $request->session()->put('ret_ses', 'KRISHNA');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siLakshmi(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Solid Idol';
        $breadcrumUrl = route('retailersireadystock');
        $search = 'Lakshmi';
        $request->session()->put('ret_ses', 'LAKSHMI');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siVishnu(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        ini_set('memory_limit', '1024M');
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
        $breadcrum = 'Solid Idol';
        $breadcrumUrl = route('retailersireadystock');
        $search = 'Vishnu';
        $request->session()->put('ret_ses', 'VISHNU');
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }
}
