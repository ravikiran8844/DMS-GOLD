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
    private $paginate = 42;
    use Common;

    public function store(Request $request)
    {
        // Validate and store the speed
        $request->validate([
            'speed' => 'required|numeric',
        ]);

        // For example, store it in the session or database
        session(['internet_speed' => $request->speed]);

        return response()->json(['message' => 'Internet speed recorded successfully.']);
    }

    function landing()
    {
        $banners_up = Banner::where('banner_position_id', 1)->where('project', 'RMS')->get();
        return view('retailer.landing.landing', compact('banners_up'));
    }

    function ganesha()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function hanuman()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function krishna()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function lakshmi()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function buddha()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siGanesh()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siHanuman()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siKrishna()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siLakshmi()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function siVishnu()
    {
        ini_set('max_execution_time', 180); //3 minutes
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
        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }
}
