<?php

use App\Models\ArmEngine;
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
    $engines = ArmEngine::all();
    return view('systemControl', ['engines' => $engines]);
});

Route::post('/system-control/update', function (Request $request) {
    $newEnginesData = collect($request->input('engines'));
    $engines = ArmEngine::all();
    foreach ($engines as $engine) {
        $engine->update(['value' => $newEnginesData->firstWhere('id', $engine->id)['value']]);
        $engine->save();
    }
    return response()->json(['engines'=> $engines]);
});

Route::post('/system-control/toggleOnOff', function (Request $request) {
    $isOn = $request->input('isOn');
    $engines = ArmEngine::all();
    foreach ($engines as $engine) {
        $engine->update(['isOn' => $isOn]);
        $engine->save();
    }
    return response()->json(['engines'=> $engines]);
});