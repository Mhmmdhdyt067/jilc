@extends('layouts.app')

@section('content')
<div class="container my-3">
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Daftar Materi</h3>
            @if (auth()->user()->role === 'admin')
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahMateri">
    <i class="fas fa-plus"></i> Tambah Materi
</button>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @forelse ($materis as $materi)
                <div class="card card-custom mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Home\Book-open.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" fill="#000000"/>
        <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            <h3 class="card-label mx-3">
                                {{ $materi->title }}
                                @if($materi->created_at->gt(now()->subDays(3)))
                                   <span class="label label-success label-pill label-inline mr-2">New</span>
                                @endif
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('materi.download', $materi->id) }}" class="btn btn-sm btn-icon btn-light-success mr-2" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="{{ route('materi.preview', $materi->id) }}" target="_blank" class="btn btn-sm btn-icon btn-light-primary" title="Baca">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $materi->description }}
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            
                        </small>
                        <small class="text-muted">
                            {{ $materi->author ?? 'Tidak diketahui' }} ,{{ $materi->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>
            @empty
                <div class="card card-custom">
                    <div class="card-body text-center">
                        <div class="alert alert-custom alert-outline-danger fade show mb-5" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text">Tidak ada Materi yang Tersedia Sekarang, Silahkan kembali lagi nanti!</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
                    </div>
                </div>
            @endforelse

            <!-- Modal Tambah Materi -->
<div class="modal fade" id="modalTambahMateri" tabindex="-1" role="dialog" aria-labelledby="modalTambahMateriLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahMateriLabel">Tambah Materi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="title">Judul Materi</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="author">Penulis</label>
            <input type="text" name="author" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="description">Deskripsi Singkat</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="subject_id">Subject</label>
            <select name="subject_id" class="form-control" required>
                <option value="1">Tes Wawasan Kebangsaan</option>
                <option value="2">Tes Intelegensi Umum</option>
                <option value="3">Tes Karakteristik Pribadi</option>
            </select>
          </div>
          <div class="form-group">
            <label for="file">Upload File PDF</label>
            <input type="file" name="file" class="form-control" accept="application/pdf" required>
          </div>
          <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

        </div>
    </div>
</div>
@endsection
