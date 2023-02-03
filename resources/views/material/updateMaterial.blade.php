@extends('layouts.main')

@section('container')

<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Update Material</label>
    <hr class="navbar-divider">
    <br>
</center>

<form action="/material/update/{{ $material->id }}" method="POST">
    @csrf

    <div class="mb-4">
        <label class="label">Material Name</label>
        <input type="text" class="input bg-slate-200" value="{{ $material->material_name }}" disabled>
    </div>
    
    <div class="mb-4">
        <label class="label">Update Description</label>
        <input type="text" name="description" class="input">
    </div>
    
    <div class="mb-4">
        <label class="label">Material Quantity</label>
        <input type="text" name="quantity" class="input" value="0">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Update</button>
    
</form>
@endsection