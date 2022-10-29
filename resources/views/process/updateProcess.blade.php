@extends('layouts.main')

@section('content')

<h1>Edit Form Process</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        
    </div>
    <script>
        alert('Please fill all the fields');
    </script>
@endif

<form action="/change/{{  $process->id  }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="process_output_quantity" >Output Quantity</label>
        <input type="number" name="process_output_quantity" id="process_output_quantity" placeholder="Output Quantity" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $process->process_output_quantity }}">
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Update</button>
    </div>
</form>


@endsection