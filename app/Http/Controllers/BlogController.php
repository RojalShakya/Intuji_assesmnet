<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(){
        $blogs=Blog::get();
        if($blogs->count()>0){
            return BlogResource::collection($blogs);
        }
        else{
            return response()->json([
                'message'=>'No records available'
            ],200);
        }

    }
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'title'=>'required|string|max:255',
            'description'=>'required',
            'category_id'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'All fields are mandatory',
                'error'=>$validator->messages(),
            ]);
        }
        $blog=Blog::create($request->all());
        return response()->json([
            'message'=>"Blog created successfully",
            'data'=>new BlogResource($blog)
        ],200);
    }
    public function show(Blog $blog){
        return new BlogResource($blog);
    }
    public function update(Request $request,Blog $blog){
        $validator=Validator::make($request->all(),[
            'title'=>'required|string|max:255',
            'description'=>'required',
            'category_id'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'All fields are mandatory',
                'error'=>$validator->messages(),
            ]);
        }
        $blog->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'category_id'=>$request->category_id
        ]);
        return response()->json([
            'message'=>"Blog updated successfully",
            'data'=>new BlogResource($blog)
        ],200);
    }
    public function destroy(Blog $blog){
        $blog->delete();
        return response()->json([
            'message'=>'Blog deleted successfully',
        ],200);
    }
}
