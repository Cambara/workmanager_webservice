<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Services\BusinessService;

class BusinessController extends Controller
{
    /**
    * @var BusinessService
    */
    private $businessService;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
    }

    public function store(Request $request)
    {
        $resp = $this->businessService->add($request->all());
        if(isset($resp['status_code']))
            return response()->json([$resp['result']], $resp['status_code']);
        return response()->json($resp['result']);
    }

    public function update(Request $request, $id)
    {
        $resp = $this->businessService->update($id,$request->all());
        if(isset($resp['status_code']))
            return response()->json([$resp['result']], $resp['status_code']);
        return response()->json($resp['result']);
    }

    public function destroy($id)
    {
        $resp = $this->businessService->delete($id);
        if(isset($resp['status_code']))
            return response()->json([$resp['result']], $resp['status_code']);
        return response()->json($resp['result']);
    }

    public function index($limit = 20)
    {
        $resp = $this->businessService->list($limit);
        if(isset($resp['status_code']))
            return response()->json($resp['result'], $resp['status_code']);
        return response()->json($resp['result']);
    }
}