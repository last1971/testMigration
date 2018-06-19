<?php

namespace App\Http\Controllers;

use App\SomeCase;
use App\Picture;
use Illuminate\Http\Request;

class SomeCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return SomeCase::with('name')->with('article')->with('pictures')->paginate(10);
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
        $case = new SomeCase;
        $case->name_id = $request->name['id'];
        $case->article_id = $request->article['id'];
        $case->save();
        $pictures = [];
        foreach ($request->pictures as $picture) $pictures[] = ['picture_id'=>$picture['id']];
        $case->pictures()->attach($pictures);
        return response()->json(['message'=>'ok','id'=>$case->id]);
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
        $case = SomeCase::find($id);
        $name = $request->name;
        $case->name_id = $name['id'];
        if (isset($request->article))  $case->article_id = $request->article['id'];
        $pictures = [];
        foreach ($request->pictures as $picture) $pictures[] = $picture['id'];
        $case->pictures()->sync($pictures);
        $case->save();
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
    }
}
