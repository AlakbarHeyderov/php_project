<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryInsertRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function select(Category $category)
    {
        try {
            return response(["status" => 200, 'message' => 'success', 'data' => $category->all()], 200);
        } catch (\Exception $e) {
            return response(["message" => 'Error', "status" => 400, "error" => $e], 400);
        }
    }


    public function insert(CategoryInsertRequest $request)
    {
        $category = Category::where('name', $request['name'])->first();
        if ($category) {
            return response(['status' => '400', 'message' => 'Bu Kategoria artiq elave olunub'], 400);
        }
        try {
            $response = Category::create($request->toArray());
            return response($response, 200);
        } catch (\Exception $e) {
            return response(["message" => 'Error', "status" => 400, "error" => $e], 400);
        }

    }



    public function update(Request $request, Category $category)
    {

        $categor = Category::where('id', $request['id'])->first();
        if (!$categor) {
            return response(['status' => '400', 'message' => 'Movcud deyil'], 400);
        }
        try {
            $input = $request->all();
            $category->update($input);
            return response(["status" => 200, "message" => "succes"]);
        } catch (\Exception $e) {
            return response(["message" => 'Error', "status" => 400, "error" => $e], 400);
        }
    }


    public function delete(Category $category, Request $request)
    {
        $category = Category::where('id', $request->query('id'))->first();
        if (!$category) {
            return response(['status' => '400', 'message' => 'Movcud deyil'], 400);
        }
        try {
            Category::where('id',$request->query('id'))->delete();
            return response(["status" => 200, "message" => "succes"]);
        } catch (\Exception $e) {
            return response(["message" => 'Error', "status" => 400, "error" => $e], 400);
        }
    }
}
