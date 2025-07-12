<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tryout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total tryout dan siswa
        $totalTryout = Tryout::count();
        $totalUser = User::where('role', 'siswa')->count();

        // Ambil nama tryout dan jumlah siswa yang ikut, lewat tabel nilai
        $data = DB::table('nilais')
            ->join('tryouts', 'nilais.tryout_id', '=', 'tryouts.id')
            ->select('tryouts.title', DB::raw('COUNT(DISTINCT nilais.user_id) as jumlah_siswa'))
            ->groupBy('tryouts.id', 'tryouts.title')
            ->get();

        // Pisahkan jadi dua array
        $listtryout = $data->pluck('title')->toArray();
        $jumlahsiswa = $data->pluck('jumlah_siswa')->toArray();

        return view('pages.dashboard.index', [
            'tryout' => $totalTryout,
            'user' => $totalUser,
            'listtryout' => $listtryout,
            'jumlahsiswa' => $jumlahsiswa,
        ]);
    }
}
