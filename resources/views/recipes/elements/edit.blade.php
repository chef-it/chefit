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
                    <h3 class="panel-title">Edit </h3>
                </div>
                <div class="panel-body">
                    {!! Form::model($element, ['method' => 'PUT', 'route' => ['recipes.elements.update', $element->recipe_id, $element->id]]) !!}
                    {{ Form::hidden('recipe', $element->recipe_id) }}
                    <div class="row">
                        <div class="form-group col-md-6" >
                            {{ Form::label('master_list', 'Ingredient: ') }}
                            {{ Form::select('master_list_id', $ingredients, $element->master_list_id, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('quantity', 'Quantity: ') }}
                            {{ Form::text('quantity', null, array('class' => 'form-control')) }}
                            {{ Form::select('unit_id', $units, $element->unit_id, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <hr style="margin-top: 6px">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ URL::previous() }}" class="btn btn-danger btn-block"><< Back</a>
                        </div>
                        <div class="col-md-6">
                            {{ Form::submit('Edit', array('class' => 'btn btn-success btn-block')) }}
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