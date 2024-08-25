<?php
use Illuminate\Support\Facades\Route;

Route::name('v1.')->prefix('v1')->group(function (){
  require __DIR__.'/versions/v1.php';
});

Route::name('v2.')->prefix('v2')->group(function (){
  require __DIR__.'/versions/v2.php';
});
