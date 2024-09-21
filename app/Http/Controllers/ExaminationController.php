<?php

// app/Http/Controllers/ExaminationController.php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\ApiService;
use App\Models\Examination;
use App\Models\Prescription;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ExaminationController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $examinations = Examination::where('user_id', Auth::id())->get();
        
        $examinations = $examinations->map(function($examination) {
            $examination->examination_time = Carbon::parse($examination->examination_time)
                ->setTimezone('Asia/jakarta') // Konversi ke UTC+7
                ->format('Y-m-d H:i:s'); // Format sesuai kebutuhan
            return $examination;
        });
        return view('dokter.dashboard', compact('examinations'));
    }

    public function create(ApiService $apiService)
    {
        try {
            $apiService->authenticate();
            $medicines = $apiService->getMedicines();
        } catch (\Exception $e) {          
            return back()->withErrors(['api' => $e->getMessage()]);
        }
     
        return view('dokter.create_examination',[
            'medicines' => $medicines['medicines'] ?? [],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'systole' => 'nullable|integer',
            'diastole' => 'nullable|integer',
            'heart_rate' => 'nullable|integer',
            'respiration_rate' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
       
        DB::beginTransaction();
        try {
            $filePath = $request->file('file') ? $request->file('file')->store('uploads') : null;
            $examination = Examination::create([
                'user_id' => Auth::id(),
                'patient_name'=> $request->patient_name,
                'examination_time' => date('Y-m-d H:i:s'),
                'height' => $request->height,
                'weight' => $request->weight,
                'systole' => $request->systole,
                'diastole' => $request->diastole,
                'heart_rate' => $request->heart_rate,
                'respiration_rate' => $request->respiration_rate,
                'temperature' => $request->temperature,
                'notes' => $request->notes,
                'file' => $filePath,
            ]);

            if(count($request->medication)>0){
                for ($i=0; $i < count($request->medication); $i++) { 
                    Receipt::create([
                        'examination_id' => $examination->id,
                        'medicine_id' => $request->medication[$i],
                        'qty' => $request->quantity[$i],
                        'dosage' => $request->dosage[$i],
                    ]);
                }
            }
            
            DB::commit();

            return redirect()->route('dokter.dashboard')->with('success', 'Pemeriksaan berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $examination = Examination::findOrFail($id);
        $receipts = Receipt::where('examination_id', $id)->get();
       
        try {
            $this->apiService->authenticate();
            $medicines = $this->apiService->getMedicines();
        } catch (\Exception $e) {      
            return back()->withErrors(['api' => $e->getMessage()]);
        }

        $examination->converted_date = Carbon::parse($examination->date_time_field)
            ->setTimezone('Asia/jakarta')
            ->format('Y-m-d H:i:s');

        return view('dokter.edit_examination', [
            'examination' => $examination ,
            'receipts' => $receipts ,
            'medicines' => $medicines['medicines'] ?? []
        ]);
    }

    public function update(Request $request, Examination $examination)
    {
        $receipts = Receipt::where('examination_id', $examination->id)->get();
        Log::info('Data examination akan diperbarui', [
            'user_id' => Auth::id(),
            'examination_id' => $examination->id,
            'original_data' => $receipts->toArray(),
        ]);

        DB::beginTransaction();
        try {
            // $examination->update([
            //     'patient_name'=> $request->patient_name,
            //     'height' => $request->height,
            //     'weight' => $request->weight,
            //     'systole' => $request->systole,
            //     'diastole' => $request->diastole,
            //     'heart_rate' => $request->heart_rate,
            //     'respiration_rate' => $request->respiration_rate,
            //     'temperature' => $request->temperature,
            //     'notes' => $request->notes,
            //     'file' => $filePath,
            // ]);
    
            // Receipt::where('examination_id', $examination->id)->delete();
            if(count($request->medication)>0){
                for ($i=0; $i < count($request->medication); $i++) {
                    if($request->receipt_id[$i]!=null || $request->receipt_id[$i]!=""){
                        $receipt = Receipt::findOrFail($request->receipt_id[$i]);
                        $receipt->update([
                            'medicine_id' => $request->medication[$i],
                            'qty' => $request->quantity[$i],
                            'dosage' => $request->dosage[$i],
                        ]);
                    }else{
                        Receipt::create([
                            'examination_id' => $examination->id,
                            'medicine_id' => $request->medication[$i],
                            'qty' => $request->quantity[$i],
                            'dosage' => $request->dosage[$i],
                        ]);
                    }
                    
                }
            }

            $receipts = Receipt::where('examination_id', $examination->id)->get();
            Log::info('Data examination berhasil diperbarui', [
                'user_id' => Auth::id(),
                'examination_id' => $examination->id,
                'original_data' => $receipts->toArray(),
            ]);

            DB::commit();
            return redirect()->route('dokter.dashboard')->with('success', 'Pemeriksaan berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
    
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
    }
}
