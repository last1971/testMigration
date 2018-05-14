<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 14.05.2018
 * Time: 12:01
 */
namespace App\Http\Controllers;

use App\mytest;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function show()
    {
        $test = mytest::all()->first();
        return view('test',array(
                'test'=>$test)
        );
    }
}