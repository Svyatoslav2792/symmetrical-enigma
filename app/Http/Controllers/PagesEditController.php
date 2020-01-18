<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Validator;
use Illuminate\Validation\Rule;
class PagesEditController extends Controller
{
    public function execute(Page $page,Request $request)
    {
        if($request->isMethod('delete')){
            if($page->delete())
            {
                return redirect('admin')->with('status','Страница удалена');
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
                'alias'=>['required','max:255',
                Rule::unique('pages')->ignore($input['id'])],
                'text'=>'required',
            ],$messages);
            if($validator->fails())
            {
                return redirect()->route('pagesEdit',$input['id'])->withErrors($validator)->withInput($input);
            }
            if($request->hasFile('images')) {
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img',$input['images']);

            }
            else {
                $input['images']=$input['old_images'];
            }
            unset($input['old_images']);
            //$page=new Page($input);
            $page->fill($input);
            // для того чтобы вносить изменения в таблицу- нужно либо добвать
            //поля разрешенные к заполнению в переменную fillable в модели либо использовать
            //$page->unguard();
            if($page->update())
            {
                return redirect('admin')->with('status','Страница отредактирована');
            }

        }
        //$page=Page::find($id); //можно так находить требуемую страницу или так
        //как я сделал через внедрение зависимостей в атрибутах функции
        $old=$page->toArray();
        //dd($old);
        if(view()->exists('admin.page_edit')){
            $data=[
                'title'=>'Редактирование страницы '.$old['name'],
                'data'=>$old,
            ];
            //dd($old);
            return view('admin.page_edit',$data);
        }
        else {
            abort(404);
        }

    }
    //
}
