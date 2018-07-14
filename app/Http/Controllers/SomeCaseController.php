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
    public function index(Request $request)
    {
        $per_page = 10;
        if ($request->per_page)
            $per_page = $request->per_page;
        $query = SomeCase::join('names','name_id','=','names.id')->select('some_cases.id','some_cases.name_id','some_cases.article_id','some_cases.picture_id','names.alias')
            ->with('picture','pictures','name','article','article.name');
        if (isset($request->q))
            $query = $query->where('names.alias', 'like','%' . mb_ereg_replace('[^0-9A-Za-zА-Яа-я]', '', request()->q ) . '%');
        if ($request->ac) {
            $query = $query->whereNotIn('some_cases.id', function ($subquery) {
                $subquery->select('some_case_id')->from('some_case_aliases');
            });
            return $query->orderBy('names.alias', 'ASC')->limit($per_page)->get();
        }
        return $query->paginate($per_page);

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
        if (isset($request->article['id']) && $request->article['id']>0) $case->article_id = $request->article['id'];
        if ($request->picture_id != null) $case->picture_id = $request->picture_id;
        $case->save();
        $pictures = [];
        if (isset($request->pictures)) {
            foreach ($request->pictures as $picture) $pictures[] = ['picture_id' => $picture['id']];
            $case->pictures()->attach($pictures);
        }
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
        if ($id == 0) {
            $cases = SomeCase::join('names','some_cases.name_id','=','names.id')->where('names.name','=',request()->name);
            if ($cases->count() == 1)
            {
                return $cases->get()->first();
            } else {
                return response()->json(['id' => 0]);
            }
        }
        return SomeCase::find($id);

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
        if (isset($request->article) && $request->article['id']>0)  $case->article_id = $request->article['id'];
        if ($request->picture_id != null) $case->picture_id = $request->picture_id;
        $pictures = [];
        if (isset($request->pictures)) {
            foreach ($request->pictures as $picture) $pictures[] = $picture['id'];
            $case->pictures()->sync($pictures);
        }
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
        return SomeCase::destroy($id);
    }
}
