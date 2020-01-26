<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PhotoResource;
use App\Photo;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function list()
    {
        $categories = Category::orderBy('date', 'desc')->get();

        return CategoryResource::collection($categories);
    }

    public function get($category_id)
    {
        $category = Category::find($category_id);

        if(!$category) {
            return response()->json(['error' => 'Category not found.'], 400);
        }

        return new CategoryResource($category);
    }

    public function create(Request $request)
    {
        $name = $request->get('name');
        $date = $request->get('date');

        if($name && (bool) strtotime($date)) {
            $category = new Category();
            $category->name = $name;
            $category->date = date('Y-m-d H:i:s', strtotime($date));
            $category->save();

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['error' => 'Submit valid data.'], 400);
    }

    /**
     * Update selected category
     * @param Request $request
     * @param $category_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $category_id) {

        $category = Category::find($category_id);

        if (!$category) {
            return response()->json(['error' => 'Category not found.'], 400);
        }

        $name = $request->get('name');
        $date = $request->get('date');

        if($name && (bool) strtotime($date)) {
            $category->name = $name;
            $category->date = date('Y-m-d H:i:s', strtotime($date));
            $category->save();

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['error' => 'Submit valid data.'], 400);
    }

    /**
     * Delete selected category
     * @param $category_id int
     * @return json
     */
    public function delete($category_id)
    {
        $category = Category::find($category_id);
        if($category) {
            $category->delete();

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'ok']);
    }
}
