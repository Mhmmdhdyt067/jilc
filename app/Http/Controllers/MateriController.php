<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Subject;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MateriController extends Controller
{
    
    public function index()
    {
        return view('pages.tryout.index');
    }

    public function twk()
    {
        $materis = Materi::where('subject_id', 1)->get();
        return view('pages.materi.index', [
            'materis' => $materis
        ]);
    }
    
    public function tiu()
    {
        $materis = Materi::where('subject_id', 2)->get();
        return view('pages.materi.index', [
            'materis' => $materis
        ]);
    }

    public function tkp()
    {
        $materis = Materi::where('subject_id', 3)->get();
        return view('pages.materi.index', [
            'materis' => $materis
        ]);
    }

    public function download($id)
    {
       $materi = Materi::findOrFail($id); // Ambil data berdasarkan ID

    return response()->download($materi->file);
    }

    public function preview($id)
    {
         $materi = Materi::findOrFail($id); // Ambil data berdasarkan ID

    return response()->file($materi->file);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            // Simpan ke storage/app/public/soal

            $file = $request->file('file');
        // Get original extension
        $timestamp = date('YmdHis'); // Format: YYYYMMDDHHMMSS
        $filename = 'materi_' . $timestamp.'.pdf';
        // Store file in 'soal' folder in public disk with new filename
        $path = $file->storeAs('materi', $filename, 'public');
        // Build public path to save in DB
        $imagePath = 'tojilc/storage/app/public/materi/' . 'materi_' . $timestamp.'.pdf';

    }

    Materi::create([
        'title' => $request->title,
        'description' => $request->description,
        'author' => $request->author,
        'subject_id' => $request->subject_id,
        'file' => $imagePath,
    ]);

    return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tryout $tryout)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTryoutRequest $request, Tryout $tryout)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tryout $tryout)
    {
        
    }
}
