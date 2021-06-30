<?php

use App\Models\ArmEngine;
use App\Models\MotorDirection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/control-panel', function () {
    $engines = ArmEngine::all();
    $mr = MotorDirection::first();
    return view('controlPanel', ['engines' => $engines, 'mr' => $mr]);
});

Route::post('/control-panel/update', function (Request $request) {
    $newEnginesData = collect($request->input('engines'));
    $engines = ArmEngine::all();
    foreach ($engines as $engine) {
        $engine->update(['value' => $newEnginesData->firstWhere('id', $engine->id)['value']]);
        $engine->save();
    }
    return response()->json(['engines'=> $engines]);
});

Route::post('/control-panel/toggleOnOff', function (Request $request) {
    $isOn = $request->input('isOn');
    $engines = ArmEngine::all();
    foreach ($engines as $engine) {
        $engine->update(['isOn' => $isOn]);
        $engine->save();
    }
    return response()->json(['engines'=> $engines]);
});

Route::post('/control-panel/updateDirection', function (Request $request) {
    $direction = $request->input('direction');
    $mr = MotorDirection::first();
    $mr->update(['direction' => $direction]);
    return response()->json(['mr'=> $mr]);
});

Route::get('/result-panel', function() {
    $engines = ArmEngine::all();
    $mr = MotorDirection::first();
    return view('resultsPanel', ['engines' => $engines, 'mr' => $mr]);
});
