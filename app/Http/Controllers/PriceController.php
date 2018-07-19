<?php

namespace App\Http\Controllers;

use App\Position;
use App\Price;
use App\Availibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = null;
        if ($request->t1)
        {
            $query = Availibility::join('positions','positions.id','=','availibilities.position_id')
                ->select('availibilities.*')
                ->with(['store.name',
                    'prices' => function($query){
                        $query
                            ->select('prices.*', DB::raw('(SELECT value FROM exchange_rates WHERE exchange_rates.valute_id=prices.valute_id) * prices.value AS price'))
                            ->where('enabled','=',1);
                    }]
                )
                ->where('positions.product_id','=',$request->product_id);
        } else {
            $query = Price::join('availibilities', 'availibilities.id', '=', 'prices.availibility_id')
                ->select('prices.*', DB::raw('(SELECT value FROM exchange_rates WHERE exchange_rates.valute_id=prices.valute_id) * prices.value AS price'))
                ->where('availibilities.id', '=', $request->availibility_id)
                ->orderBy('prices.maximum');
        }
        return $query->get();
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
