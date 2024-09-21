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
        <a href="{{ route('apoteker.dashboard') }}" class="btn btn-secondary">Kembali</a>
        @if($examination->status == 0)
            <button id="payButton" class="btn btn-success">Bayar</button>
        @endif
        <button id="exportButton" class="btn btn-primary" style="{{ $examination->status == 1 ? 'display:inline-block;' : 'display:none;' }}">Export PDF</button>

    </div>

    <div id="loading" class="spinner-border text-primary mt-3" role="status" style="display:none;">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('payButton');
        const exportButton = document.getElementById('exportButton');
        const loadingSpinner = document.getElementById('loading');

        if (payButton) {
            payButton.addEventListener('click', function () {
                fetch('{{ route('apoteker.pay', $examination->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                    alert("pembayaran sukses")
                        payButton.style.display = 'none';
                        exportButton.style.display = 'inline-block';
                    }
                });
            });
        }

        if (exportButton) {
            exportButton.addEventListener('click', function () {
                loadingSpinner.style.display = 'inline-block';
                window.location.href = '{{ route('apoteker.exportPdf', $examination->id) }}';
            });
        }
    });
</script>