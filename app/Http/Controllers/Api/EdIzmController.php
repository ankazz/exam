<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\edizm;
use App\Http\Resources\EdIzm as EdIzmResource;

class EdIzmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edizm = edizm::orderBy("id", "DESC")->paginate(13);
        //return response()->json($edizm);

        // Return collection of articles as a resource
        return EdIzmResource::collection($edizm);

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
        $edizm = $request->isMethod('put') ? EdIzm::findOrFail($request->input('id')) : new EdIzm;
        $edizm->name = $request->input('name');
        $edizm->sname = $request->input('sname');
        if($edizm->save()) {
            return new EdIzmResource($edizm);
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
        $edizm = EdIzm::find($id);

        return response()->json($edizm);
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
        $edizm = EdIzm::find($id);
        $edizm->name = $request->get('name');
        $edizm->update();

        return response()->json($edizm);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EdIzm::find($id)->delete();

        return response()->json('EdIzm Deleted');
    }

    public function total()
    {
        $edizm = edizm::all();
        return response()->json($edizm);
    }
}
