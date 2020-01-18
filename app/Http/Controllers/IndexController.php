<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Service;
use App\Portfolio;
use App\People;
use Illuminate\Support\Facades\DB;
use Mail;

class IndexController extends Controller
{
    public function execute(Request $request){

        if($request->isMethod('post')){

            $messages=[
                'required'=>"Поле :attribute обязательно к заполнению!",
                'email'=>"Введите :attribute действительный электронный адрес!",
            ];

            $this->validate($request,[
            'name'=>'required|max:255',
            'email'=>'required|email',
            'text'=>'required',
                'g-recaptcha-response'=>'required',
            ],$messages);


            $data=$request->all();
            Mail::send( 'site.email',['data'=>$data],function ($message) use ($data){
                $message->to('fastfighter92@gmail.com')->subject('Письмо с сайта');
                $message->from('mamkin.raketchik@mail.ru',$data['name']);
            });

            $request->session()->flash('status', 'Письмо отправлено');
            return redirect()->route('home');


        }
        $pages=Page::all();
        $portfolios=Portfolio::all();
        $services=Service::all();
        $peoples=People::all();
        $tags=DB::table('portfolios')->distinct()->pluck('filter');
        //dd($request);
        //dd($pages,$portfolios,$services,$peoples);
        $menu=array();
        foreach($pages as $page){
            $item=array('title'=>$page->name,'alias'=>$page->alias);
            array_push($menu,$item);
        }
        $item=array('title'=>'Services','alias'=>'service');
        array_push($menu,$item);
        $item=array('title'=>'Portfolio','alias'=>'Portfolio');
        array_push($menu,$item);
        $item=array('title'=>'Team','alias'=>'team');
        array_push($menu,$item);
        $item=array('title'=>'Contacts','alias'=>'contact');
        array_push($menu,$item);
        //dd($menu);
        return view('site.index',array(
            'menu'=>$menu,
            'pages'=>$pages,
            'portfolios'=>$portfolios,
            'services'=>$services,
            'peoples'=>$peoples,
            'tags'=>$tags,
        ));
    }

}
