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


Class UserController extends Controller
{
	public function users()
	{
		$users = User::where('type','user')->orderBy('id','DESC')->get();
		return view('admin.users.index',['users'=>$users]);
	}

       public function service_provider()
       {
              $users = User::where('type','service')->orderBy('id','DESC')->get();
              return view('admin.users.service',['users'=>$users]);
       }

    public function delete_users(Request $request)
    {
               // dd("yes");
        $delete = User::where('id',$request->id)->delete();
        return 1;
    }

	public function contents()
	{
		$content = Content::get();
		return view('admin.users.content',['contents'=>$content]);
	}

	public function edit_content($id)
    {
           $contents = Content::find($id);
           return view('admin.users.update-content',['content' => $contents]);
    }

    public function update_content(Request $request)
    {
           $controls=$request->all();
           $rules=array(
                "description"=>"required",
                "id"=>"required",
           );
           $validator=Validator::make($controls,$rules);
           if ($validator->fails()) {
                  return redirect()->back()->withErrors($validator)->withInput();
           }

           $content=Content::find($request->id);
           $content->content = $request->description;
           $content->save();
           return redirect()->route('contents')->withSuccess('Content Added Successfully...!');
           // return redirect()->back()->withSuccess('Content Added Successfully...!');

    }

}