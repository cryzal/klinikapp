<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Receipt;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ApothecaryController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function dashboard()
    {
        $examinations = Examination::all();
        return view('apoteker.dashboard', compact('examinations'));
    }

    public function showExamination($id)
    {   
        $examination = Examination::findOrFail($id);
        $receipts = Receipt::where('examination_id', $id)->get();

        try {
            $this->apiService->authenticate();
            $medicineDetails = $this->apiService->getMedicines();
        } catch (\Exception $e) {   
            dd($e->getMessage());   
            return back()->withErrors(['api' => $e->getMessage()]);
        }

        $receiptsDetailArr=[];
        foreach($medicineDetails['medicines'] as $medicineDetail){
            $receiptsDetailArr[$medicineDetail['id']] = $medicineDetail['name'];
        }

        foreach($receipts as $index => $receipt){
            $receipts[$index]->medicine_name = $receiptsDetailArr[$receipt->medicine_id];
        }
        $date = strtotime($examination->examination_time);
        $examinationDate = date('Y-m-d', $date);
        $totalPayment = 0;

        foreach ($receipts as $index => $receipt) {
            $this->apiService->authenticate();
            $priceData = $this->apiService->getMedicinePrice($receipt->medicine_id);
            foreach ($priceData['prices'] as $price) {
                $dateStartTime = strtotime($price['start_date']['value']);
                $startDate = date('Y-m-d', $dateStartTime);
                $dateEndTime = strtotime($price['end_date']['value']);
                $endDate = date('Y-m-d', $dateEndTime);

                if($examinationDate >= $startDate && $examinationDate <= $endDate){
                    $receipts[$index]['medicine_price']=$price['unit_price'];
                    $totalPayment += $receipts[$index]['medicine_price'] * $receipts[$index]['qty'];
                }
            }
        }

        return view('apoteker.examination-detail', compact('examination','receipts','totalPayment'));
    }


    public function pay($id)
    {
        $examination = Examination::findOrFail($id);
        $examination->status = 1;
        $examination->save();

        return response()->json(['success' => true]);
    }

    public function exportPdf($id)
    {
        $examination = Examination::findOrFail($id);
        $receipts = Receipt::where('examination_id', $id)->get();

        try {
            $this->apiService->authenticate();
            $medicineDetails = $this->apiService->getMedicines();
        } catch (\Exception $e) {      
            return back()->withErrors(['api' => $e->getMessage()]);
        }

        $receiptsDetailArr=[];
        foreach($medicineDetails['medicines'] as $medicineDetail){
            $receiptsDetailArr[$medicineDetail['id']] = $medicineDetail['name'];
        }

        foreach($receipts as $index => $receipt){
            $receipts[$index]->medicine_name = $receiptsDetailArr[$receipt->medicine_id];
        }
        $date = strtotime($examination->examination_time);
        $examinationDate = date('Y-m-d', $date);
        $totalPayment = 0;

        foreach ($receipts as $index => $receipt) {
            $this->apiService->authenticate();
            $priceData = $this->apiService->getMedicinePrice($receipt->medicine_id);
            foreach ($priceData['prices'] as $price) {
                $dateStartTime = strtotime($price['start_date']['value']);
                $startDate = date('Y-m-d', $dateStartTime);
                $dateEndTime = strtotime($price['end_date']['value']);
                $endDate = date('Y-m-d', $dateEndTime);

                if($examinationDate >= $startDate && $examinationDate <= $endDate){
                    $receipts[$index]['medicine_price']=$price['unit_price'];
                    $totalPayment += $receipts[$index]['medicine_price'] * $receipts[$index]['qty'];
                }
            }
        }

        $pdf = Pdf::loadView('apoteker.examination-pdf', compact('examination', 'receipts','totalPayment'));
        return $pdf->download('examination_' . $examination->id . '.pdf');
    }
}