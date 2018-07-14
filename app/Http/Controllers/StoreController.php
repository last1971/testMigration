<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
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
        $query = Store::join('names','name_id','=','names.id')->select('stores.*','names.alias')->with('name')->where('firm_id','=',$request->firm_id);
        if ($request->ac)
            return $query->orderBy('names.alias','ASC')->limit($per_page)->get();
        return $query->orderBy('names.alias','ASC')->get();
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
        $store = new Store;
        $store->name_id = $request->name['id'];
        $store->firm_id = $request->firm_id;
        $store->save();
        return response()->json(['message'=>'ok','id'=>$store->id]);
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
        $store = Store::find($id);
        $name = $request->name;
        $store->name_id = $name['id'];
        $store->firm_id = $request->firm_id;
        $store->save();
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
