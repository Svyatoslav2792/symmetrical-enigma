<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Validator;

class ServicesEditController extends Controller
{
    public function execute(Service $service,Request $request)
    {
        if($request->isMethod('delete')){
            if($service->delete())
            {
                return redirect('admin')->with('status','Сервис удален');
            }
        }

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
                return redirect()->route('serviceEdit',$input['id'])->withErrors($validator)->withInput($input);
            }

            //$page=new Page($input);
            $service->fill($input);
            // для того чтобы вносить изменения в таблицу- нужно либо добвать
            //поля разрешенные к заполнению в переменную fillable в модели либо использовать
            //$page->unguard();
            if($service->update())
            {
                return redirect('admin')->with('status','Сервис отредактирован');
            }

        }

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

        //$page=Page::find($id); //можно так находить требуемую страницу или так
        //как я сделал через внедрение зависимостей в атрибутах функции
        $old=$service->toArray();
        //dd($old);
        if(view()->exists('admin.services_edit')){
            $data=[
                'title'=>'Редактирование сервиса '.$old['name'],
                'data'=>$old,
                'icon_list'=>$icon_list,
            ];
            //dd($old);
            return view('admin.services_edit',$data);
        }
        else {
            abort(404);
        }

    }
}
