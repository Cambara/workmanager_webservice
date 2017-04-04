<?php

namespace App\Http\Controllers\WorkTable;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Services\WorkTableService;

class WorkTableController extends Controller
{
    /**
    * @var WorkTableService
    */
    private $workTableService;

    public function __construct(WorkTableService $workTableService)
    {
        $this->workTableService = $workTableService;
    }

    public function store(Request $request)
    {
        $resp = $this->workTableService->add($request->all());
        if(isset($resp['status_code']))
            return response()->json([$resp['result']], $resp['status_code']);
        return response()->json($resp['result']);
    }

    public function update(Request $request, $id)
    {
        $resp = $this->workTableService->update($id,$request->all());
        if(isset($resp['status_code']))
            return response()->json([$resp['result']], $resp['status_code']);
        return response()->json($resp['result']);
    }

    public function destroy($id)
    {
        $resp = $this->workTableService->delete($id);
        if(isset($resp['status_code']))
            return response()->json([$resp['result']], $resp['status_code']);
        return response()->json($resp['result']);
    }

    public function index($limit = 20)
    {
        $resp = $this->workTableService->list($limit);
        if(isset($resp['status_code']))
            return response()->json($resp['result'], $resp['status_code']);
        return response()->json($resp['result']);
    }

    public function show($id)
    {
        $resp = $this->workTableService->show($id);
        if(isset($resp['status_code']))
            return response()->json($resp['result'], $resp['status_code']);
        return response()->json($resp['result']);
    }
}