<?php

namespace App\Http\Controllers\API;

use App\Classes\Controller\MasterListHelper;
use App\Classes\DesignHelper;
use App\Http\Requests\StoreMasterList;
use App\MasterList;
use Illuminate\Http\Request;

/**
 * Class MasterlistController
 * @package App\Http\Controllers\API
 */
class MasterlistController extends ApiController
{
    /**
     * @var MasterListHelper
     */
    protected $helper;

    /**
     * MasterlistController constructor.
     * @param $helper
     */
    public function __construct(MasterListHelper $helper)
    {
        $this->helper = $helper;
    }


    /**
     * @return mixed
     */
    public function index()
    {
        $user = $this->getUserFromToken();

        $response['data'] = $user->masterlist;
        $response['currencySymbol'] = DesignHelper::CurrencySymbol();

        return $response;
    }

    /**
     * @param MasterList $masterlist
     * @param Request $request
     */
    public function store(MasterList $masterlist, StoreMasterList $request)
    {
        $user = $this->getUserFromToken();
        $this->helper->store($masterlist, $request, $user);
    }

    /**
     * @param MasterList $masterlist
     */
    public function edit(MasterList $masterlist)
    {
        $this->authorize('masterlist', $masterlist);
    }
}
