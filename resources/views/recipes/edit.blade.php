@extends('layouts.bs')
@section('title', '| New Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
@endsection

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="text-center">New Recipe</h3>
            <hr>
        </div>
        <div class="panel-body">
            {!! Form::model($recipe, ['route' => ['recipes.update', $recipe->id], 'method' => 'PUT']) !!}
            <div class="form-group col-md-6 setmyheight">
                {{ Form::label('name', 'Name: ') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-6 setmyheight">
                {{ Form::label('menu_price', 'Price: ') }}
                {{ Form::text('menu_price', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('portions_per_batch', 'Portions per Batch: ') }}
                {{ Form::text('portions_per_batch', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('batch_quantity', 'Batch Quantity: ') }}
                {{ Form::text('batch_quantity', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('batch_unit', 'Batch Unit: ') }}
                {{ Form::select('batch_unit', $units, $recipe->batch_unit, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('component_only', 'Component: ') }}
                {{ Form::checkbox('component_only', '1') }}
            </div>
            <div class="form-group col-md-12 setmyheight">
                {{ Form::submit('Add', array('class' => 'btn btn-success btn-lg btn-block')) }}
                {{ Form::close() }}
                <a href="/recipes" class="btn btn-danger btn-lg btn-block"><< Back</a>
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