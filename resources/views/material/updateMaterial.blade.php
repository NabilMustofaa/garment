@extends('layouts.main')

@section('container')


<div class="container shadow-md">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card sm:rounded-lg" style="padding: 2rem">
                <div class="card-body">
                    <label class="label">Edit Form Material</label>
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

                        <button type="submit" class="flex-end justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-5">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection