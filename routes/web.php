<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::httpmethod('/url', [namaController::namaFunction])->name('name_route');
// httpmethod :
// get -> mengambil data
// post -> menambahkan data
// patch/put -> mengubah data
// delete -> menghapus data
// /url dan name() harus beda/unique

// Basic route example

// Guest routes
Route::middleware(['IsGuest'])->group(function () {
    Route::get('/', [UsersController::class, 'login'])->name('login');
    Route::post('/login/auth', [UsersController::class, 'loginAuth'])->name('login.auth');
});

Route::get('/error-permission', function() {
    return view('errors.permission');
})->name('errors.permission');

// Authenticated routes
Route::middleware(['isLogin'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');
    Route::get('/logout', [UsersController::class, 'logout'])->name('logout');
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing-page');
});

    // Admin routes
    Route::middleware([  'IsAdmin'])->group(function () {
        // Medicine routes
        Route::get('/orders/admin', [OrderController::class, 'indexAdmin'])->name('orders.admin');
        Route::get('/orders/export/excel', [OrderController::class, 'exportExcel'])->name('orders.export.excel');
        Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines');
        Route::get('/medicines/add', [MedicineController::class, 'create'])->name('medicines.add');
        Route::post('/medicines/add', [MedicineController::class, 'store'])->name('medicines.add.store');
        Route::delete('/medicines/delete/{id}', [MedicineController::class, 'destroy'])->name('medicines.delete');
        Route::get('/medicines/edit/{id}', [MedicineController::class, 'edit'])->name('medicines.edit');
        Route::patch('/medicines/edit/{id}', [MedicineController::class, 'update'])->name('medicines.edit.update');
        Route::put('/medicines/update-stok/{id}', [MedicineController::class, 'stockEdit'])->name('medicines.update');
        
        // User routes
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::get('/users/add', [UsersController::class, 'create'])->name('users.add');
        Route::post('/users/add', [UsersController::class, 'store'])->name('users.add.store');
        Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');
        Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::patch('/users/edit/{id}', [UsersController::class, 'update'])->name('users.edit.update');
    });

    Route::middleware(['isLogin', 'isKasir'])->group(function() {
        Route::get('/orders/index', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store',[OrderController::class, 'store'])->name('orders.store');
        //struk pake path dinamis {id} karna akan menampilkan 1 data spesifik pembelian pake resources show karna sesuai
        //dengan fungsinhya, menampilkan 1 data spesifik
        Route::get('/orders/struk/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/download/{id}', [OrderController::class, 'download'])->name('orders.download');
    });

            // Medicine routes
            // Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines');
            // Route::get('/medicines/add', [MedicineController::class, 'create'])->name('medicines.add');
            // Route::post('/medicines/add', [MedicineController::class, 'store'])->name('medicines.add.store');
            // Route::delete('/medicines/delete/{id}', [MedicineController::class, 'destroy'])->name('medicines.delete');
            // Route::get('/medicines/edit/{id}', [MedicineController::class, 'edit'])->name('medicines.edit');
            // Route::patch('/medicines/edit/{id}', [MedicineController::class, 'update'])->name('medicines.edit.update');
            // Route::put('/medicines/update-stok/{id}', [MedicineController::class, 'stockEdit'])->name('medicines.update');
    
            // // User routes
            // Route::get('/users', [UsersController::class, 'index'])->name('users');
            // Route::get('/users/add', [UsersController::class, 'create'])->name('users.add');
            // Route::post('/users/add', [UsersController::class, 'store'])->name('users.add.store');
            // Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');
            // Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
            // Route::patch('/users/edit/{id}', [UsersController::class, 'update'])->name('users.edit.update');

