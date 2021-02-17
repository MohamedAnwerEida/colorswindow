@if(!empty($states))
@foreach($states as $value)
<option value="{{ $value->id }}" {{ $cat_item == $value->id ? 'selected' : '' }}>{{ $value->name_ar }}</option>
@endforeach
@endif