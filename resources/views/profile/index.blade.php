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
                    <h3 class="panel-title">Your Settings</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => ['profile.update', Auth::user()->id], 'method' => 'PUT']) !!}
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('yield', 'Currency ') }}
                            {{ Form::select('currency', $currencies, Auth::user()->profile->currency, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('ap_quantity', 'System ') }}
                            {{ Form::select('metric', $systems, Auth::user()->profile->metric, array('class' => 'form-control')) }}
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
        $('[name=ap_unit]').selectize({
            selectOnTab: true
        });

        $('#vendor').selectize({
            selectOnTab: true,
            create: true,
            createOnBlur: true
        });

        $('#category').selectize({
            selectOnTab: true,
            create: true,
            createOnBlur: true
        });
    </script>
@endsection