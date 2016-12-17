<?php

namespace App\Http\Controllers;

use App\Classes\Controller\ConversionHelper;
use App\Classes\DesignHelper;
use App\Conversion;
use App\MasterList;
use Auth;

use App\Http\Requests;

class ConversionController extends Controller
{

    protected $helper;
    
    /**
     * Instantiate a new MasterListController instance.
     */
    public function __construct(ConversionHelper $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterList $masterlist)
    {
        $this->authorize('masterlist', $masterlist);

        if (count($masterlist->conversion) > 0) {
            return redirect()->route(
                'masterlist.conversions.edit',
                ['masterlist' => $masterlist->id, 'conversion' => $masterlist->conversion->id]
            );
        } else {
            return redirect()->action(
                'ConversionController@create', ['id' => $masterlist->id]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MasterList $masterlist)
    {
        $this->authorize('masterlist', $masterlist);
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
    public function store(
        Requests\StoreMasterListConversion $request,
        MasterList $masterlist,
        Conversion $conversion
    )
    {
        $this->authorize('masterlist', $masterlist);
        $this->helper->store($conversion, $request, $masterlist);

        return redirect()->route(
            'masterlist.conversions.edit',
            ['masterlist' => $masterlist->id, 'conversion' => $conversion->id]
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
    public function edit(MasterList $masterlist)
    {
        $this->authorize('masterlist', $masterlist);
        $conversion = $masterlist->conversion()->first();

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
    public function update(
        Requests\StoreMasterListConversion $request,
        MasterList $masterlist,
        Conversion $conversion
    )
    {
        $this->authorize('masterlist', $masterlist);
        $this->helper->store($conversion, $request, $masterlist);

        return redirect()->route(
            'masterlist.conversions.edit',
            ['masterlist' => $masterlist, 'conversion' => $conversion->id]
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
