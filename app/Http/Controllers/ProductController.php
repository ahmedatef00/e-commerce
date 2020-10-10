<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('product.create', ['brands' => $brands, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'SKE' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg',
        ]);


        $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->SKE = $request->SKE;
        $product->brand_id = $request->brand_id;
        $product->image = $imageName;
        $product->save();
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $productId = $request->product;
        $product = Product::find($productId);
        return view('product.edit', [
            'product' => $product,
            'categories' => Category::all(),
             'brands' => Brand::all()
        ]);
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'SKE' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg',
        ]);



        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->SKE = $request->SKE;
        $product->brand_id = $request->brand_id;
        
        if (request()->image != null) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


    private function storeImage($product)
    {
        if (request()->has('image')) {
            $product->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);

            $image = Image::make(public_path('storage/' . $product->image))->fit(300, 300, null, 'top-left');
            $image->save();
        }
    }
}
