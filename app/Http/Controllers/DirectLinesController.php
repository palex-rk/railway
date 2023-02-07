<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\DirectLine;
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
        $data['all_sources'] = City::whereHas('sources')
            ->get()
            ->pluck('name');

        $data['all_destinations'] = City::whereHas('destinations')
            ->get()
            ->pluck('name');

        return view("direct_lines.index", compact('data'));
        // return response()->json(['data' => [$data], 'msg' => 'it works.']);
    }

    public function startingPoints(Request $request)
    {
        $request->validate([
            'term' => 'required|alpha|min:3'
        ]);

        $term = $request->term;
        
        /* USING JOIN
        $data = DB::table('cities')
             ->join('direct_lines', 'cities.id', '=', 'direct_lines.source_city_id')
             ->where('cities.name', 'LIKE', '%' . $term . '%')
             ->select('cities.id', 'cities.name')
             ->get()
             ->unique();
        */
        $data = City::whereHas('sources')
            ->where('cities.name', 'LIKE', '%' . $term . '%')
            ->get();

        return response()->json(['cities' => $data], 200);
    }

    public function destinationPoints(Request $request)
    {
        $request->validate([
            'term' => 'nullable|alpha',
            'starting_point' => 'required|alpha'
        ]);

        $term = $request->term;
        $starting_point_id = City::where('name', 'LIKE', '%' . $request->starting_point . '%')->select('id')->first()->id;
 
        /* USING JOIN
         $data = DB::table('cities')
             ->join('direct_lines', 'cities.id', '=', 'direct_lines.destination_city_id')
             ->where('direct_lines.source_city_id', '=', $starting_point_id)
             ->where('cities.name', 'LIKE', '%' . $request->term . '%')
             ->select('cities.name', 'cities.id')
             ->get();
        */

        $data = City::whereHas('sources', function($query) use ($term, $starting_point_id) {
            $query->where('cities.name', 'LIKE', '%' . $term . '%')
                ->where('direct_lines.source_city_id', '=', $starting_point_id);
        })
        ->get();

        return response()->json(['cities' => $data], 200);
    }

    public function results(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'source_city' => 'required|integer',
            'destination_city' => 'required|integer'
        ]);

        $source_id = $request->source_city;
        $dest_id = $request->destination_city;

        $data['start_point'] = City::where('id', $source_id)->first()->name;
        $data['dest_point'] = City::where('id', $dest_id)->first()->name;
        $data['termins'] = DirectLine::where('source_city_id', $source_id)
            ->where('destination_city_id', $dest_id)
            ->select('termin')
            ->get()
            ->toArray();

        return response()->json($data, 200);
    }
}
