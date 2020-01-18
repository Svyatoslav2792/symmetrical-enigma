<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Validator;

class ServicesAddController extends Controller
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
                'text'=>'required',
            ],$messages);
            if($validator->fails())
            {
                return redirect()->route('serviceAdd')->withErrors($validator)->withInput($input);
            }
            if(!$request->has('icon')) {
                $input['icon']='No icon';
            }
            $services=new Service($input);
            // для того чтобы вносить изменения в таблицу- нужно либо добвать
            //поля разрешенные к заполнению в переменную fillable в модели либо использовать
            //$page->unguard();
            if($services->save())
            {
                return redirect('admin')->with('status','Сервис добавлен');
            }

        }

        if(view()->exists('admin.services_add')){
            //Выбираем из файла шрифтов названия иконок
            $filename='D:\Downloads\Open Server 5.3.5\OSPanel\domains\landing\public\assets\css\font-awesome.css';
            $file=file_get_contents($filename);
            $pattern = '/.(.*?):before/';
            $icon_list=array();
            $file_length=mb_substr_count($file,':before');
            for($i=0;$i<$file_length;$i++)
            {
                preg_match($pattern, $file, $matches);
                $icon_list[$i]=$matches[1];
                $position=strlen($matches[1])+strpos($file, $matches[1]);
                $file=substr($file, $position);
            }

            $data=[
                'title'=>'Новый сервис',
                'icon_list'=>$icon_list,
            ];

            return view('admin.services_add',$data);
        }


        else {
            abort(404);
        }
    }
}
