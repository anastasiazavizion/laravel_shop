<?php

use App\Enum\WishListType;
use Illuminate\Support\Facades\Route;

//$pr = \Illuminate\Support\Facades\Cache::get('product_63');

//$pr2 = \App\Models\Product::find(63);

//dd($pr2->isWishedProduct(WishListType::EXIST->value));



//dd(/*$pr->is_in_wish_list_exist,$pr->is_in_wish_list_price,*/$pr2->is_in_wish_list_exist,$pr2->is_in_wish_list_price);


/*dd(Cache::get('products_page_1_1_params_d751713988987e9331980363e24189ce'));*/



Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
