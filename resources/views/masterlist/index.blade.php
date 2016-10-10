@extends('layouts.bs')

@section('title', '| Master List')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
@endsection

@section('content')
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
                            <th class="col-md-6" data-priority="1">Name</th>
                            <th class="col-md-1">Price</th>
                            <th class="col-md-1">AP Quantity</th>
                            <th class="col-md-1">AP Unit</th>
                            <th class="col-md-1">Yield</th>
                            <th class="col-md-1" data-priority="2"></th>
                            <th class="col-md-1" data-priority="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masterlist as $table)
                            <tr>
                                <td>{{ $table->name }}</td>
                                <td>{{ $table->price }}</td>
                                <td>{{ $table->ap_quantity }}</td>
                                <td>{{ $table->ap_unit }}</td>
                                <td>{{ $table->yield }}</td>
                                <td>{{ link_to_route('masterlist.edit', 'Edit', [$table->id], ['class' => 'btn btn-info btn-block']) }}</td>
                                <td>
                                    {!! Form::open(['route' => ['masterlist.destroy', $table->id], 'method' => 'DELETE']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="/masterlist/create" class="btn btn-success btn-lg btn-block" style="margin-top: 1em">Add New Item</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            //initialize the javascript
            //Basic Instance
            $("#datatable").dataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ]
            });

            //Search input style
            $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
            $('.dataTables_length select').addClass('form-control');
        });
    </script>
@endsection