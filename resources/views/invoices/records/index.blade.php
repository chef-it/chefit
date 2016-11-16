@extends('layouts.app')

@section('title', '| Invoice '.$invoice->invoice_number)

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/selectize-bootswatch/1.0/selectize.yeti.css">
@endsection

@section('content')
    <div class="container">

        <div id="MasterList" class="col-md-12">

            <div class="block-flat">
                <div class="header">
                    <h3 class="text-center">{{ $invoice->vendor }} - {{ $invoice->invoice_number }}</h3>
                    <hr>
                </div>
                <div id="Add">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Add Line Item</div>
                        </div>
                        <div class="panel-body">
                            @include('invoices.records.createform')
                        </div>
                    </div>
                </div>
                <div class="content">
                    <table class="table table-striped table-bordered responsive" id="datatable" width="100%">
                        <thead>
                        <tr>
                            <th class="col-md-2">Category</th>
                            <th class="col-md-4" data-priority="1">Ingredient</th>
                            <th class="col-md-2">Quantity</th>
                            <th class="col-md-2" data-priority="1">Cost</th>
                            <th class="col-md-2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->records as $record)
                            <tr>
                                <td>{{ $record->category }}</td>
                                <td>{{ $record->masterlist->name }}</td>
                                <td>{{ $record->ap_quantity }} {{ $record->unit->name }}</td>
                                <td>{{ $currencysymbol }} {{ $record->price }}</td>
                                <td>
                                    {!! Form::open(['route' => ['invoices.records.destroy', $invoice->id, $record->id], 'method' => 'DELETE']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger btn-block']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ link_to_route('recipes.elements.create', 'Add New Element', [Request::segment(2)], ['class' => 'btn btn-success btn-block']) }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            //initialize the javascript
            //Basic Instance
            $("#datatable").dataTable({
                responsive: true
            });

            //Search input style
            $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
            $('.dataTables_length select').addClass('form-control');

            $('[name=ap_unit]').selectize({
                selectOnTab: true
            });

            $('#masterlist').selectize({
                selectOnTab: true,
                create: true,
                createOnBlur: true
            });

            $('#category').selectize({
                selectOnTab: true,
                create: true,
                createOnBlur: true
            });
        });
    </script>
@endsection