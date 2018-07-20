<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('check.employee')->except('index');
    }

    public function index(Request $request)
    {
        //
        $per_page = 10;
        if ($request->per_page)
            $per_page = $request->per_page;
        $query = Product::join('names','name_id','=','names.id')->leftJoin('some_case_aliases','products.some_case_id','=','some_case_aliases.some_case_id')
            ->select('products.*','some_case_aliases.master_id','names.alias',DB::raw('COALESCE(some_case_aliases.master_id,products.some_case_id) as some_case_id'))
            ->with('picture','pictures','name','article','article.name','producer','producer.name','some_case','some_case.name','some_case.picture','category','category.name');
        if (isset($request->addAvailibale))
            $query = $query->addSelect(
                DB::raw('(SELECT sum(availibilities.quantity_free) FROM availibilities,positions WHERE positions.id=availibilities.position_id AND positions.product_id=products.id) as availibale')
            );
        if (isset($request->addPrice))
            $query = $query->addSelect(
                DB::raw(
                    '(SELECT MIN(prices.value * (SELECT exchange_rates.value FROM exchange_rates WHERE exchange_rates.valute_id = prices.valute_id ORDER BY exchange_rates.updated_at DESC LIMIT 1)) 
                             FROM prices,availibilities,positions WHERE prices.availibility_id = availibilities.id AND positions.id=availibilities.position_id AND positions.product_id=products.id
                             AND availibilities.quantity_free>0) AS price'
                )
            );
        if (isset($request->filter))
            $query = $query->where('names.alias', 'like', '%' .  preg_replace('/[^а-яёА-ЯЁa-zA-Z0-9]/', '', $request->filter ) . '%');
        if ($request->ac)
            return $query->orderBy('names.alias','ASC')->limit($per_page)->get();
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
        $product = new Product;
        $product->name_id = $request->name['id'];
        if ($request->article['id']>0) $product->article_id = $request->article['id'];
        if ($request->picture_id != null) $product->picture_id = $request->picture_id;
        if ($request->some_case_id != null) $product->some_case_id = $request->some_case_id;
        if ($request->producer_id != null) $product->producer_id = $request->producer_id;
        $product->save();
        $pictures = [];
        foreach ($request->pictures as $picture) $pictures[] = ['picture_id'=>$picture['id']];
        $product->pictures()->attach($pictures);
        return response()->json(['message'=>'ok','id'=>$product->id]);
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
            $products = Product::join('names','name_id','=','names.id')->where('names.name','=',request()->name);
            if ($products->count() == 1)
            {
                return $products->get()->first();
            } else {
                return response()->json(['id' => 0]);
            }
        }
        return Product::find($id);
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
        $product = Product::find($id);
        $name = $request->name;
        $product->name_id = $name['id'];
        if (isset($request->article) && $request->article['id']>0)  $product->article_id = $request->article['id'];
        if ($request->picture_id != null) $product->picture_id = $request->picture_id;
        if ($request->some_case_id != null) $product->some_case_id = $request->some_case_id;
        if ($request->producer_id != null) $product->producer_id = $request->producer_id;
        if ($request->category_id != null) $product->category_id = $request->category_id;
        $pictures = [];
        foreach ($request->pictures as $picture) $pictures[] = $picture['id'];
        $product->pictures()->sync($pictures);
        $product->save();
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
        return Product::destroy($id);
    }
}
