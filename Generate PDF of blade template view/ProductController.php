<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Http\Request;


use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.product', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image',
        ]);

        if ($validate->fails()) {
            return redirect('products')->with('error', $validate->errors());
        }

        $destination = public_path('frontAssets/images/products');
        $image = $request->image;
        $imageName = time() . '.' . $image->extension();
        $image->move($destination, $imageName);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->model = $request->model;
        $product->color = $request->color;
        $product->description = $request->description;
        $product->image = $imageName;
        $product->save();
        return redirect('products')->with('success', 'Product stored successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.product.product-detail', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }


    public function downloadPDF($id)
    {
        $product = Product::find($id);
        $pdf = PDF::loadView('admin.product.product-pdf', ['product' => $product])->setOption([
            'fontDir' => public_path('/fonts'),
            'fontCache' => public_path('/fonts'),
            'defaultFont' => 'AEDRegular'
        ]);
        return $pdf->download('product.pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image'
        ]);

        if ($validate->fails()) {
            return redirect('products')->with('error', $validate->errors());
        }

        $destination = public_path('frontAssets/images/products');
        $image = $request->image;
        $imageName = time() . '.' . $image->extension();
        $image->move($destination, $imageName);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->model = $request->model;
        $product->color = $request->color;
        $product->description = $request->description;
        $product->image = $imageName;
        $product->save();
        return redirect('products')->with('success', 'Product successfully Updated!');
    }


    public function updatePassword(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json('Password field is required!');
        }

        $product = Product::find($id);
        if (!isset($product)) {
            return response()->json('Product not Found!');
        }
        $product->password = $request->password;
        $product->save();
        return response()->json(['message' => 'Password successfully updated!', 'Product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!isset($product)) {
            return redirect('products')->with('error', 'Product already deleted!');
        }
        $product->delete();
        return redirect('products')->with('success', 'Product deleted successfully!');
    }
}
