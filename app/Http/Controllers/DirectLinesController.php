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

        return view("direct_lines.index", compact('data'));
        // return response()->json(['data' => [$data], 'msg' => 'it works.']);
    }

    public function startingPoints(Request $request)
    {
        $request->validate([
            'term' => 'required|alpha|min:3'
        ]);

        $term = $request->term;
        $data = DB::table('cities')->join('direct_lines', 'cities.id', '=', 'direct_lines.source_city_id')
            ->where('cities.name', 'LIKE', '%' . $term . '%')
            ->select('cities.id', 'cities.name')
            ->get()
            ->unique();

        return response()->json(['cities' => $data], 200);
    }

    public function destinationPoints(Request $request)
    {
        dd($request->all(), 'hi there');
        $request->validate([
            // 'term' => 'required|alpha',
            'starting_point' => 'required|alpha'
        ]);

        $data = DB::table('cities')->join('direct_lines', 'cities.id', '=', 'direct_lines.destination_city_id')
            ->where('direct_lines.source_city_id', '=', DB::raw("(SELECT id FROM cities WHERE cities.name = $request->startingpoint )"))
            ->get();
            //DB::raw("(SELECT status FROM task_user WHERE tasks.id = task_user.task_id AND user_id = $user_id) as user_task_status")

        return response()->json(['cities' => $data], 200);
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
