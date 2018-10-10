<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\tms;
use App\Http\Resources\tms as tmsResource;

class TMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tms = tms::orderBy("id", "DESC")->paginate(13);
        return tmsResource::collection($tms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tms = $request->isMethod('put') ? tms::findOrFail($request->input('id')) : new tms;
        $tms->name = $request->input('name');
        $tms->sname = $request->input('sname');
        if($tms->save()) {
            return new tmsResource($tms);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tms = TMS::find($id);

        return response()->json($tms);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $tms = TMS::find($id);
        $tms->name = $request->get('name');
        $tms->update();

        return response()->json($tms);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TMS::find($id)->delete();

        return response()->json('TMS Deleted');
    }

    public function total()
    {
        $tms = tms::all();
        return response()->json($tms);
    }
}
