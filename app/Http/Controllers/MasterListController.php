<?php

namespace App\Http\Controllers;

use App\MasterListPriceTracking;
use Illuminate\Http\Request;
use App\MasterList;
use App\Classes\Math;
use App\Classes\DesignHelper;
use Auth;

use App\Http\Requests;

class MasterListController extends Controller
{

    /**
     * Instantiate a new MasterListController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Creates a collection of all master_list records owned by the user, attached with unit information tied to ap_unit
     * to pass to the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterlist = Auth::user()->masterlist()->with('unit')->get();
        foreach ($masterlist as $ingredient) {
            $ingredient->yield *= 100;
        }

        return view('masterlist.index')
            ->withMasterlist($masterlist)
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masterlist.create')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withVendors(DesignHelper::VendorsDropDown())
            ->withCategories(DesignHelper::MasterListCategoriesDropDown())
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreMasterList $request)
    {
        $masterlist = new MasterList();

        $masterlist->name = $request->name;
        $masterlist->price = $request->price;
        $masterlist->ap_quantity = $request->ap_quantity;
        $masterlist->ap_unit = $request->ap_unit;
        if ($request->yield > 1) {
            $masterlist->yield = $request->yield / 100;
        } else {
            $masterlist->yield = $request->yield;
        }
        $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);
        $masterlist->user_id = Auth::user()->id;
        $masterlist->vendor = $request->vendor;
        $masterlist->category = $request->category;

        $masterlist->save();


        return redirect()->route('masterlist.index');
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('masterlist.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $masterlist = Auth::user()->masterlist()->find($id)
            ? : redirect()->route('masterlist.index');

        return view('masterlist.edit')
            ->withMasterlist($masterlist)
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withVendors(DesignHelper::VendorsDropDown())
            ->withCategories(DesignHelper::MasterListCategoriesDropDown())
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreMasterList $request, $id)
    {
        $masterlist = Auth::user()->masterlist()->find($id) 
            ? : exit(redirect()->route(masterlist.index));

        //Send current price data to price tracking before updating new data if there are any pricing changes
        if ($masterlist->price != $request->price ||
            $masterlist->ap_quantity != $request->ap_quantity ||
            $masterlist->ap_unit != $request->ap_unit ||
            $masterlist->vendor != $request->vendor
        ) {
            $pricetracking = new MasterListPriceTracking();

            $pricetracking->master_list = $id;
            $pricetracking->user_id = Auth::user()->id;
            $pricetracking->price = $masterlist->price;
            $pricetracking->ap_quantity = $masterlist->ap_quantity;
            $pricetracking->ap_unit = $masterlist->ap_unit;
            $pricetracking->vendor = $masterlist->vendor;
            $pricetracking->created_at = $masterlist->updated_at;

            $pricetracking->save();
        }

        $masterlist->name = $request->input('name');
        $masterlist->price = $request->input('price');
        $masterlist->ap_quantity = $request->input('ap_quantity');
        $masterlist->ap_unit = $request->input('ap_unit');
        if ($request->yield > 1) {
            $masterlist->yield = $request->yield / 100;
        } else {
            $masterlist->yield = $request->yield;
        }
        $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);
        $masterlist->vendor = $request->input('vendor');
        $masterlist->category = $request->input('category');

        $masterlist->save();
        
        return redirect()->route('masterlist.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $masterlist = Auth::user()->masterlist()->find($id) 
            ? : exit(redirect()->route('masterlist.index'));
        $masterlist->delete();
        return redirect()->route('masterlist.index');
    }
}
