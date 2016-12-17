@extends('layouts.app')

@section('title', '| Master List')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/selectize-bootswatch/1.0/selectize.yeti.css">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $masterlist->name }} Conversion</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => ['masterlist.conversions.store', Request::segment(2)]]) !!}
                    <div class="row">
                        <div class="form-group col-md-6" id="left">
                            {{ Form::label('left', 'Measurement One: ') }}
                            {{ Form::text('left_quantity', null, array('class' => 'form-control', 'autocomplete' => 'off', 'required' => 'required')) }}
                            {{ Form::select('left_unit', $units, null, array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-6" id="right">
                            {{ Form::label('right', 'Measurement Two: ') }}
                            {{ Form::text('right_quantity', null, array('class' => 'form-control', 'autocomplete' => 'off', 'required' => 'required')) }}
                            {{ Form::select('right_unit', $units, null, array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                    </div>
                    <hr style="margin-top: 6px">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ URL::previous() }}" class="btn btn-danger btn-block"><< Back</a>
                        </div>
                        <div class="col-md-6">
                            {{ Form::submit('Update', array('class' => 'btn btn-success btn-block')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
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