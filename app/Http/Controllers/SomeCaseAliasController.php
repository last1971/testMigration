<?php

namespace App\Http\Controllers;

use App\SomeCase;
use App\SomeCaseAlias;
use Illuminate\Http\Request;

class SomeCaseAliasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return SomeCase::join('some_case_aliases','some_case_aliases.some_case_id','=','some_cases.id')
            ->select('some_cases.*')->with('name')->where('some_case_aliases.master_id','=',$request->master_id)->get();
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
        $alias = new SomeCaseAlias;
        $alias->master_id = $request->master_id;
        $alias->some_case_id = $request->id;
        $alias->save();
        return response()->json(['message'=>'ok','id'=>$alias->id]);
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
        $alias = SomeCaseAlias::where('some_case_id','=',$id)->first();
        return SomeCaseAlias::destroy($alias->id);
    }
}
