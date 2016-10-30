<?php

namespace App\Http\Controllers;

use App\MasterListPriceTracking;
use App\Unit;
use Illuminate\Http\Request;
use App\MasterList;
use App\Classes\Math;
use App\Classes\DesignHelper;
use Auth;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class MasterListController extends Controller
{

    /**
     * Instantiate a new MasterListController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ownership', ['except' => ['index', 'create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterlist = MasterList::select('master_list.*', 'units.name as ap_unit')
            ->join('units', 'master_list.ap_unit', '=', 'units.id')
            ->where('master_list.owner', '=', Auth::user()->id)
            ->orderBy('master_list.name')
            ->get();
        return view('masterlist.index')
            ->withMasterlist($masterlist);
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
            ->withCategories(DesignHelper::MasterListCategoriesDropDown());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate


        //Store
        $masterlist = new MasterList();

        $masterlist->name = $request->name;
        $masterlist->price = $request->price;
        $masterlist->ap_quantity = $request->ap_quantity;
        $masterlist->ap_unit = $request->ap_unit;
        $masterlist->yield = $request->yield;
        $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);
        $masterlist->owner = Auth::user()->id;
        $masterlist->vendor = $request->input('vendor');
        $masterlist->category = $request->input('category');

        $masterlist->save();


        return redirect()->route('masterlist.index');
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
        $masterlist = MasterList::find($id);
        return view('masterlist.edit')
            ->withMasterlist($masterlist)
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withVendors(DesignHelper::VendorsDropDown())
            ->withCategories(DesignHelper::MasterListCategoriesDropDown());
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
        //Validate

        //Store
        $masterlist = MasterList::find($id);

        //Send current price data to price tracking before updating new data if there are any pricing changes
        if ($masterlist->price != $request->price ||
            $masterlist->ap_quantity != $request->ap_quantity ||
            $masterlist->ap_unit != $request->ap_unit
        ) {
            $pricetracking = new MasterListPriceTracking();

            $pricetracking->master_list = $id;
            $pricetracking->owner = Auth::user()->id;
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
        $masterlist->yield = $request->input('yield');
        $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);
        $masterlist->vendor = $request->input('vendor');
        $masterlist->category = $request->input('category');

        $masterlist->save();


        //Price Tracking


        //Redirect
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
        $masterlist = MasterList::find($id);
        $masterlist->delete();
        return redirect()->route('masterlist.index');
    }
}
