<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\DirectLines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectLinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_sources'] = DB::table('cities')->join('direct_lines', 'cities.id', '=', 'direct_lines.source_city_id')->get()->pluck('name')->unique();
        $data['all_destinations'] = DB::table('cities')->join('direct_lines', 'cities.id', '=', 'direct_lines.destination_city_id')->get()->pluck('name')->unique();;

        return response()->json(['data' => [$data], 'msg' => 'it works.']);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectLines  $directLines
     * @return \Illuminate\Http\Response
     */
    public function show(DirectLines $directLines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectLines  $directLines
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectLines $directLines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirectLines  $directLines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DirectLines $directLines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectLines  $directLines
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectLines $directLines)
    {
        //
    }
}
