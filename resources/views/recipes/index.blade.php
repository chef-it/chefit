@extends('layouts.app')

@section('title', '| Recipes')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
@endsection

@section('content')
    <div class="container">
        <div id="MasterList" class="col-md-12">
            <div class="block-flat">
                <div class="header">
                    <h3 class="text-center">Recipes</h3>
                    <hr>
                </div>
                <div class="content">
                    <table class="table table-striped table-bordered responsive" id="datatable" width="100%">
                        <thead>
                        <tr>
                            <th class="col-md-4" data-priority="1">Name</th>
                            <th class="col-md-1">Price</th>
                            <th class="col-md-1">Costing %</th>
                            <th class="col-md-1"></th>
                            <th class="col-md-1"></th>
                            <th class="col-md-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recipes as $recipe)
                            <tr>
                                <td>{{ $recipe->name }}</td>
                                @if ($recipe->component_only == 1)
                                    <td>Sub Recipe</td>
                                    <td>Sub Recipe</td>
                                @else
                                    <td>{{ $currencysymbol }}{{ $recipe->menu_price }}</td>
                                    <td>{{ $recipe->data->costPercent }}</td>
                                @endif
                                <td>{{ link_to_route('recipes.edit', 'Edit', [$recipe->id], ['class' => 'btn btn-xs btn-info btn-block']) }}</td>
                                <td>{{ link_to_route('recipes.elements.index', 'View', [$recipe->id], ['class' => 'btn btn-xs btn-primary btn-block']) }}</td>
                                <td>
                                    {!! Form::open(['route' => ['recipes.destroy', $recipe->id], 'method' => 'DELETE']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger btn-block']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="/recipes/create" class="btn btn-success btn-block" style="margin-top: 1em">Add New Item</a>
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
                responsive: true
            });

            //Search input style
            $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
            $('.dataTables_length select').addClass('form-control');
        });
    </script>
@endsection