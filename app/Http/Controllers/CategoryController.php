<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function all_categories(){
        $response = [
            'success'=>true,
            'data'=>Category::all(),
        ];
        return response()->json($response);
    }

    public function add_category(Request $request){
        $validator = Validator::make($request->all(),[
            'category_name' => 'required|unique:categories,category_name',
            'profile_pic_path' => 'required',
        ]);
        if ($validator->fails()){
            $response =[
                'success'=>'false',
                'message'=>$validator->errors()
            ];
            return response()->json($response,404);
        }
        $input = $request->all();
        $category = Category::create($input);
        $response = [
            'success'=>true,
            'Category Name'=>$category->category_name,
            'message'=>"Category created successfully !"
        ];
        return response()->json($response,202);
    }

    public function delete_category($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            $response = [
                'success'=>true,
                'message'=>"Category deleted Successfully !"
            ];
            return response()->json($response);
        }
        else {
            $response = [
                'success'=>'false',
                'message'=>'Category not found !'
            ];
        }
        return response()->json($response,202);
    }


    public function update_category(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
            'profile_pic_path' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $category = Category::find($id);

        if (!$category) {
            $response = [
                'success' => false,
                'message' => 'Category not found!'
            ];
            return response()->json($response, 404);
        }

        $category->category_name = $request->input('category_name');
        $category->profile_pic_path = $request->input('profile_pic_path');
        $category->save();

        $response = [
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ];

        return response()->json($response, 200);
    }


}
