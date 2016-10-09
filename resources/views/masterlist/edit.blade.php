@extends('layouts.bs')
@section('title', '| Edit Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="text-center">Update {{ $masterlist->name }}</h3>
            <hr>
        </div>
        <div class="panel-body">
            {!! Form::model($masterlist, ['route' => ['masterlist.update', $masterlist->id], 'method' => 'PUT']) !!}
            <div class="form-group col-md-12 setmyheight">
                {{ Form::label('name', 'Name: ') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('price', 'Price: ') }}
                {{ Form::text('price', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('ap_quantity', 'AP Value: ') }}
                {{ Form::text('ap_quantity', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('ap_unit', 'AP Unit: ') }}
                {{ Form::text('ap_unit', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('yield', 'Yield: ') }}
                {{ Form::text('yield', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-12 setmyheight">
                {{ Form::submit('Update', array('class' => 'btn btn-success btn-lg btn-block')) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection