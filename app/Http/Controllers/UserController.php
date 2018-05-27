<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sortRules = request()->input('sort');
        $limit = request()->input('per_page');
        list($field, $dir) = explode('|', $sortRules);
        return User::orderBy($field, $dir)->paginate($limit);
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
        $user = User::find($id);
        return view('user.card',array('user'=>$user));
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
        $user = User::find($id);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'.($request->input('email') != $user->email ? '|unique:users':''),
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->first_name = $request->input('first_name');
        $user->second_name = $request->input('second_name');
        $user->patronymic_name = $request->input('patronymic_name');
        if (Auth::user() != null && Auth::user()->isAdmin()) $user->user_type_id = $request->input('user_type_id');
        $user->save();
        if ($request->ajax()) {
            return response()->json(['message'=>'ok']);
        } else {
            return Redirect::back()->with('user_update', ['Данные обновлены']);
        }
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
