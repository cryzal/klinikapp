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
                <th>Tinggi Badan</th>
                <th>Berat Badan</th>
                <th>Systole</th>
                <th>Diastole</th>
                <th>Heart Rate</th>
                <th>Respiration Rate</th>
                <th>Suhu Tubuh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($examinations as $examination)
                <tr>
                    <td>{{ $examination->id }}</td>
                    <td>{{ $examination->examination_time }}</td>
                    <td>{{ $examination->height }}</td>
                    <td>{{ $examination->weight }}</td>
                    <td>{{ $examination->systole }}</td>
                    <td>{{ $examination->diastole }}</td>
                    <td>{{ $examination->heart_rate }}</td>
                    <td>{{ $examination->respiration_rate }}</td>
                    <td>{{ $examination->temperature }}</td>
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