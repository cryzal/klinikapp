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
    <h1>Tambah Pemeriksaan</h1>
    <form method="POST" action="{{ route('examinations.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="mb-3">
                    <label for="patient_name" class="form-label">nama pasien</label>
                    <input class="form-control" id="patient_name" name="patient_name" value="{{ old('patient_name') }}">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-2">
                <div class="mb-3">
                    <label for="height" class="form-label">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" class="form-control" id="height" name="height" value="{{ old('height') }}">
                </div>
            </div>
               
            <div class="col-2">
                <div class="mb-3">
                    <label for="weight" class="form-label">Berat Badan (kg)</label>
                    <input type="number" step="0.1" class="form-control" id="weight" name="weight" value="{{ old('weight') }}">
                </div>
            </div>

            <div class="col-2">
                <div class="mb-3">
                    <label for="temperature" class="form-label">Suhu Tubuh (°C)</label>
                    <input type="number" step="0.1" class="form-control" id="temperature" name="temperature" value="{{ old('temperature') }}">
                </div>
            </div>
        </div>
        
       
        <div class="row">
            <div class="col-2">
                <div class="mb-3">
                    <label for="systole" class="form-label">Systole</label>
                    <input type="number" class="form-control" id="systole" name="systole" value="{{ old('systole') }}">
                </div>
            </div>

            <div class="col-2">
                <div class="mb-3">
                    <label for="diastole" class="form-label">Diastole</label>
                    <input type="number" class="form-control" id="diastole" name="diastole" value="{{ old('diastole') }}">
                </div>
            </div>

            <div class="col-2">
                <div class="mb-3">
                    <label for="heart_rate" class="form-label">Heart Rate</label>
                    <input type="number" class="form-control" id="heart_rate" name="heart_rate" value="{{ old('heart_rate') }}">
                </div>
            </div>

            <div class="col-2">
                <div class="mb-3">
                    <label for="respiration_rate" class="form-label">Respiration Rate</label>
                    <input type="number" class="form-control" id="respiration_rate" name="respiration_rate" value="{{ old('respiration_rate') }}">
                </div>
            </div>
        </div>
        

        <div class="mb-3">
            <label for="notes" class="form-label">Hasil Pemeriksaan</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Upload Berkas</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>

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
                <tr>
                    <td>
                        <select class="form-control medication-select" name="medication[]" style="width: 100%;">
                            <option value="">Pilih Obat</option>
                            <!-- Options obat akan diisi di sini -->
                        </select>
                    </td>
                    <td><input type="number" name="quantity[]" class="form-control" /></td>
                    <td><input type="text" name="dosage[]" class="form-control" /></td>
                    <td>
                        <button type="button" class="btn btn-success addRow">+</button>
                        <button type="button" class="btn btn-danger removeRow">-</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

@extends('footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let medicines = @json($medicines);

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
        // $('.medication-select').val('9cf72984-047a-4c48-bc12-de0c6437b5ae'); // Select the option with a value of 'US'
        // $('.medication-select').trigger('change'); // Notify any JS components that the value changed
        // Tambah baris
        $('#examinationTable').on('click', '.addRow', function() {
            let newRow = `<tr>
                <td>
                    <select class="form-control medication-select" name="medication[]" style="width: 100%;">
                        <option value="">Pilih Obat</option>
                    </select>
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