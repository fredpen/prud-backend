<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Oops You took a wrong turn, ensure you set accept header as application/json";
});
