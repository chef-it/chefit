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
                <h3 class="text-center">{{ $masterlist->name }} Conversion</h3>
                <hr>
            </div>
            <div class="content">
                {!! Form::open(['route' => ['masterlist.conversions.store', Request::segment(2)]]) !!}
                <div class="form-group col-md-3 setmyheight">
                    {{ Form::label('left', 'Measurement One: ') }}
                    {{ Form::text('left_quantity', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
                    {{ Form::select('left_unit', $units, null, array('class' => 'form-control')) }}
                </div>
                <div class="form-group col-md-3 setmyheight">
                    {{ Form::label('right', 'Measurement Two: ') }}
                    {{ Form::text('right_quantity', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
                    {{ Form::select('right_unit', $units, null, array('class' => 'form-control')) }}
                </div>
                <div class="form-group col-md-12 setmyheight">
                    {{ Form::submit('Update', array('class' => 'btn btn-success btn-lg btn-block')) }}
                    {{ Form::close() }}
                    <a href="{{ URL::previous() }}" class="btn btn-danger btn-lg btn-block"><< Back</a>
                </div>
            </div>
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