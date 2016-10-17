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
                        {{ Form::select('ap_unit', $units, null, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group col-md-3">
                    {{ Form::label('yield', 'Yield: ') }}
                    {{ Form::text('yield', null, array('class' => 'form-control')) }}
                </div>
                </div>
            </div>
            <div class="form-group col-md-6 col-md-offset-3">
                {{ Form::submit('Add', array('class' => 'btn btn-success btn-lg btn-block')) }}
                {{ Form::close() }}
                <a href="/masterlist" class="btn btn-danger btn-lg btn-block"><< Back</a>
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