{!! Form::open(['route' => ['invoices.records.store', $invoice->id]]) !!}
<div class="row">
    <div class="form-group col-md-3">
        {{ Form::label('masterlist', 'Name: ') }}
        {{ Form::select('masterlist', $masterlist, null, array('class' => 'form-control', 'required' => 'required')) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('ap_quantity', 'AP Value: ') }}
        {{ Form::text('ap_quantity', null, array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
        {{ Form::select('ap_unit', $units, null, array('class' => 'form-control', 'required' => 'required')) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('price', 'Price: ') }}
        <div class="input-group">
            <span class="input-group-addon">{{ $currencysymbol }}</span>
            {{ Form::text('price', null, array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
        </div>
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('category', 'Category:') }}
        {{ Form::select('category', $categories, null, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group col-md-2 col-md-offset-10">
    {{ Form::submit('Add', array('class' => 'btn btn-success btn-block')) }}
    {{ Form::close() }}
</div>