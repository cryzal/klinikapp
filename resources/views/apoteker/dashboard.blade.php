@extends('layouts')

<div class="container">
    <h2>Dashboard Apoteker</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pasien</th>
                <th>Waktu Pemeriksaan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($examinations as $examination)
            <tr>
                <td>{{ $examination->patient_name }}</td>
                <td>{{ $examination->created_at }}</td>
                <td>
                    @if($examination->status == 1)
                        <span class="badge bg-success">Terbayar</span>
                    @else
                        <span class="badge bg-warning">Belum Bayar</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('apoteker.showExamination', $examination->id) }}" class="btn btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
