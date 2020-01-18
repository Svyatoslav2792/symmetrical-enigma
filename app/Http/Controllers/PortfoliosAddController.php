<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use Validator;
class PortfoliosAddController extends Controller
{
    public function execute(Request $request){
        if($request->isMethod('post')){
            //dd($request);
            $input=$request->except('_token');
            $messages=[
                'required'=>'Поле :attribute обязательно к заполнению!',
                'unique'=>'Поле :attribute должно быть уникальным!',
            ];
            $validator=Validator::make($input,[
                'name'=>'required|max:255',
                'filter'=>'required|max:255',
            ],$messages);
            if($validator->fails())
            {
                return redirect()->route('portfolioAdd')->withErrors($validator)->withInput($input);
            }
            if($request->hasFile('images')) {
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img',$input['images']);
            }

            // для того чтобы вносить изменения в таблицу- нужно либо добвать
            //поля разрешенные к заполнению в переменную fillable в модели либо использовать
            //$page->unguard();

            if(!$request->has('images')) {
                $input['images']='No image';
            }

            $portfolio=new Portfolio($input);
            if($portfolio->save())
            {
                return redirect('admin')->with('status','Портфолио добавлено');
            }

        }

        if(view()->exists('admin.portfolios_add')){
            $data=[
                'title'=>'Новое портфолио',
            ];

            return view('admin.portfolios_add',$data);
        }


        else {
            abort(404);
        }
    }
}
