<?php

namespace App\Http\Controllers;

use App\Name;
use Illuminate\Http\Request;

class NameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Name::where('alias','like','%' . preg_replace('/[^а-яёА-ЯЁa-zA-Z0-9]/', '', request()->q ) . '%')->orderBy('name')->get();
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
        $this->validate($request, [
            'name' => 'required',
        ]);
        $names = Name::where('name','=',request()->name);
        if ($names->count() == 1)
        {
            return $names->get()->first();
        }
        $name = new Name;
        $name->name = $request->name;
        $name->alias = mb_ereg_replace('/[^0-9A-Za-zА-Яа-я]/', '',$name->name);
        $name->save();
        return $name;
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
        $name=request()->name;
        if ($id == 0) {
            $names = Name::where('name','=',request()->name);
            if ($names->count() == 1)
            {
                return $names->get()->first();
            } else {
                return response()->json(['id' => 0]);
            }
        }
        return Name::find($id);
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
    }
}
