@extends('layouts.app')
@section('title', '| New Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/selectize-bootswatch/1.0/selectize.yeti.css">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Ingredient</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => ['recipes.elements.store', Request::segment(2)]]) !!}
                    {{ Form::hidden('recipe_id', Request::segment(2)) }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('ingredient', 'Ingredient: ') }}
                            {{ Form::select('ingredient', $ingredients, null, array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('quantity', 'Quantity: ') }}
                            {{ Form::text('quantity', null, array('class' => 'form-control', 'required' => 'required')) }}
                            {{ Form::select('unit_id', $units, null, array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                    </div>
                    <hr style="margin-top: 6px">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ URL::previous() }}" class="btn btn-danger btn-block"><< Back</a>
                        </div>
                        <div class="col-md-6">
                            {{ Form::submit('Add', array('class' => 'btn btn-success btn-block')) }}
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