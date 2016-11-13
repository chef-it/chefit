@extends('layouts.app')

@section('title', '| Recipes')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css">
@endsection

@section('content')
    <div class="container">
        <div id="MasterList" class="col-md-12">
            <div class="block-flat">
                <div class="header">
                    <h3 class="text-center">{{ $recipe->name }}</h3>
                    <hr>
                </div>
                <div class="content">
                    <table class="table table-striped table-bordered responsive" id="datatable" width="100%">
                        <thead>
                        <tr>
                            <th class="col-md-4" data-priority="1">Ingredient</th>
                            <th class="col-md-1">Quantity</th>
                            <th class="col-md-1" data-priority="1">Cost</th>
                            <th class="col-md-2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($elements as $element)
                            <tr>
                                @if ($element->type == 'masterlist')
                                    <td>{{ $element->masterlist->name }}</td>
                                @elseif($element->type == 'recipe')
                                    <td>{{ $element->subrecipe->name }}</td>
                                @endif
                                <td>{{ $element->quantity }} {{ $element->unit->name }}</td>
                                <td>{{ $currencysymbol }}{{ $element->cost }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{ link_to_route('recipes.elements.edit', 'Edit', [$element->recipe_id, $element->id], ['class' => 'btn btn-xs btn-info btn-block']) }}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::open(['route' => ['recipes.elements.destroy',$element->recipe_id, $element->id], 'method' => 'DELETE']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-xs btn-danger btn-block']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
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
    <div class="container" style="margin-top: 2em">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Details</h3>
                    </div>
                    <div class="panel-body">
                        @if ($recipe->component_only == 0)
                        <p class="col-xs-8">Menu Price</p>
                        <p class="col-xs-4">{{ $currencysymbol }}{{ $recipe->menu_price }}</p>
                        <p class="col-xs-8">Costing Percent</p>
                        <p class="col-xs-4">{{ $recipe->data->costPercent }}%</p>
                        @endif
                        <p class="col-xs-8">Recipe Cost</p>
                        <p class="col-xs-4">{{ $currencysymbol }}{{ $recipe->data->cost }}</p>
                        <p class="col-xs-8">Batch Size</p>
                        <p class="col-xs-4">{{ $recipe->batch_quantity }} {{ $recipe->batchUnit->name }}</p>
                        @if ($recipe->batch_unit != 16)
                        <p class="col-xs-8">Portions</p>
                        <p class="col-xs-4">{{ $recipe->portions_per_batch }}</p>
                        <p class="col-xs-8">Price Per Portion</p>
                        <p class="col-xs-4">{{ $recipe->data->portionPrice }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recipe Instructions</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::open(['route' => ['recipes.instructions', $recipe->id], 'method' => 'PUT']) }}
                        {{ Form::textarea('instructions', $recipe->instructions, array('class' => 'form-control', 'id' => 'instructions')) }}
                        {{ Form::submit('Save', array('class' => 'btn btn-success btn-block')) }}
                        {{ Form::close() }}
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.min.js"></script>

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

            $('#instructions').summernote({
                height:300,
            });
        });
    </script>
@endsection