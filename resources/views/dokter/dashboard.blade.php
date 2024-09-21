@extends('layouts')

<div class="container">
    <h1>Dashboard Dokter</h1>
    <a href="{{ route('examinations.create') }}" class="btn btn-primary mb-3">Tambah Pemeriksaan</a>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Waktu Pemeriksaan</th>
                <th>Nama Pasien</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($examinations as $examination)
                <tr>
                    <td>{{ $examination->id }}</td>
                    <td>{{ $examination->examination_time }}</td>
                    <td>{{ $examination->patient_name }}</td>
                    <td>
                    @if($examination->status == 1)
                    <button class="btn btn-success btn-sm" disabled 
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="paid">
                            paid
                        </button>
                    @else
                    <a href="{{ route('examinations.edit', $examination->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
   
</script>