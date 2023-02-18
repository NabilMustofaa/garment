@extends('layouts.main')
@section('container')

<form action="/production/{{ $production->id}}/send" method="post">
  <select name="process_material_id" id="selectMaterial">
    @foreach ($processMats as $pm)
      <option value="{{ $pm->id }}">{{ $pm->process_material_name }}</option>
    @endforeach
  </select>
  
  <input type="number" name="quantity" id="" min="0" max="{{ $processMats[0]->process_material_quantity }}" value="{{ $processMats[0]->process_material_quantity }}">
</form>



@foreach ( $processMats as $pm )
  <input type="hidden" id="{{ $pm->id }}" value="{{ $pm->process_material_quantity }}" hidden>
@endforeach

<script>
  const selectMaterial = document.querySelector('#selectMaterial');
  const quantity = document.querySelector('input[name="quantity"]');
  const actualQuantity = document.querySelector('input[id="' + selectMaterial.value + '"]]');

  selectMaterial.addEventListener('change', function() {
    quantity.setAttribute('max', actualQuantity.value);
    quantity.value = actualQuantity.value;
  });

</script>

@endsection