<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;

class PortfoliosController extends Controller
{   public function execute(){
    if(view()->exists('admin.portfolios')){
        $portfolios=Portfolio::all();
        $data=[
            'title'=>'Портфолио',
            'portfolios'=>$portfolios,

        ];
        return view('admin.portfolios',$data);
    }
    else {
        abort(404);
    }
}
    //
}
