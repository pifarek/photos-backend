<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use mysql_xdevapi\Session;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('date', 'desc')->paginate(12);

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'date' => ['date_format:d/m/Y']
        ]);

        $date = null;
        if($request->get('date')) {
            $date = \DateTime::createFromFormat('d/m/Y', $request->get('date'));
        }

        $category = new Category;
        $category->name = $request->get('name');
        $category->date = $date;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category has been created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($category_id)
    {
        $category = Category::find($category_id);
        if(!$category) {
            return redirect()->route('categories.index');
        }

        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
    {
        $category = Category::find($category_id);

        $request->validate([
            'name' => ['required']
        ]);

        $date = null;
        if($request->get('date')) {
            $date = \DateTime::createFromFormat('d/m/Y', $request->get('date'));
        }

        $category->name = $request->get('name');
        $category->date = $date;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Selected category has been updated successfully');
    }

    public function remove($category_id) {
        $category = Category::find($category_id);
        if($category) {
            $category->delete();
        }

        \Session::flash('success', 'Selected category has been successfully removed.');

        return response()->json(['status' => 'ok']);
    }
}
