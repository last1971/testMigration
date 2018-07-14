<?php

namespace App\Http\Controllers;

use App\Firm;
use Illuminate\Http\Request;

class FirmController extends Controller
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
        $query = Firm::join('names','name_id','=','names.id')->select('firms.*','names.alias')->with('name');
        if (isset($request->q))
            $query = $query->where('names.alias', 'like', '%' .  preg_replace('/[^а-яёА-ЯЁa-zA-Z0-9]/', '', $request->q ) . '%');
        if ($request->ac)
            return $query->orderBy('names.alias','ASC')->limit($per_page)->get();
        return $query->orderBy('names.alias','ASC')->paginate($per_page);
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
        $firm = new Firm;
        $firm->name_id = $request->name['id'];
        $firm->full_name = $request->full_name;
        $firm->inn = $request->inn;
        $firm->kpp = $request->kpp;
        $firm->own = $request->own;
        $firm->save();
        return response()->json(['message'=>'ok','id'=>$firm->id]);

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
            $firms = Firm::join('names','firms.name_id','=','names.id')->where('names.name','=',request()->name);
            if ($firms->count() == 1)
            {
                return $firms->get()->first();
            } else {
                return response()->json(['id' => 0]);
            }
        }
        return Firm::find($id);
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
        $this->validate($request, [
            'full_name' => 'required',
            'inn' => 'required',
            'kpp' => 'required',
            'own' => 'required',
        ]);
        if ($id == 0) return $this->store($request);
        $this->validate($request, [
            'name.id' => 'required|gt:0',
        ]);
        $firm = Firm::find($id);
        $name = $request->name;
        $firm->name_id = $name['id'];
        $firm->full_name = $request->full_name;
        $firm->inn = $request->inn;
        $firm->kpp = $request->kpp;
        $firm->own = $request->own;
        $firm->save();
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
        return Firm::destroy($id);
    }
}
