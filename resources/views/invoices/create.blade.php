@extends('layouts.app')
@section('title', '| New Invoice')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/selectize-bootswatch/1.0/selectize.yeti.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://cdn-na.infragistics.com/igniteui/2016.2/latest/css/themes/yeti/infragistics.theme.css">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <h3 class="panel-title">New Invoice</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'invoices.store']) !!}
                    <div class="row">
                        <div class="form-group col-md-4">
                            {{ Form::label('date', 'Date: ') }}
                            {{ Form::text('date', null, array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('vendor', 'Vendor:') }}
                            {{ Form::select('vendor', $vendors, null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('invoice_number', 'Invoice Number: ') }}
                            {{ Form::text('invoice_number', null, array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
                        </div>
                    </div>
                    <hr style="margin-top: 6px">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/invoices" class="btn btn-danger btn-block"><< Back</a>
                        </div>
                        <div class="col-md-6">
                            {{ Form::submit('Create', array('class' => 'btn btn-success btn-block')) }}
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $('#vendor').selectize({
            selectOnTab: true,
            create: true,
            createOnBlur: true
        });

        $(function() {
            $( "#date" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@endsection