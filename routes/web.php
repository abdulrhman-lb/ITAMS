<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\const\CalssController;
use App\Http\Controllers\const\CategoryController;
use App\Http\Controllers\const\ModelController;
use App\Http\Controllers\const\BranchController;
use App\Http\Controllers\const\Sub_BranchController;
use App\Http\Controllers\const\DepartmentController;
use App\Http\Controllers\const\Hard_DiskController;
use App\Http\Controllers\const\MemoryController;
use App\Http\Controllers\const\ProcessorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\subController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\const\jop_titleController;
use App\Http\Controllers\const\StatusController;
use App\Http\Controllers\DatesController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('/employee', EmployeeController::class)->middleware('isrule');
Route::resource('/device', DeviceController::class)->middleware('isrule');
Route::resource('/user', UserController::class)->middleware('isadmin');
Route::post('/divece', [DeviceController::class, 'index'])->middleware('isadmin')->name('device_search');
Route::resource('/dates', DatesController::class);
Route::post('/dates', [DatesController::class, 'index'])->name('dates');
Route::post('/dates-add', [DatesController::class, 'index_add'])->name('dates-add');
Route::get('/export-dates',[DatesController::class,'exportdates'])->name('export-dates');







Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

route::prefix('const')->middleware('auth', 'isadmin')->group(function(){
    route::resource('/class',CalssController::class);
    route::resource('/category',CategoryController::class);
    route::resource('/model',ModelController::class);
    route::resource('/branch',BranchController::class);
    route::resource('/sub',Sub_BranchController::class);
    route::resource('/department',DepartmentController::class);
    route::resource('/hd',Hard_DiskController::class);
    route::resource('/mem',MemoryController::class);
    route::resource('/cpu',ProcessorController::class);
    route::resource('/title',jop_titleController::class);
    route::resource('/status',StatusController::class);
});



route::get('/get-sub', [subController::class, 'getsub']);
route::get('/get-category', [subController::class, 'getcategory']);
route::get('/get-model', [subController::class, 'getmodel']);

