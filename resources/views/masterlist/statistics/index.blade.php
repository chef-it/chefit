@extends('layouts.app')

@section('title', '| Statistics')

@section('content')
    <div class="container">
        <div class="col-md-6 col-md-offset-1">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $masterlist->name }}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive" style="margin-bottom: 0">
                        <thead>
                            <tr>
                                <th class="col-md-3 text-center" data-priority="1">Price</th>
                                <th class="col-md-3 text-center">Quantity</th>
                                <th class="col-md-3 text-center">Date</th>
                                <th class="col-md-3 text-center">Vendor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masterlist->priceTracking as $entry)
                                <tr>
                                    <td class="text-center">{{ $currencysymbol }}{{ $entry->price }}</td>
                                    <td class="text-center">{{ $entry->ap_quantity }} {{ $entry->unit->name }}</td>
                                    <td class="text-center">{{ $entry->created_at->format('m/d/Y') }}</td>
                                    <td class="text-center">{{ $entry->vendor }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-center">{{ $currencysymbol }}{{ $masterlist->price }}</td>
                                <td class="text-center">{{ $masterlist->ap_quantity }} {{ $masterlist->unit->name }}</td>
                                <td class="text-center">{{ $masterlist->updated_at->format('m/d/Y') }}</td>
                                <td class="text-center">{{ $masterlist->vendor }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        @if ($masterlist->elements->count() != 1)
                        Used in {{ $masterlist->elements->count() }} Recipes
                        @else
                        Used in 1 Recipe
                        @endif
                    </h3>
                </div>
                <div class="panel-body">
                    @if ($masterlist->elements->count())
                        <ul style="margin-bottom: 0px">
                        @foreach($masterlist->elements as $element)
                            <li>{{ $element->recipe->name }}</li>
                        @endforeach
                        </ul>
                    @else
                        {{ $masterlist->name }} currently is not used in any recipes.
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection