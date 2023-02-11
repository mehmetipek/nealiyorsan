<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($parent_id = null)
    {
        $categories = Category::whereParentId($parent_id)->paginate(15);

        return view('admin.category.index', compact('categories', 'parent_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parent_id=null)
    {
        if ($parent_id!= null) {
            $parent = Category::find($parent_id);
        } else {
            $parent = null;
        }

        return view('admin.category.create', compact('parent_id', 'parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parent_id = null)
    {
        $request_all = $request->all();
        $category = Category::create($request_all, Category::find($parent_id));

        return redirect()->route('admin.category.index', ['parent_id' => $parent_id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category_id)
    {
        $category = Category::find($category_id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
    {
        $request_all = $request->all();
        unset($request_all['_token']);
        Category::where('id', $category_id)->update($request_all);

        return redirect()->route('admin.category.edit', ['category_id' => $category_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function status($category_id)
    {
        /**
         * @TODO: Bu kategoride ilan varsa, bu ilanlar hangi kategoriye taşınacak.
         */
        $category = Category::find($category_id);
        $category->status = ($category->status == 1) ? false:true;
        $category->save();

        return redirect()->back()->with(['status' => 'Kategori durumu değiştirildi']);
    }
}
