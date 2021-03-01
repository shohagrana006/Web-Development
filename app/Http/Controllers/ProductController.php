<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Image;
use App\Product_image;

class ProductController extends Controller
{
   public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index',[
          'activeCategories' => Category::all(),
          'products'   => Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $slug   = Str::slug($request->product_name.'-'.Str::random(9));

        $product_id = Product::insertGetId($request->except('_token','product_thumnail_photo','product_multiple_photo') + [
          'slug'       => $slug,
          'created_at' => Carbon::now(),
        ]);

        if ($request->hasFile('product_thumnail_photo')) {
          // upload product thumbile Image start
          $uploadPhoto      = $request->file('product_thumnail_photo');
          $newPhotoName     = $product_id.'.'.$uploadPhoto->getClientOriginalExtension();
          $newPhotoLocation = 'public/uploads/product_photos/'.$newPhotoName;
          Image::make($uploadPhoto)->resize(600, 622)->save(base_path($newPhotoLocation), 90);
          Product::find($product_id)->update([
            'product_thumnail_photo' => $newPhotoName,
          ]);
          // upload product thumbile Image end
        }

        if($request->hasFile('product_multiple_photo')) {
          $flag = 1;
          foreach ($request->file('product_multiple_photo') as $single_photo) {
            // upload product thumbile Image start
            $uploadPhoto      = $single_photo;
            $newPhotoName     = $product_id.'-'.$flag.'.'.$uploadPhoto->getClientOriginalExtension();
            $newPhotoLocation = 'public/uploads/product_multiple_photos/'.$newPhotoName;
            Image::make($uploadPhoto)->resize(600, 622)->save(base_path($newPhotoLocation), 90);
            // upload product thumbile Image end
            $flag++;
            Product_image::insert([
              'product_id'                  => $product_id,
              'product_multiple_image_name' => $newPhotoName,
              'created_at'                  => Carbon::now(),
            ]);
          }
        }

        return back()->with('product_add', 'Product added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
      return view('admin.product.edit',[
        'activeCategories' => Category::all(),
        'product_info'     => $product,
      ]);

      // return view('admin.product.show',[
      //   'product_info' => Product::findOrfail($id),
      // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->except('_token', '_method'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }
}