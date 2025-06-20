<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    $users = User::with('address')->paginate(10);
    return view('user.index', compact('users'));
});

Route::get('/form', function () {
    return view('user.form');
});
