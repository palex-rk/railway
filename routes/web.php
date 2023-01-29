<?php

use Carbon\Carbon;
use App\Models\City;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectLinesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [DirectLinesController::class, 'index']);
Route::post('source-cities', [DirectLinesController::class, 'startingPoints'])->name('start-point');
Route::get('123', function(){
    // $cities = City::all()->update(['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    DB::table('DIRECT_LINES')->update(['created_at' =>Carbon::now(), 'updated_at' => Carbon::now()]);
});