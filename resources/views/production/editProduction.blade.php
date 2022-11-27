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
    <select name="production_type" id="production_type" class="border border-gray-400 p-2">
        {{ $production->production_type }}
        @foreach ($productionType as $type)
            @if ($type->id == $production->production_type)
                <option value="{{ $type->id }}" selected>{{ $type->production_type_name }}</option>
            @else
                <option value="{{ $type->id }}">{{ $type->production_type_name  }}</option>    
            @endif

        @endforeach
    </select>

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
        <select name="user_id" id="user_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            @foreach ($person as $user)
                <option value="{{ $user[0]->user->id }}">{{ $user[0]->user->name }}</option>
            @endforeach
        </select>
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
    <div>
        <button type="submit" id="submitProcess" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create</button>
    </div>

</form>


<h1>Sub Process Table</h1>
@foreach ($processes->whereNotIn('process_type',[1]) as $p)
    <h1 class=" font-bold">{{ $p->process_name }}</h1>
    <h1>Input Quantity</h1>
    @foreach ($p->processMaterial->where('process_material_status','Input Produksi') as $pm)
    {{ $pm->process_material_name }}/{{ $pm->process_material_quantity }}; 
        
    @endforeach

    @foreach ($p->subProses->GroupBy('user_id') as $subGroup)
        <div class=" border border-black">
            <h1 class="">Proses Dikerjaka oleh user{{ $subGroup[0]->user->name }}</h1>
            <div class="grid grid-cols-8 gap-6">
                <h3>Nama Material</h3>
                <h3>Projected</h3>
                <h3>Actual</h3>
                <h3>Sisa</h3>
                <h3>Ambil</h3>
            </div>
            @foreach ($subGroup as $sp)
            <form action="/subproses/{{ $sp->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-8 gap-6">
                    {{ $sp->processMaterial->process_material_name }} 
                    <input type="hidden" name="user_id" value="{{ $sp->user_id }}">
                    <input type="hidden" name="process_id" value="{{ $sp->process_id }}">
                    <p>Target : {{ $sp->sub_proses_projected }}</p>
                    <p>Target : {{ $sp->sub_proses_actual }}</p>
                    <p>Target : {{ $sp->sub_proses_projected - $sp->sub_proses_actual }}</p>
                    <input type="number" name="quantityAmbil" id="quantityAmbil" class=" border border-black" value="0" max="{{ $sp->sub_proses_projected - $sp->sub_proses_actual }}">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Update</button>
                    @if (!$sp->subProcessHistories->isEmpty())
                    <button type="button" class="bg-red-500 text-white px-4 py-3 rounded font-medium" onclick="openDetail($sp->id)">Check Detail</button>
                    @endif
                    </form>
                    <form action="/subproses/{{ $sp->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                    </form>
                </div>
                @if ($sp->subProcessHistories != Null)
                <div id="detail_{{ $sp->id }}" >
                    <div class="grid grid-cols-8 gap-6">
                    
                        <h3>Quantity</h3>
                        <h3>Time</h3>
                    </div>
                    @foreach ($sp->subProcessHistories as $history)
                       
                        <div class="grid grid-cols-8 gap-6">
                            <p>{{ $history->quantity }}</p>
                            <p>{{ $history->created_at }}</p>
                            @if ($history->is_done != 1)
                            <a href="/subproses/{{ $history->id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                            <form action="/subproses/history/{{ $history->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                            </form>
                            <a href="/generate/{{ $history->id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Generate QR</a>
                            <button type="button" class="bg-red-500 text-white px-4 py-3 rounded font-medium" onclick="printExternal('{{ '/print/'.$history->id }}')">Print</button>
                            @else
                            <a href="/subproses/{{ $history->id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                            <p>Telah dikonfimasi</p>
                            @endif
                            
                        </div>
                        
                    @endforeach
                </div>
               
                
                @endif

        @endforeach
        
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
