<?php

use App\Models\Material;
use App\Models\Production;
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

Route::get('/form', function () {
    $materials = Material::all();
    return view('form', compact('materials'));
});

Route::post('/add/production', function (Request $request) {
    $validated=$request->validate([
        'name' => 'required',
        'description' => 'required',
        'end_date' => 'required',
        'input_quantity' => 'required',
        'material_id' => 'required',
        'output_quantity' => 'required',
    ]);
    $validated['status'] = 'started';

    $data=[
        'production_name' => $validated['name'],
        'production_description' => $validated['description'],
        'production_status' => $validated['status'],
        'production_projected_end_date' => $validated['end_date'],
        'production_input_quantity' => $validated['input_quantity'],
        'production_material_id' => $validated['material_id'],
        'production_output_quantity' => $validated['output_quantity'],
    ];

    Production::create($data);
    return redirect()->back()->with('success', 'Production created successfully');
});