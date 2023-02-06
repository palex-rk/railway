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
        $data = DB::table('cities')
            ->join('direct_lines', 'cities.id', '=', 'direct_lines.source_city_id')
            ->where('cities.name', 'LIKE', '%' . $term . '%')
            ->select('cities.id', 'cities.name')
            ->get()
            ->unique();

        return response()->json(['cities' => $data], 200);
    }

    public function destinationPoints(Request $request)
    {
        $request->validate([
            'term' => 'nullable|alpha',
            'starting_point' => 'required|alpha'
        ]);

        $starting_point_id = City::where('name', 'LIKE', '%' . $request->starting_point . '%')->select('id')->first()->id;
 
        $data = DB::table('cities')
            ->join('direct_lines', 'cities.id', '=', 'direct_lines.destination_city_id')
            ->where('direct_lines.source_city_id', '=', $starting_point_id)
            ->where('cities.name', 'LIKE', '%' . $request->term . '%')
            ->select('cities.name', 'cities.id')
            ->get();

        // dd($data);

        return response()->json(['cities' => $data], 200);
    }

    public function results(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'source_city' => 'required|integer',
            'destination_city' => 'required|integer'
        ]);
        $source_city = City::findOrFail($request->source_city);
        $destination_city = City::findOrFail($request->destination_city);

        $data = DB::table('direct_lines')
            ->where('source_city_id', $source_city->id)
            ->where('destination_city_id', $destination_city->id)
            ->get();
        dd($data);
    }
}
