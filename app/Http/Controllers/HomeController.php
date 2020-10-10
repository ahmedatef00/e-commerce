<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function search()
    {
        $q = request('q');
        $products = Product::where('name', 'LIKE', '%' . $q . '%')->orWhere('SKE', 'LIKE', '%' . $q . '%')->get();
        if (count($products) > 0)
            return view('product.index', compact('products'));
        else return view('welcome')->with('message','Try to search again !');
    }
    public function latestProducts()
    {

        if (session('success')) {
            toast(session('success'), 'success');
        }


        $latestProducts = Product::latest()->take(5)->get();
        return view('latestProducts', compact('latestProducts'));
    }
}
