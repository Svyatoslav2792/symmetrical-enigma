<?php

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


Route::group([],function(){
    Route::match(['get','post'],'/',['uses'=>'IndexController@execute','as'=>'home']);
    //Route::get('/',['uses'=>'IndexController@execute','as'=>'home']);
    //Route::post('/',['uses'=>'IndexController@execute','as'=>'homeporn']);
    Route::get('/page/{alias}',['uses'=>'PageController@execute','as'=>'page']);
});
//admin
Route::group(['prefix'=>'admin','middleware'=>'auth'],function(){
    Route::get('/',function(){
        if(view()->exists('admin.index'))
        {
            $data=['title'=>'Панель администратора'];
            return view('admin.index',$data);
        }
    });
    //admin/pages
    Route::group(['prefix'=>'pages'],function (){
        Route::get('/',['uses'=>'PagesController@execute','as'=>'pages']);
        //admin/pages/add
        Route::match(['get','post'],'/add',['uses'=>'PagesAddController@execute','as'=>'pagesAdd']);
        //admin/pages/edit/{pageID}
        Route::match(['get','post','delete'],'/edit/{page}',['uses'=>'PagesEditController@execute','as'=>'pagesEdit']);
    });

    //admin/portfolios
    Route::group(['prefix'=>'portfolios'],function (){
        Route::get('/',['uses'=>'PortfoliosController@execute','as'=>'portfolio']);
        //admin/portfolios/add
        Route::match(['get','post'],'/add',['uses'=>'PortfoliosAddController@execute','as'=>'portfolioAdd']);
        //admin/portfolios/edit/{portfoliosID}
        Route::match(['get','post','delete'],'/edit/{portfolio}',['uses'=>'PortfoliosEditController@execute','as'=>'portfolioEdit']);
    });

    //admin/services
    Route::group(['prefix'=>'services'],function (){
        Route::get('/',['uses'=>'ServicesController@execute','as'=>'services']);
        //admin/services/add
        Route::match(['get','post'],'/add',['uses'=>'ServicesAddController@execute','as'=>'serviceAdd']);
        //admin/services/edit/{servicesID}
        Route::match(['get','post','delete'],'/edit/{service}',['uses'=>'ServicesEditController@execute','as'=>'serviceEdit']);
    });
});

Auth::routes();

