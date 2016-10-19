@extends('layouts.app')
@section('title', '| Edit Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/selectize-bootswatch/1.0/selectize.yeti.css">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <h3 class="panel-title">Update {{ $masterlist->name }}</h3>
                </div>
                <div class="panel-body">
                    {!! Form::model($masterlist, ['route' => ['masterlist.update', $masterlist->id], 'method' => 'PUT']) !!}
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', 'Name: ') }}
                            {{ Form::text('name', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('price', 'Price: ') }}
                            {{ Form::text('price', null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('yield', 'Yield: ') }}
                            {{ Form::text('yield', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('ap_quantity', 'AP Value: ') }}
                            {{ Form::text('ap_quantity', null, array('class' => 'form-control')) }}
                            {{ Form::select('ap_unit', $units, $masterlist->ap_unit, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <hr style="margin-top: 6px">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/masterlist" class="btn btn-danger btn-block"><< Back</a>
                        </div>
                        <div class="col-md-6">
                            {{ Form::submit('Update', array('class' => 'btn btn-success btn-block')) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js"></script>
    <script>
        $('select').selectize({
            selectOnTab: true
        });
    </script>
@endsection