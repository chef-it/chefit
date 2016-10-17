@extends('layouts.bs')
@section('title', '| New Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
@endsection

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="text-center">Edit </h3>
            <hr>
        </div>
        <div class="panel-body">
            {!! Form::model($element, ['method' => 'PUT', 'route' => ['recipes.elements.update', $element->recipe, $element->id]]) !!}
            {{ Form::hidden('recipe', $element->recipe) }}
            <div class="form-group col-md-3 col-md-offset-3" >
                {{ Form::label('master_list', 'Ingredient: ') }}
                {{ Form::select('master_list', $ingredients, $element->master_list, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('quantity', 'Quantity: ') }}
                {{ Form::text('quantity', null, array('class' => 'form-control')) }}
                {{ Form::select('unit', $units, $element->unit, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-6 col-md-offset-3">
                {{ Form::submit('Edit', array('class' => 'btn btn-success btn-lg btn-block')) }}
                {{ Form::close() }}
                <a href="{{ URL::previous() }}" class="btn btn-danger btn-lg btn-block"><< Back</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#ap_unit").select2();
        });
    </script>
@endsection