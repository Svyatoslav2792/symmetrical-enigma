<div class="wrapper container-fluid">
    {!! Form::open(['url'=>route('serviceEdit',array('service'=>$data['id'])),'class'=>'form-horizontal','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
        {!! Form::hidden('id',$data['id']) !!}
        {!! Form::label('name','Название',['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('name',$data['name'],['class'=>'form-control','placeholder'=>'Введите название страницы'])!!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('text','Текст',['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::textarea('text',$data['text'],['id'=>'editor','class'=>'form-control','placeholder'=>'Введите текст'])!!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('icon','Иконка',['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
        <p><select name="icon" multiple size=@count($icon_list)">
                @foreach ($icon_list as $item)
                    echo <option value={{$item}}>{{$item}}</option>
                @endforeach
                    <option selected value="Крокодил Гена">{{$data['icon']}}</option>
            </select>
        </p>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::button('Сохранить',['class'=>'btn btn-primary','type'=>'submit'])!!}
        </div>
    </div>
    {!! Form::close()!!}

</div>