@extends('layouts.main')

@section('content')
<h1>USER {{ $subProses[0]->user_id }}</h1>
<h2>Proses {{ $subProses[0]->process->process_name }}</h2>
<table>
    <thead>
        <tr>
            <th>Sub Process Material</th>
            <th>Sisa Target</th>
            <th>Selesai</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subProses as $subProses)
        <tr >
            <td class=" border border-black">{{ $subProses->processMaterial->process_material_name }}</td>
            <td class=" border border-black">{{ $subProses->sub_proses_projected }}</td>
            <td class=" border border-black">{{ $subProses->sub_proses_actual }}</td>
            <td class=" border border-black">{{ $subProses->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
