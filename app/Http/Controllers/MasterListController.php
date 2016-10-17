<?php

namespace app\Http\Controllers;

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
        $this->middleware('ownership', ['only' => ['edit', 'update', 'destroy']]);
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
        return view('masterlist.index')->withMasterlist($masterlist);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masterlist.create')->withUnits(DesignHelper::UnitsDropDown());
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
        $masterlist->data = '[]';
        $masterlist->owner = Auth::user()->id;

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
            ->withUnits(DesignHelper::UnitsDropDown());
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

        $masterlist->name = $request->input('name');
        $masterlist->price = $request->input('price');
        $masterlist->ap_quantity = $request->input('ap_quantity');
        $masterlist->ap_unit = $request->input('ap_unit');
        $masterlist->yield = $request->input('yield');
        $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);

        $masterlist->save();

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
