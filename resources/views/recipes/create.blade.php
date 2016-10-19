@extends('layouts.app')
@section('title', '| New Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/selectize-bootswatch/1.0/selectize.yeti.css">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <h3 class="panel-title">New Recipe</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'recipes.store']) !!}
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', 'Name: ') }}
                            {{ Form::text('name', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('menu_price', 'Menu Price: ') }}
                            {{ Form::text('menu_price', null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            {{ Form::label('portions_per_batch', 'Portions per Batch: ') }}
                            {{ Form::text('portions_per_batch', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('batch_quantity', 'Batch Quantity: ') }}
                            {{ Form::text('batch_quantity', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('batch_unit', 'Batch Unit: ') }}
                            {{ Form::select('batch_unit', $units, null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('component_only', 'Sub Recipe Only: ') }}
                            {{ Form::select('component_only', $options, null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <hr style="margin-top: 6px">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/recipes" class="btn btn-danger btn-block"><< Back</a>
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