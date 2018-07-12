<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $per_page = 10;
        if ($request->per_page)
            $per_page = $request->per_page;
        $q = Article::join('names','articles.name_id','=','names.id')->select('articles.*')->with('name');
        if ($request->q)
            $q = $q->where('names.alias','like','%' . preg_replace('/[^а-яёА-ЯЁa-zA-Z0-9]/', '', $request->q ) . '%');
        if ($request->ac)
            return $q->orderBy('names.alias','ASC')->limit($per_page)->get();
        return $q->orderBy('names.alias','ASC')->paginate($per_page);
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
        $article = new Article;
        $name = $request->name;
        $article->name_id = $name['id'];
        $article->short_text = $request->short_text;
        $article->content = $request->get('content');
        $article->save();
        return response()->json(['message'=>'ok','id'=>$article->id]);
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
        if ($id == 0) {
            $articles = Article::join('names','articles.name_id','=','names.id')->where('names.name','=',request()->name);
            if ($articles->count() == 1)
            {
                return $articles->get()->first();
            } else {
                return response()->json(['id' => 0]);
            }
        }
        return Article::find($id);
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
        $article = Article::find($id);
        $name = $request->name;
        $article->name_id = $name['id'];
        $article->short_text = $request->short_text;
        $article->content = $request->get('content');
        $article->save();
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
        return Article::destroy($id);
    }
}
