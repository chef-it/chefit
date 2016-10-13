@extends('layouts.bs')
@section('title', '| New Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
@endsection

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="text-center">Add Ingredient</h3>
            <hr>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['recipes.elements.store', Request::segment(2)]]) !!}
            {{ Form::hidden('recipe', Request::segment(2)) }}
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('master_list', 'Ingredient: ') }}
                {{ Form::select('master_list', $ingredients, null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('quantity', 'Quantity: ') }}
                {{ Form::text('quantity', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('unit', 'Unit: ') }}
                {{ Form::select('unit', $units, null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-12 setmyheight">
                {{ Form::submit('Add', array('class' => 'btn btn-success btn-lg btn-block')) }}
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