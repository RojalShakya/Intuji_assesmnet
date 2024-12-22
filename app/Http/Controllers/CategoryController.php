<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResouce;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
     public function index()
    {
        $categories=Category::get();
        if($categories->count()>0){
            return CategoryResouce::collection($categories);
        }
        else{
            return response()->json(['message'=>'No Records available'],200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'category'=>'required|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'All fields are mandatory',
                'error'=>$validator->messages()
            ]);
        }
        $category=Category::create($request->all());
        return response()->json([
            'message'=>'Category created successfully',
            'data'=>new CategoryResouce($category)
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
       return new CategoryResouce($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request,Category $category)
    {
        $validator = Validator::make($request->all(),[
            'category'=>'required|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'All fields are mandatory',
                'error'=>$validator->messages()
            ]);
        }
        $category->update(['category'=>$request->category]);
        return response()->json([
            'message'=>'Category updated successfully',
            'data'=>new CategoryResouce($category)
        ], 200);

    }
    public function destroy(Category $category){
        $category->delete();
        return response()->json([
            'message'=>"Category is deleted",
        ]);
    }

}
