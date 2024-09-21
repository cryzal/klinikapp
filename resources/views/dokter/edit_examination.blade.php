@extends('layouts')
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }
</style>

<div class="container">
    <h2>Edit Resep</h2>
    <form method="POST" action="{{ route('examinations.update', $examination->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="mb-3">
                    <label for="examination_time" class="form-label">Waktu Pemeriksaan</label>
                    <input  class="form-control @error('examination_time') is-invalid @enderror" id="examination_time" name="examination_time" value="{{ old('examination_time', $examination->converted_date) }}" disabled>
                    @error('examination_time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <div class="mb-3">
                    <label for="height" class="form-label">Tinggi Badan (cm)</label>
                    <input type="number" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height', $examination->height) }}">
                    @error('height')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
               
            <div class="col-2">
                <div class="mb-3">
                    <label for="weight" class="form-label">Berat Badan (kg)</label>
                    <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $examination->weight) }}">
                    @error('weight')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-2">
                <div class="mb-3">
                    <label for="temperature" class="form-label">Suhu Tubuh (°C)</label>
                    <input type="number" step="0.1" class="form-control" id="temperature" name="temperature" value="{{ old('temperature', $examination->temperature) }}">
                    @error('temperature')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-2">
                <div class="mb-3">
                    <label for="systole" class="form-label">Systole</label>
                    <input type="number" class="form-control @error('systole') is-invalid @enderror" id="systole" name="systole" value="{{ old('systole', $examination->systole) }}">
                    @error('systole')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-2">
                <div class="mb-3">
                    <label for="diastole" class="form-label">Diastole</label>
                    <input type="number" class="form-control @error('diastole') is-invalid @enderror" id="diastole" name="diastole" value="{{ old('diastole', $examination->diastole) }}">
                    @error('diastole')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
           
            <div class="col-2">
                <div class="mb-3">
                    <label for="heart_rate" class="form-label">Denyut Jantung</label>
                    <input type="number" class="form-control @error('heart_rate') is-invalid @enderror" id="heart_rate" name="heart_rate" value="{{ old('heart_rate', $examination->heart_rate) }}">
                    @error('heart_rate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-2">
                <div class="mb-3">
                    <label for="respiration_rate" class="form-label">Respiration rate</label>
                    <input type="number" class="form-control @error('respiration_rate') is-invalid @enderror" id="respiration_rate" name="respiration_rate" value="{{ old('respiration_rate', $examination->respiration_rate) }}">
                    @error('respiration_rate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>


        <div class="mb-3">
            <label for="notes" class="form-label">hasil Pemeriksaan</label>
            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes">{{ old('notes', $examination->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Upload File</label>
            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
            @if ($examination->file)
                <p>File saat ini: <a href="{{ Storage::url($examination->file) }}" target="_blank">{{ basename($examination->file) }}</a></p>
            @endif
            @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div> -->
        
        <h3>Resep</h3>
        <table class="table table-bordered" id="examinationTable">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Dosis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @if (count($receipts) > 0)
                @foreach($receipts as $index => $receipt)
                <tr>
                    <td>
                        <select class="form-control medication-select" name="medication[]" id="medication-{{$index}}" style="width: 100%;">
                            <option value="">Pilih Obat</option>
                            <!-- Options obat akan diisi di sini -->
                        </select>
                        <input type="hidden" name="receipt_id[]" value="{{ $receipt->id }}"/>
                    </td>
                    <td><input type="number" name="quantity[]" class="form-control" value="{{ $receipt->qty }}" /></td>
                    <td><input type="text" name="dosage[]" class="form-control" value="{{ $receipt->dosage }}"/></td>
                    <td>
                        <button type="button" class="btn btn-success addRow">+</button>
                        <button type="button" class="btn btn-danger removeRow">-</button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        <select class="form-control medication-select" name="medication[]" style="width: 100%;">
                            <option value="">Pilih Obat</option>
                            <!-- Options obat akan diisi di sini -->
                        </select>
                        <input type="hidden" name="receipt_id[]" value=""/>
                    </td>
                    <td><input type="number" name="quantity[]" class="form-control" /></td>
                    <td><input type="text" name="dosage[]" class="form-control" /></td>
                    <td>
                        <button type="button" class="btn btn-success addRow">+</button>
                        <button type="button" class="btn btn-danger removeRow">-</button>
                    </td>
                </tr>
            @endif
                
            </tbody>
        </table>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary">Cancel</a>

        <button type="submit" class="btn btn-primary">Update Resep</button>
    </form>
</div>

@extends('footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let medicines = @json($medicines);
    let receipts = @json($receipts);
    $(document).ready(function() {
        // Inisialisasi select2 untuk dropdown obat
        $('.medication-select').select2();
        // // Data dummy obat, Anda bisa mengganti dengan data obat dari database atau API
        // let medicines = [
        //     {id: 1, text: 'Paracetamol'},
        //     {id: 2, text: 'Amoxicillin'},
        //     {id: 3, text: 'Ibuprofen'},
        //     // Tambahkan data obat lainnya
        // ];

      // Menambahkan data obat ke dropdown
        $('.medication-select').select2({
            data: medicines.map(function(medicine) {
                return {id: medicine.id, text: medicine.name};
            })
        });

        receipts.forEach((receipt, index) => {
            console.log('#medication-'+index)
            $('#medication-'+index).val(receipt.medicine_id); // Select the option with a value of 'US'
            $('#medication-'+index).trigger('change'); // Notify any JS components that the value changed
        });
        // $('.medication-select').val('9cf72984-047a-4c48-bc12-de0c6437b5ae'); // Select the option with a value of 'US'
        // $('.medication-select').trigger('change'); // Notify any JS components that the value changed
        // Tambah baris
        $('#examinationTable').on('click', '.addRow', function() {
            let newRow = `<tr>
                <td>
                    <select class="form-control medication-select" name="medication[]" style="width: 100%;">
                        <option value="">Pilih Obat</option>
                    </select>
                    <input type="hidden" name="receipt_id[]" value=""/>
                </td>
                <td><input type="number" name="quantity[]" class="form-control" /></td>
                <td><input type="text" name="dosage[]" class="form-control" /></td>
                <td>
                    <button type="button" class="btn btn-success addRow">+</button>
                    <button type="button" class="btn btn-danger removeRow">-</button>
                </td>
            </tr>`;
            $('#examinationTable tbody').append(newRow);

           // Reinitialize select2 for new row
           $('.medication-select').select2({
                data: medicines.map(function(medicine) {
                    return {id: medicine.id, text: medicine.name};
                })
            });
        });

        // Kurangi baris
        $('#examinationTable').on('click', '.removeRow', function() {
            if ($('#examinationTable tbody tr').length > 1) {
                $(this).closest('tr').remove();
            } else {
                alert('Minimal harus ada satu baris.');
            }
        });
    });
</script>