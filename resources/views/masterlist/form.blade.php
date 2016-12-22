<span class="closebtn" onclick="closeMenu()">&times;</span>

{!! Form::open(['route' => 'masterlist.store']) !!}
<div class="form-group col-md-12" style="margin-top: 15px">
    {{ Form::label('name', 'Name: ') }}
    {{ Form::text('name', null, array('class' => 'form-control input-sm', 'autocomplete' => 'off')) }}
</div>
<div class="form-group col-md-12">
    {{ Form::label('price', 'Price: ') }}
    <div class="input-group">
        <span class="input-group-addon">{{ $currencysymbol }}</span>
        {{ Form::text('price', null, array('class' => 'form-control input-sm', 'required' => 'required', 'autocomplete' => 'off')) }}
    </div>
</div>
<div class="form-group col-md-12">
    {{ Form::label('yield', 'Yield: ') }}
    <div class="input-group">
        <span class="input-group-addon">%</span>
        {{ Form::text('yield', null, array('class' => 'form-control input-sm', 'required' => 'required', 'autocomplete' => 'off')) }}
    </div>
</div>
<div class="form-group col-md-12">
    {{ Form::label('ap_quantity', 'AP Value: ') }}
    {{ Form::text('ap_quantity', null, array('class' => 'form-control input-sm', 'required' => 'required', 'autocomplete' => 'off')) }}
    {{ Form::select('ap_unit', $units, null, array('class' => 'form-control input-sm', 'required' => 'required')) }}
</div>
<div class="form-group col-md-12">
    {{ Form::label('vendor', 'Vendor:') }}
    <input class="form-control input-sm" required="required" autocomplete="off" name="vendor" type="text" id="vendor" onfocus="openMenu2()">
</div>
<div class="form-group col-md-12">
    {{ Form::label('category', 'Category:') }}
    {{ Form::select('category', $categories, null, array('class' => 'form-control input-sm')) }}
</div>

{{ Form::close() }}
