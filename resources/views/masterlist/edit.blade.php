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
            <div class="col-md-11 col-md-offset-1">
                <div class="row">
                    <div class="form-group col-md-9 col-md-offset-1">
                {{ Form::label('name', 'Name: ') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 col-md-offset-1">
                        {{ Form::label('price', 'Price: ') }}
                        {{ Form::text('price', null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('ap_quantity', 'AP Value: ') }}
                        {{ Form::text('ap_quantity', null, array('class' => 'form-control')) }}
                        {{ Form::select('ap_unit', $units, $masterlist->ap_unit, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group col-md-3">
                    {{ Form::label('yield', 'Yield: ') }}
                    {{ Form::text('yield', null, array('class' => 'form-control')) }}
                </div>
                </div>
            </div>
            <div class="form-group col-md-6 col-md-offset-3">
                {{ Form::submit('Update', array('class' => 'btn btn-success btn-lg btn-block')) }}
                {{ Form::close() }}
                <a href="/masterlist" class="btn btn-danger btn-lg btn-block"><< Back</a>
            </div>
        </div>
    </div>
@endsection