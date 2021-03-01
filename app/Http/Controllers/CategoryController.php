<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryForm;
use App\Category;
use App\Product;
use Carbon\Carbon;
use Auth;
use Image;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('checkroll');
  }

  function addCategory()
  {
    return view('admin\category\add_category', [
      'categories'           => Category::all(),
      'softDelete'           => Category::onlyTrashed()->get(),
    ]);
  }

  function addCategoryPost(CategoryForm $request)
  {
    $category_id = Category::insertGetId([
      'category_name'        => $request->category_name,
      'category_description' => $request->category_description,
      'user_id'              => Auth::id(),
      'created_at'           => Carbon::now(),
    ]);
    if ($request->hasFile('category_photo')) {
      echo $category_id;
      // upload category Image start
      $uploadPhoto      = $request->file('category_photo');
      $newPhotoName     = $category_id . '.' . $uploadPhoto->getClientOriginalExtension();
      $newPhotoLocation = 'public/uploads/category_photos/' . $newPhotoName;
      Image::make($uploadPhoto)->resize(350, 274)->save(base_path($newPhotoLocation), 95);
      Category::find($category_id)->update([
        'category_photo' => $newPhotoName,
      ]);
      // upload category Image end
    }
    return back()->with('dataSave', 'Category insert successfully');
  }

  function editCategory($category_id)
  {
    return view('admin.category.category_edit', [
      'categories'           => Category::find($category_id),
    ]);
  }

  function editCategoryPost(Request $request)
  {
    $request->validate([
      'category_name'        => 'required|unique:categories,category_name,' . $request->category_id,
      'category_description' => 'required',
    ]);
    Category::find($request->category_id)->update([
      'category_name'        => $request->category_name,
      'category_description' => $request->category_description,
    ]);
    return redirect('add/category')->with('update_category', $request->category_name . ' ' . ' Category Update successfully');
  }

  function deleteCategory($category_id)
  {
    // category delete
    Category::find($category_id)->delete();
    // product delete
    Product::where('category_id', $category_id)->delete();
    return back()->with('category_delete', 'Category delete successfully');
  }

  function restoreCategory($category_id)
  {
    Category::withTrashed()->find($category_id)->restore();
    return back();
  }

  function forceDeleteCategory($category_id)
  {
    Category::withTrashed()->find($category_id)->forceDelete();
    // product force delete
    Product::withTrashed()->where('category_id', $category_id)->forceDelete();
    return back();
  }
}
