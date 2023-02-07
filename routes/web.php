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

Route::get('/', [DirectLinesController::class, 'index'])->name('index');

Route::prefix('ajax')->group(function(){
    Route::post('source-cities', [DirectLinesController::class, 'startingPoints'])->name('start-point');
    Route::post('destination-cities', [DirectLinesController::class, 'destinationPoints'])->name('destination-point');
});

Route::post('results', [DirectLinesController::class, 'results'])->name('results');

Route::get('123', function() {
    echo DB::table('cities')->update(['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);echo "<hr>";
    echo DB::table('direct_lines')->update(['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
});