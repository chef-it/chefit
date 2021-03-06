@extends('layouts.app')

@section('title', '| Master List')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/selectize-bootswatch/1.0/selectize.yeti.css">
@endsection


@section('sideMenu')
    @include('masterlist.form')
@endsection

@section('sideMenu2')
    <div id="vendor-list" class="list-group">
        <a href="javascript:void(0)" class="list-group-item">Test Vendor 1</a>
        <a href="javascript:void(0)" class="list-group-item">Test Vendor 2</a>
        <a href="javascript:void(0)" class="list-group-item">Test Vendor 3</a>
    </div>
@endsection


@section('content')
    <div id="container" class="container">
        <div id="list" class="col-md-12">
            <div class="block-flat">
                <div class="header">
                    <h3 class="text-center">Master List</h3>
                    <hr>
                </div>
                <div class="content">
                    <table class="table table-striped table-bordered responsive" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="col-md-2" data-priority="1">Name</th>
                                <th class="col-md-1">Price</th>
                                <th class="col-md-1">AP Quantity</th>
                                <th class="col-md-1">AP Unit</th>
                                <th class="col-md-1">Yield</th>
                                <th class="col-md-1">Category</th>
                                <th class="col-md-1">Vendor</th>
                                <th class="col-md-1" data-priority="2"></th>
                                <th class="col-md-1" data-priority="2"></th>
                                <th class="col-md-1" data-priority="2"></th>
                                <th class="col-md-1" data-priority="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masterlist as $ingredient)
                                <tr>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ $currencysymbol }}{{ $ingredient->price }}</td>
                                    <td>{{ $ingredient->ap_quantity }}</td>
                                    <td>{{ $ingredient->unit->name }}</td>
                                    <td>{{ $ingredient->yield }}%</td>
                                    <td>{{ $ingredient->category }}</td>
                                    <td>{{ $ingredient->vendor }}</td>
                                    <td>{{ link_to_route('masterlist.conversions.index', 'Conversion', [$ingredient->id], ['class' => 'btn btn-xs btn-info btn-block']) }}</td>
                                    <td>{{ link_to_route('masterlist.statistics.index', 'Statistics', [$ingredient->id], ['class' => 'btn btn-xs btn-info btn-block']) }}</td>
                                    <td>{{ link_to_route('masterlist.edit', 'Edit', [$ingredient->id], ['class' => 'btn btn-xs btn-info btn-block']) }}</td>
                                    <td>
                                        {!! Form::open(['route' => ['masterlist.destroy', $ingredient->id], 'method' => 'DELETE']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger btn-block']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="/masterlist/create" class="btn btn-success btn-block" style="margin-top: 1em">Add New Item</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
    <script src="js/sidemenu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function(){
            //initialize the javascript
            //Basic Instance
            var table = $("#datatable").dataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ]
            });

            //Search input style
            $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
            $('.dataTables_length select').addClass('form-control');

            $(document).ready(function(){
                $("#vendor-list a").click(function(){
                    var value = $(this).html();
                    var input = $('#vendor');
                    input.val(value);
                });
            });
        });

        $('[name=ap_unit]').selectize({
            selectOnTab: true
        });

        $('#category').selectize({
            selectOnTab: true,
            create: true,
            createOnBlur: true
        });
    </script>
@endsection