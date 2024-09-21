@extends('layouts')

<div class="container">
    <h2>Detail Pemeriksaan</h2>

    <div class="mb-4">
        <strong>Nama Pasien:</strong> {{ $examination->patient_name }}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Harga per Unit (IDR)</th>
                <th>Total Harga (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipts as $receipt)
            <tr>
                <td>{{ $receipt->medicine_name }}</td>
                <td>{{ $receipt->qty }}</td>
                <td>{{ number_format($receipt->medicine_price, 2) }}</td>
                <td>{{ number_format($receipt->medicine_price * $receipt->qty, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <h4><strong>Total Pembayaran: IDR {{ number_format($totalPayment, 2) }}</strong></h4>
    </div>

   
</div>