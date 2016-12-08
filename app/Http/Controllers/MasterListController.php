<?php

namespace App\Http\Controllers;

use App\Classes\Controller\MasterListHelper;
use App\MasterList;
use App\Classes\DesignHelper;
use Auth;

use App\Http\Requests;

class MasterListController extends Controller
{

    protected $helper;

    /**
     * Instantiate a new MasterListController instance.
     */
    public function __construct(MasterListHelper $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
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
    public function store(Requests\StoreMasterList $request, MasterList $masterlist)
    {
        $this->helper->store($masterlist, $request);

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
    public function edit(MasterList $masterlist)
    {
        $this->authorize('edit', $masterlist);
        
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
    public function update(Requests\StoreMasterList $request, MasterList $masterlist)
    {
        $this->authorize('update', $masterlist);
        $this->helper->updatePriceTracking($masterlist, $request);
        $this->helper->store($masterlist, $request);
        
        return redirect()->route('masterlist.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterList $masterlist)
    {
        $this->authorize('destroy', $masterlist);
        $masterlist->delete();
        return redirect()->route('masterlist.index');
    }
}
