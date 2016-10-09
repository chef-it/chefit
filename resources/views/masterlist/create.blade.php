@extends('layouts.bs')
@section('title', '| New Ingredient')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
@endsection

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="text-center">New Ingredient</h3>
            <hr>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'masterlist.store']) !!}
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
                {{ Form::select('ap_unit', $units, null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3 setmyheight">
                {{ Form::label('yield', 'Yield: ') }}
                {{ Form::text('yield', null, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-12 setmyheight">
                {{ Form::submit('Add', array('class' => 'btn btn-success btn-lg btn-block')) }}
                {{ Form::close() }}
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