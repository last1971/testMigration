<?php

namespace App\Http\Controllers;

use App\Producer;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = 10;
        if ($request->per_page)
            $per_page = $request->per_page;
        $query = Producer::join('names','name_id','=','names.id')->select('producers.*','names.alias')->with('picture','pictures','name','article','article.name');
        if (isset($request->q)) $query =
            $query->where('names.alias', 'like', '%' .  preg_replace('/[^а-яёА-ЯЁa-zA-Z0-9]/', '', $request->q ) . '%');
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
        $producer = new Producer;
        $producer->name_id = $request->name['id'];
        if ($request->article_id>0) $producer->article_id = $request->article_id;
        if ($request->picture_id != null) $producer->picture_id = $request->picture_id;
        $producer->save();
        $pictures = [];
        if ($request->pictures) {
            foreach ($request->pictures as $picture) $pictures[] = ['picture_id' => $picture['id']];
            $producer->pictures()->attach($pictures);
        }
        return response()->json(['message'=>'ok','id'=>$producer->id]);

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
            $producers = Producer::join('names','producers.name_id','=','names.id')->where('names.name','=',request()->name);
            if ($producers->count() == 1)
            {
                return $producers->get()->first();
            } else {
                return response()->json(['id' => 0]);
            }
        }
        return Producer::find($id);

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
        $producer = Producer::find($id);
        $name = $request->name;
        $producer->name_id = $name['id'];
        if (isset($request->article) && $request->article['id']>0)  $producer->article_id = $request->article['id'];
        if ($request->picture_id != null) $producer->picture_id = $request->picture_id;
        $pictures = [];
        if ($request->pictures) {
            foreach ($request->pictures as $picture) $pictures[] = $picture['id'];
            $producer->pictures()->sync($pictures);
        }
        $producer->save();
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
        return Producer::destroy($id);
    }
}
