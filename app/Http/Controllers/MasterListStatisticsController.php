<?php

namespace App\Http\Controllers;

use App\Classes\DesignHelper;
use App\MasterList;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class MasterListStatisticsController extends Controller
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
        $masterlist = Auth::user()->masterlist()->findOrFail($id);

        return view('masterlist.statistics.index')
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
        return redirect()->route('masterlist.statistics.index', $id);
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
        return redirect()->route('masterlist.statistics.index', $id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('masterlist.statistics.index', $id);
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
        return redirect()->route('masterlist.statistics.index', $id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->route('masterlist.statistics.index', $id);
    }
}
