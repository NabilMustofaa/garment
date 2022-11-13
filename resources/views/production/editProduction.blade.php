@extends('layouts.main')

@section('content')

<h1>Edit Form Production</h1>

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

<form action="/production/{{ $production->id }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="production_name" >Name</label>
        <input type="text" name="production_name" id="production_name" placeholder="Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_name }}">
    </div>
    <div class="mb-4">
        <label for="production_description" >Description</label>
        <input type="text" name="production_description" id="production_description" placeholder="Description" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_description }}">
    </div>
    <div class="mb-4">
        <label for="production_status" >Status</label>
        <input type="text" name="production_status" id="production_status" placeholder="Status" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_status }}">
    </div>
    <div class="mb-4">
        <label for="production_projected_end_date" >Projected End Date</label>
        <input type="date" name="production_projected_end_date" id="production_projected_end_date" placeholder="Projected End Date" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $production->production_projected_end_date }}">
    </div>
    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Update</button>
    </div>  
</form>

<h1>Create Process form</h1>
<form action="/process" method="POST" >
    @csrf
    <h1></h1>
    <div class="mb-4">
        <input type="hidden" name="production_id" id="production_id" value="{{ $production->id }}">
        
        <input type="hidden" name="process_status" id="process_status" value="menunggu">
    </div>
    <div class="mb-4">
        <label for="user_id">Input id</label>
        <input type="number" name="user_id" id="user_id" placeholder="User ID" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="0">
    </div>
    <div class="mb-4">
        <label for="process_name" >Name</label>
        <input type="text" name="process_name" id="process_name" placeholder="Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ old('process_name') }}">
    </div>
    <div class="mb-4">
        <label for="process_id" >Process ID</label>
        <select id="process_id" name="process_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            @foreach ($processes as $process)
            @if ($process->process_type == 1 || $process->process_type == 5)
                @continue
            @else
            <option value="{{ $process->id }}">{{ $process->process_name }}</option>
            @endif
                
                
            @endforeach
        </select>
    </div>
    {{-- <div class="flex">
        <div>Input Material</div>
        <button id="materialButton" type="button" class="bg-blue-500 p-2 mx-4">Add</button>
        <input type="hidden" name="totalMaterial" id="totalMaterial" value="1">
    </div>
    <div class="materialContainer">
        <div class="flex">
            @foreach ($processMaterials->where('process_id',($process->id-1 ))->where('process_material_status',"Input Produksi") as $pm)
            <div class="flex flex-col">
                <label for="input_quantity">Input Quantit Material 1</label>
                <input type="number" name="process_input_quantity_1" id="process_input_quantity_1" class="border border-gray-400 p-2" value="{{ $pm->process_material_quantity }}" min="0">
            </div>
            <div class="flex flex-col flex-warp" id="Bagian">
                <label for="material_id">Material Type 1</label>
                <select name="process_input_material_id_1" id="process_input_material_id_1" class="border border-gray-400 p-2">
                    @foreach ($materials as $material)
                        @if ($pm->material_id == $material->id)
                            <option value="{{ $material->id }}" selected>{{ $material->material_name }}</option>
                        @else
                        <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                        @endif
                        
                    @endforeach
                </select>
            </div>
            @endforeach
            
            
        </div>
    </div> --}}
    


    <div class="mb-4" id="potongOutput">
        <div>
            <label for="process_output_material_id" >Material Output</label>
            <select name="process_output_material_id" id="process_output_material_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                <option value="0">Potong Baju</option>
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                @endforeach
            </select>
            <input type="number" name="process_output_quantity" id="process_output_quantity" placeholder="Quantity" class="flex bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ old('process_output_quantity') }}">
        </div>
        <div class="hidden flex-wrap" id="ukuranBagian">
            @foreach ($ukuranBagian as $item)
            <div class="flex flex-col">
                <h1>{{$item->material_name}}</h1>
                <input type="number" class="border border-gray-400 p-2" name="{{ "process_output_bagian_".$item->id }}" value=0 >
            </div>
        @endforeach
        </div>
    </div>

    {{-- <div class="mb-4">
        <label for="process_start_date" >Projected Start Date</label>
        input with current date
        <input type="date" name="process_start_date" id="process_start_date" placeholder="Projected Start Date" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ date('Y-m-d'),old('process_start_date') }}">
    </div>

    <div class="mb-4">
        <label for="process_end_date" >Projected End Date</label>
        <input type="date" name="process_end_date" id="process_end_date" placeholder="Projected End Date" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ date('Y-m-d'),old('process_end_date') }}">
    </div> --}}
    <div>
        <button type="submit" id="submitProcess" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create</button>
    </div>

</form>
{{-- @foreach ($processes as $process)
    @if ($process->process_type == 1)
        @continue

    @else

@endif

<form action="/process" method="POST" id="process_{{ $process->id }}">
    @csrf
    <h1>{{ $process->process_name }}</h1>
    <div class="mb-4">
        <input type="hidden" name="production_id" id="production_id" value="{{ $production->id }}">
        <input type="hidden" name="process_id" id="process_id" value="{{ $process->id }}">
        <input type="hidden" name="process_status" id="process_status" value="menunggu">
    </div>
    <div class="mb-4">
        <label for="user_id">Input id</label>
        <input type="number" name="user_id" id="user_id" placeholder="User ID" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="0">
    </div>
    <div class="mb-4">
        <label for="process_name" >Name</label>
        <input type="text" name="process_name" id="process_name" placeholder="Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ old('process_name') }}">
    </div>
    <div class="flex">
        <div>Input Material</div>
        <button id="materialButton" type="button" class="bg-blue-500 p-2 mx-4">Add</button>
        <input type="hidden" name="totalMaterial" id="totalMaterial" value="1">
    </div>
    <div class="materialContainer">
        <div class="flex">
            @foreach ($processMaterials->where('process_id',($process->id-1 ))->where('process_material_status',"Input Produksi") as $pm)
            <div class="flex flex-col">
                <label for="input_quantity">Input Quantit Material 1</label>
                <input type="number" name="process_input_quantity_1" id="process_input_quantity_1" class="border border-gray-400 p-2" value="{{ $pm->process_material_quantity }}" min="0">
            </div>
            <div class="flex flex-col flex-warp" id="Bagian">
                <label for="material_id">Material Type 1</label>
                <select name="process_input_material_id_1" id="process_input_material_id_1" class="border border-gray-400 p-2">
                    @foreach ($materials as $material)
                        @if ($pm->material_id == $material->id)
                            <option value="{{ $material->id }}" selected>{{ $material->material_name }}</option>
                        @else
                        <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                        @endif
                        
                    @endforeach
                </select>
            </div>
            @endforeach
            
            
        </div>
    </div>
    


    <div class="mb-4" id="potongOutput">
        <div>
            <label for="process_output_material_id" >Material</label>
            <select name="process_output_material_id" id="process_output_material_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                <option value="0">Potong Baju</option>
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                @endforeach
            </select>
            <input type="number" name="process_output_quantity" id="process_output_quantity" placeholder="Quantity" class="flex bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ old('process_output_quantity') }}">
        </div>
        <div class="hidden flex-wrap" id="ukuranBagian">
            @foreach ($ukuranBagian as $item)
            <div class="flex flex-col">
                <h1>{{$item->material_name}}</h1>
                <input type="number" class="border border-gray-400 p-2" name="{{ "process_output_bagian_".$item->id }}" value=0 >
            </div>
        @endforeach
        </div>
    </div>

    <div>
        <button type="submit" id="submitProcess" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create</button>
    </div>

</form>
    
@endforeach --}}


<h1>Sub Process Table</h1>
@foreach ($processes->whereNotIn('process_type',[1,5]) as $p)
    <h1>{{ $p->process_name }}</h1>
    <h1>Input Quantity</h1>
    @foreach ($p->processMaterial->where('process_material_status','Input Produksi') as $pm)
    {{ $pm->process_material_name }}/{{ $pm->process_material_quantity }}; 
        
    @endforeach

    @foreach ($p->subProses->GroupBy('user_id') as $subGroup)
        <div class="border border-b-4">
            <h1>Proses Dikerjaka oleh user{{ $subGroup[0]->user_id }}</h1>
            <form action="/process/{{ $p->id }}" method="POST">
            @csrf
            @method('PUT')
            @foreach ($subGroup as $sp)
            <div class="flex">
                {{ $sp->processMaterial->process_material_name }} 
                    <input type="hidden" name="user_id" value="{{ $sp->user_id }}">
                    <input type="hidden" name="process_id" value="{{ $sp->process_id }}">
                    <input type="number" name="sub_proses_projected_{{ $sp->id }}" id="sub_proses_projected" class=" border border-black" value="{{ $sp->sub_proses_projected }}" max="{{ $sp->sub_proses_projected }}">
                    <div>
                        Actual : {{ $sp->sub_proses_actual }}
                    </div>
    
            </div>
        @endforeach
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Update</button>
        <a href="/subproses/{{ $subGroup[0]->user_id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
        <a href="/generate/{{ $subGroup[0]->user_id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Generate QR</a>
            </form>
        </div>
    @endforeach
    
@endforeach


<script src="{{ asset("js/process.js") }}"></script>


    


@if (session('succes'))
    <div class="bg-green-500 text-white p-2">
        {{ session('succes') }}
        
    </div>
    <script>
        console.log('succes');
    </script>
@endif

@endsection
