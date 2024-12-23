<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CustomerController;
use app\Http\Controllers\API\V1\InvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


Route::get('/', function () {
    return view('welcome');
});

Route::group(
    ['prefix' => 'v1'], function() {
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('invoices', InvoiceController::class);
   });
   Route::get('/setup', function() {

   $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password'
    ];

 //   dd($credentials);

    if(!Auth::attempt($credentials)) {
 //       dd(vars: 'ewew');
        $user = new App\Models\User();

        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);

        $user->save();

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
            $updateToken = $user->createToken('update-token', ['create', 'update']);
            $basicToken = $user->createToken('basic-token');

            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken
            ];
        }
    }
});
