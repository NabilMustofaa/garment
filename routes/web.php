<?php

use App\Http\Controllers\MaterialResource;
use App\Http\Controllers\processResource;
use App\Http\Controllers\ProcessTypeResource;
use App\Http\Controllers\productionResource;
use App\Http\Controllers\ProductionTypeResource;
use App\Http\Controllers\SubProcessResource;
use App\Http\Controllers\UserResource;
use App\Models\Material;
use App\Models\Production;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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


Route::resource('/material', MaterialResource::class);
Route::resource('/process', processResource::class);
Route::resource('/production', productionResource::class);
Route::resource('/subproses', SubProcessResource::class);
Route::resource('/user', UserResource::class);
Route::resource('/processtype', ProcessTypeResource::class);
Route::resource('/productiontype', ProductionTypeResource::class);
Route::put('/subproses/update/{subproses}', [SubProcessResource::class, 'updateQuantity']);
Route::delete('/subproses/history/{id}', [SubProcessResource::class, 'destroyHistory']);
Route::get('/generate/{id}', [processResource::class, 'generatePDF']);
Route::get('/print/{id}', [processResource::class, 'printPDF']);
Route::get('/change/{process}',[processResource::class,'change'] );
Route::put('/change/{process}',[processResource::class,'finish'] );
Route::get('/finished',[processResource::class,'finished'] );
