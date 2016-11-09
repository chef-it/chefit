<?php

namespace App\Http\Controllers;

use App\Classes\DesignHelper;
use App\MasterList;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class MasterListPriceTrackingController extends Controller
{

    /**
     * Instantiate a new MasterListController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $masterlist = Auth::user()->masterlist()->with('unit', 'priceTracking.unit')->find($id)
            ? : exit(redirect()->route('masterlist.index'));
        
        return view('masterlist.pricetracking.index')
            ->withMasterlist($masterlist)
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Not used, redirect to index.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return redirect()->route('masterlist.pricetracking.index', $id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        return redirect()->route('masterlist.pricetracking.index', $id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('masterlist.pricetracking.index', $id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('masterlist.pricetracking.index', $id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->route('masterlist.pricetracking.index', $id);
    }
}
