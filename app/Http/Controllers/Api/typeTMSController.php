<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\typeTMS;
use App\Http\Resources\Ttms as typeTMSResource;

class typeTMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ttms = typeTMS::with('tms','edizm')->orderBy("id", "DESC")->paginate(13);
        //return response()->json($ttms);
        return typeTMSResource::collection($ttms); 
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
        $ttms = $request->isMethod('put') ? TypeTMS::findOrFail($request->input('id')) : new TypeTMS;
        $ttms->name = $request->get('name');
        $ttms->tms_id = $request->get('tms_id');
        $ttms->edizm_id = $request->get('edizm_id');
        if($ttms->save()) {
            return new typeTMSResource($ttms);
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
        $ttms = TypeTMS::find($id);

        return response()->json($ttms);
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
        $ttms = TypeTMS::find($id);
        $ttms->name = $request->get('name');
        $ttms->tms_id = $request->get('tms_id');
        $ttms->edizm_id = $request->get('edizm_id');
        $ttms->update();

        return response()->json($ttms);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TypeTMS::find($id)->delete();

        return response()->json('TypeTMS Deleted');
    }
}
