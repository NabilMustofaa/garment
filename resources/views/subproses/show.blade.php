@extends('layouts.main')

@section('content')
<h1>USER {{ $subProses->subProcess->user_id }}</h1>
<h2>Proses {{ $subProses->subProcess->process->process_name }}</h2>
<table>
    <thead>
        <tr>
            <th>Sub Process Material</th>
            <th>Sisa Target</th>
            <th>Selesai</th>
            <th>Diserahkan</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        <tr >
            <td class=" border border-black">{{ $subProses->subProcess->processMaterial->process_material_name }}</td>
            <td class=" border border-black">{{ $subProses->subProcess->sub_proses_projected }}</td>
            <td class=" border border-black">{{ $subProses->subProcess->sub_proses_actual }}</td>
            <td class=" border border-black">{{ $subProses->quantity }}</td>
            <td class=" border border-black">{{ $subProses->subProcess->updated_at }}</td>
        </tr>
        
    </tbody>
</table>
@if ($subProses->is_done == 1)
    <h1>Sub Process Selesai dan telah dikonfirmasi</h1>
@else
<form action="/subproses/update/{{ $subProses->subProcess->id }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="quantity" value="{{ $subProses->quantity }}">
    <input type="hidden" name="sph_id" value="{{ $subProses->id }}">
    <input type="hidden" name="user_id" value="{{ $subProses->subProcess->user_id }}">
    <input type="hidden" name="process_id" value="{{ $subProses->subProcess->process_id }}">
    <input type="hidden" name="process_material_id" value="{{ $subProses->subProcess->process_material_id }}">
    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Konfirmasi</button>

</form>
@endif
@endsection
