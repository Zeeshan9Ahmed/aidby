<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Content;
use DB;
use Carbon\Carbon;
use App\Mail\SendEmail;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

Class CoreController extends Controller
{
	public function categories()
	{
		$categories = Category::with('sub_category')->where('parent_id',null)->orderBy('id','DESC')->get();
		return view('admin.category.index',['categories'=>$categories]);
	}

	public function create_category()
	{
		return view('admin.category.create');
	}

	public function store_category(Request $request)
	{
		$controls=$request->all();
          
        $rules=array(
            "category"=> "required|unique:categories,title",
            "sub_category" => "nullable",
        );
        $validator=Validator::make($controls,$rules);
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
           }

        $cat = new Category;
        $cat->title = $request->category;
		
		if ($request->hasFile('category_image')) {
            $category_image = $request->category_image->store('public/category_image');
            $path = Storage::url($category_image);
            $cat->image = $path;
        }

        $cat->save();

        if($request->sub_category)
        {
        	foreach($request->sub_category as $key => $sub)
        	{
        		$subcat = new Category;
		        $subcat->title = $sub;
		        $subcat->parent_id = $cat->id;
		        
				if ($request->hasFile('sub_category_image') && isset($request->sub_category_image[$key])) {
					$sub_category_image = $request->sub_category_image[$key]->store('public/category_image');
					$sub_path = Storage::url($sub_category_image);
					$subcat->image = $sub_path;
				}
				$subcat->save();
        	}
        }
    	return redirect()->route('admin.categories')->withSuccess('Categories added!');

	}

	public function edit_category($id)
	{
		$categories = Category::with('sub_category')->where('id',$id)->first();
		return view('admin.category.edit',['categories'=>$categories]);
	}

	public function update_category(Request $request)
	{
		$controls=$request->all();
          // dd($controls);
        $rules=array(
            "category"=> "required",
            "sub_category" => "nullable",
        );
        $validator=Validator::make($controls,$rules);
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
           }

        $cat = Category::find($request->category_id);
        $cat->title = $request->category;

		if ($request->hasFile('category_image')) {
            $category_image = $request->category_image->store('public/category_image');
            $path = Storage::url($category_image);
            $cat->image = $path;
        }

        $cat->save();

        if($request->sub_cat_id)
        {
        	for($i=0; $i<count($request->sub_cat_id); $i++)
        	{
        		if($request->sub_cat_id[$i] == 0)
        		{
        			$subcat = new Category;
			        $subcat->title = $request->sub_category[$i];
			        $subcat->parent_id = $cat->id;

					if ($request->hasFile('sub_category_image') && isset($request->sub_category_image[$i])) {
						$sub_category_image = $request->sub_category_image[$i]->store('public/category_image');
						$sub_path = Storage::url($sub_category_image);
						$subcat->image = $sub_path;
					}

			        $subcat->save();
        		}
        		else
        		{
        			$subcat = Category::find($request->sub_cat_id[$i]);
			        $subcat->title = $request->sub_category[$i];
					if ($request->hasFile('sub_category_image') && isset($request->sub_category_image[$i])) {
						$sub_category_image = $request->sub_category_image[$i]->store('public/category_image');
						$sub_path = Storage::url($sub_category_image);
						$subcat->image = $sub_path;
					}
			        $subcat->save();
        		}
        	}
        }

        return redirect()->route('admin.categories')->withSuccess('Categories Updated!');
	}

	public function delete_category(Request $request)
	{
		$delete_subcategory = Category::where('parent_id',$request->id)->delete();
		$delete_category = Category::where('id',$request->id)->delete();

       return 1;
	}

	public function delete_category_image($id)
	{
		$category = Category::whereId($id)->first();
		unlink(public_path($category->image));
		$category->image = null;
		$category->save();

		return redirect()->route('admin.categories')->withSuccess('Categories image deleted!');
	}
}