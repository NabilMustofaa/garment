<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaterialResource;
use App\Http\Controllers\processResource;
use App\Http\Controllers\ProcessTypeResource;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\productionResource;
use App\Http\Controllers\ProductionTypeResource;
use App\Http\Controllers\SubProcessResource;
use App\Http\Controllers\UserResource;
use App\Models\Material;
use App\Models\Production;
use App\Models\SubProcessHistory;
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
    return redirect('/login');
});

Route::get('/qr/test/{id}', function ($id) {
    $sh=SubProcessHistory::find($id);
    return view('process.processPDF', compact('id','sh'));
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile/indexprofile');
    });

    Route::resource('/material', MaterialResource::class);
    Route::get('/material/update/{material}', [MaterialResource::class, 'pageQuantity']);
    Route::post('/material/update/{material}', [MaterialResource::class, 'updateQuantity']);
    Route::resource('/process', processResource::class);
    Route::resource('/production', productionResource::class);
    Route::get('/production/{production}/size', [productionResource::class, 'createSize']);
    Route::post('/production/{production}/size', [productionResource::class, 'storeSize']);
    
    Route::get('/product/{product}', [ProductController::class, 'show']);
    Route::put('/product/{product}/update', [ProductController::class, 'update']);
    Route::get('product/print/{product}', [ProductController::class, 'printPDF']);

    Route::resource('/subproses', SubProcessResource::class);
    Route::get('/report/{id}', [SubProcessResource::class, 'reportPage']);
    Route::post('/report/{id}', [SubProcessResource::class, 'report']);
    Route::resource('/user', UserResource::class);
    Route::resource('/processtype', ProcessTypeResource::class);
    Route::resource('/productiontype', ProductionTypeResource::class);
    Route::put('/subproses/update/{subproses}', [SubProcessResource::class, 'updateQuantity']);
    Route::delete('/subproses/history/{id}', [SubProcessResource::class, 'destroyHistory']);
    Route::post('/submit/all', [SubProcessResource::class, 'submitAll']);
    Route::get('/generate/{id}', [processResource::class, 'generatePDF']);
    Route::get('/print/{id}', [processResource::class, 'printPDF']);
    Route::get('/change/{process}',[processResource::class,'change'] );
    Route::put('/change/{process}',[processResource::class,'finish'] );
    Route::get('/finished',[processResource::class,'finished'] );    
});