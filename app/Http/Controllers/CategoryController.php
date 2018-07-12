<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = Category::join('names','name_id','=','names.id')->select('categories.*','names.name',DB::raw('true as collapsed'))->with('name','picture','article','article.name');
        if ($request->node_id>0){
            $category = Category::find($request->node_id);
            return $query->where([
                ['lft','>',$category->lft],
                ['rgt','<',$category->rgt],
                ['level','=',$request->level]
            ])->orderBy('names.name')->get();
        }
        return $query->where('level','=','0')->orderBy('names.name')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $level = 0;
        $new = 1;
        if ($request->expanded == 0) {
            $new = Category::max('rgt') + 1;
        } else {
            $category = Category::find($request->expanded);
            $level = $category->level + 1;
            $new = $category->lft+1;
            Category::where('rgt','>',$category->lft)->increment('rgt',2);
            Category::where('lft','>',$category->lft)->increment('lft',2);
        }
        $newCategory = new Category;
        $newCategory->lft = $new;
        $newCategory->rgt = $new + 1;
        $newCategory->level = $level;
        $name = $request->name;
        $newCategory->name_id = $name['id'];
        if (isset($request->article) && $request->article['id']>0)  $newCategory->article_id = $request->article['id'];
        if ($request->picture_id != null) $newCategory->picture_id = $request->picture_id;
        $newCategory->save();
        return response()->json(['message'=>'ok','id'=>$newCategory->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($id == 0) return $this->store($request);
        $this->validate($request, [
            'name.id' => 'required|gt:0',
        ]);
        $category = Category::find($id);
        $name = $request->name;
        $category->name_id = $name['id'];
        if (isset($request->article) && $request->article['id']>0)  $category->article_id = $request->article['id'];
        if ($request->picture_id != null) $category->picture_id = $request->picture_id;
        $category->save();
        return response()->json(['message'=>'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::find($id);
        if ($category->lft + 1 == $category->rgt) {
            Category::where('rgt','>',$category->lft)->decrement('rgt',2);
            Category::where('lft','>',$category->lft)->decrement('lft',2);
            return Category::destroy($id);
        } else {
            return response()->json(['error' => 'Не лист']);
        }
    }
}
