<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use Validator;

class PortfoliosEditController extends Controller
{
    public function execute(Portfolio $portfolio,Request $request)
    {
        if($request->isMethod('delete')){
            if($portfolio->delete())
            {
                return redirect('admin')->with('status','Портфолио удалено');
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
                'filter'=>'required|max:255',
            ],$messages);
            if($validator->fails())
            {
                return redirect()->route('portfolioEdit',$input['id'])->withErrors($validator)->withInput($input);
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
            $portfolio->fill($input);
            // для того чтобы вносить изменения в таблицу- нужно либо добвать
            //поля разрешенные к заполнению в переменную fillable в модели либо использовать
            //$page->unguard();
            if($portfolio->update())
            {
                return redirect('admin')->with('status','Портфолио отредактировано');
            }

        }
        //$page=Page::find($id); //можно так находить требуемую страницу или так
        //как я сделал через внедрение зависимостей в атрибутах функции
        $old=$portfolio->toArray();
        //dd($old);
        if(view()->exists('admin.portfolio_edit')){
            $data=[
                'title'=>'Редактирование портфолио '.$old['name'],
                'data'=>$old,
            ];
            //dd($old);
            return view('admin.portfolio_edit',$data);
        }
        else {
            abort(404);
        }

    }
}
