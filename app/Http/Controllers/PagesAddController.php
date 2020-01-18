<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Validator;
class PagesAddController extends Controller
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
                'alias'=>'required|unique:pages|max:255',
                'text'=>'required',
            ],$messages);
            if($validator->fails())
            {
                return redirect()->route('pagesAdd')->withErrors($validator)->withInput($input);
            }
            if($request->hasFile('images')) {
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img',$input['images']);
            }

            if(!$request->has('images')) {
                $input['images']='No image';
            }
            $page=new Page($input);
            // для того чтобы вносить изменения в таблицу- нужно либо добвать
            //поля разрешенные к заполнению в переменную fillable в модели либо использовать
            //$page->unguard();
            if($page->save())
            {
                return redirect('admin')->with('status','Страница добавлена');
            }

        }

        if(view()->exists('admin.pages_add')){
            $data=[
                'title'=>'Новая страница',
            ];

        return view('admin.pages_add',$data);
        }


        else {
            abort(404);
        }
    }
}
