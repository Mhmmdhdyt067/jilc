<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use App\Http\Requests\StoreNilaiRequest;
use App\Http\Requests\UpdateNilaiRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Nilai;

class NilaiController extends Controller
{

    public function exportPdf($id)
    {
        $data = Nilai::where('tryout_id', $id)->with('user', 'subject', 'tryout')->get(); // sesuaikan dengan relasi model
        $pdf = Pdf::loadView('pdf.nilai', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->stream('hasil-tryout.pdf'); // bisa diganti ->download() jika ingin unduhan langsung
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store() {}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userId = auth()->id();

        $nilaiPerSubject = Nilai::where('user_id', $userId)
            ->where('tryout_id', $id)
            ->with('subject')
            ->get();

        $tryout = Tryout::findOrFail($id);
if ($tryout->jenis === 'akbar') {
            $totalPoin = $nilaiPerSubject->sum('total_poin');

            $nilaiPerSubject->push((object)[
    'user_id' => $userId,
    'tryout_id' => $id,
    'subject_id' => 'Total Poin',
    'status' => 'Mantapp',
    'total_poin' => $totalPoin,
    'subject' => (object)[
        'title' => 'Total Poin',
        'kode' => null
    ]
]);
}


        return view('pages.nilai.index', compact('nilaiPerSubject', 'tryout'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNilaiRequest $request, Nilai $nilai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        //
    }
}
