
@extends('layouts.main')

@section('container')

    <div class="card sm:rounded-lg shadow-md mb-6" style="padding: 2rem">
        <div class="card-body">
            <label class="label">Material</label>
            <table class="overflow-x-auto relative shadow-iner sm:rounded-lg w-full text-sm text-left text-gray-200 dark:text-gray-800">
                <tr class="h-16">
                    <td class="border px-4 py-2 w-1/3 ">Material Name</td>
                    <td class="border px-4 py-2">{{ $material->material_name }}</td>
                </tr>
                <tr class="h-16">
                    <td class="border px-4 py-2 w-1/3 ">Material Description</td>
                    <td class="border px-4 py-2">{{ $material->material_description }}</td>
                </tr>
                <tr class="h-16">
                    <td class="border px-4 py-2 w-1/3 ">Material Quantity</td>
                    <td class="border px-4 py-2">{{ $material->material_quantity }}  {{ $material->material_measure_unit }}</td>
                </tr>
                <tr class="h-16">
                    <td class="border px-4 py-2 w-1/3 ">Action</td>
                    <td class="border px-4 py-2">
                        <a href="/material/update/{{ $material->id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Update</a>
                    </td>
                </tr>
                
            </table>
        </div>
    </div>     
            
            
    <div class="card sm:rounded-lg shadow-md" style="padding: 2rem">
        <div class="card-body">
            <label class="label">Material History</label>
            <table class="table-auto mt-8">
                <thead>
                    <td class="border px-4 py-2">Date</td>
                    <td class="border px-4 py-2">Description</td>
                    <td class="border px-4 py-2">Amount</td>
                </thead>
                <tbody>
                    @foreach ($materialHistory as $m)
                    <tr>
                        <td class="border px-4 py-2">{{ $m->created_at }}</td>
                        <td class="border px-4 py-2">{{ $m->description }}</td>
                        @if ($m->quantity < 0)
                            <td class="border px-4 py-2 text-red-500">{{ $m->quantity }}</td>
                        @else
                            <td class="border px-4 py-2 text-green-500">+ {{ $m->quantity }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>    
    

@endsection