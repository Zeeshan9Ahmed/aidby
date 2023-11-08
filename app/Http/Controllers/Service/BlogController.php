<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    use ApiResponser;

    public function index () {

        $categories = Category::orderBy('title')->where('parent_id', null)->get();

        $blogs = Blog::with('user:id,first_name,last_name,email,profile_image','category:id,title','sub_category:id,title')
                            ->latest()
                            ->get();
        
        return view('service.blogs.index', compact('categories', 'blogs') );
    }

    public function createBlog (Request $request) {

        $data = $request->only(['category_id','sub_category_id', 'description'])+['user_id' => auth()->id()];
        if($request->hasFile('blog_image')){
            $blog_image = $request->blog_image->store('public/blog_image');
            $path = Storage::url($blog_image);
            $data['blog_image'] = $path;
        }

        Blog::create($data);
        session()->flash('success', 'Blog  added successfully');
        return $this->successResponse("Blog added successfully", 200);

    }

    public function editBlog (Request $request) {
        
        $blogData = $request->only(['category_id','sub_category_id','description']);
        if($request->hasFile('blog_image')){
            $blog_image = $request->blog_image->store('public/blog_image');
            $path = Storage::url($blog_image);
            $blogData['blog_image'] = $path;
        }
        $blog = Blog::whereId($request->id)->update($blogData);
        
        session()->flash('success', 'Blog  updated successfully');
        
        return $this->successResponse("Blog updated successfully", 200);

    }

    public function deleteBlog ($id) {
        Blog::whereId($id)->delete();
        return $this->successResponse("Blog deleted successfully", 200);

    }

    public function blogDetail ($id = null) {

        $blog = Blog::whereId($id)->with('user:id,first_name,last_name,email,profile_image','category:id,title','sub_category:id,title')->firstOrFail();
        
        return view('service.blogs.blog-detail', compact('blog'));
    }

    public function myBlogs () {
        $categories = Category::orderBy('title')->where('parent_id', null)->get();
        $blogs = Blog::with('user:id,first_name,last_name,email,profile_image','category:id,title','sub_category:id,title')
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->get();
        
        return view('service.blogs.my-blogs', compact('categories','blogs'));

    }
}
