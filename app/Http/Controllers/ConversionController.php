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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $conversion = Conversion::where('master_list', '=', $id)->first();

        if (count($conversion) > 0){
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
        $masterlist = MasterList::select('name')->where('id', '=', $id)->first();
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
    public function store(Request $request, $masterlist)
    {
        // Validate

        $conversion = new Conversion();

        $conversion->master_list = $masterlist;
        $conversion->left_quantity = $request->left_quantity;
        $conversion->left_unit = $request->left_unit;
        $conversion->right_quantity = $request->right_quantity;
        $conversion->right_unit = $request->right_unit;
        $conversion->owner = Auth::user()->id;

        $conversion->save();

        return redirect()->route(
            'masterlist.conversions.edit',
            ['masterlist' => $masterlist, 'conversion' => $conversion->id]
        );
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
        $masterlist = MasterList::select('name')->where('id', '=', $id)->first();
        $conversion = Conversion::where('master_list', '=', $id)->first();
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
    public function update(Request $request, $masterlist, $id)
    {
        $conversion = Conversion::find($id);

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
