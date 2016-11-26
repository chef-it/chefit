<?php

namespace App\Http\Controllers;

use App\Classes\DesignHelper;
use App\Classes\Math;
use App\Conversion;
use App\MasterList;
use App\Recipe;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class ConversionController extends Controller
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
        $conversion = Auth::user()->masterlist()->find($id)->conversion()->first();

        if (count($conversion) > 0) {
            return redirect()->route(
                'masterlist.conversions.edit',
                ['masterlist' => $id, 'conversion' => $conversion->id]
            );
        } else {
            return redirect()->action(
                'ConversionController@create', ['id' => $id]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $masterlist = Auth::user()->masterlist()->findOrFail($id);
        return view('masterlist.conversions.create')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withMasterlist($masterlist);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreMasterListConversion $request, $masterlistid)
    {
        $masterlist = Auth::user()->masterlist()->find($masterlistid);

        $conversion = new Conversion();

        $conversion->master_list_id = $masterlistid;
        $conversion->left_quantity = $request->left_quantity;
        $conversion->left_unit = $request->left_unit;
        $conversion->right_quantity = $request->right_quantity;
        $conversion->right_unit = $request->right_unit;
        $conversion->user_id = Auth::user()->id;

        $conversion->save();

        return redirect()->route(
            'masterlist.conversions.edit',
            ['masterlist' => $masterlistid, 'conversion' => $conversion->id]
        );
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('masterlist.conversions.index', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get Master List and Conversion by user or return to index if not found.
        $masterlist = Auth::user()->masterlist()->findOrFail($id);
        $conversion = Auth::user()->masterlist()->findOrFail($id)->conversion()->first();
        $conversion->left_quantity += 0;
        $conversion->right_quantity += 0;

        return view('masterlist.conversions.edit')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withConversion($conversion)
            ->withMasterlist($masterlist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreMasterListConversion $request, $masterlist, $id)
    {
        $conversion = Auth::user()->masterlist()->find($masterlist)->conversion()->firstOrFail();

        $conversion->left_quantity = $request->left_quantity;
        $conversion->left_unit = $request->left_unit;
        $conversion->right_quantity = $request->right_quantity;
        $conversion->right_unit = $request->right_unit;

        $conversion->save();

        return redirect()->route(
            'masterlist.conversions.edit',
            ['masterlist' => $masterlist, 'conversion' => $id]
        );
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect('/');
    }
}
