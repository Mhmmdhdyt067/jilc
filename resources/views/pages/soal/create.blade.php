@extends('layouts.app')

@section('content')

<div class="container my-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Detail TryOut</h3>
                    <div class="card-toolbar">
                        @can('isAdmin')

                        <a href="{{ route('hasil.export.pdf', [$id]) }}" target="_blank" class=" btn btn-sm btn-info">
                            <i class="fas fa-download"></i> Unduh Hasil
                        </a>

                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group mb-8">
                        <div class="alert alert-custom alert-default" role="alert">
                            <div class="alert-text">{{$title}} ({{ $waktu }} menit)</div>
                        </div>

                        <input type="hidden" id="tryout_id" value="{{ $id }}"> 
                        @can('isAdmin')

                        <button type="button" class="btn btn-success mb-3" id="btnTambahSoal">+ Tambah Soal</button>

                        <div id="containerSoal"></div>

                        <div class="form-soal d-none">
                            <div class="form-group border rounded p-3 mb-3 soal-item">
                                <label for="subject">Pilih Subject</label>
                                <select class="form-control subject-select" name="subject">
                                    <option value="">-- Pilih Subject --</option>
                                    <option value="1">TWK</option>
                                    <option value="2">TIU</option>
                                    <option value="3">TKP</option>
                                </select>

                                <div class="mb-3">
                                    <label>Soal (teks):</label>
                                    <textarea name="soal" class="form-control" rows="3" placeholder="Tulis soal..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Gambar Soal (opsional):</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" id="imageInput" onchange="previewImage(event, 'soal-preview')">
                                    <img id="soal-preview" src="" alt="Soal Preview" style="display:none; max-width: 70%; margin-top: 10px;">
                                </div>

                                @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="mb-0">Pilihan {{ $option }}</label>
                                        <div class="input-group-append jawaban-benar" style="display: none;">
                                            <div class="input-group-text">
                                                <input type="radio" name="jawaban_benar" value="{{ $option }}" class="form-check-input">
                                                <span class="ml-2"> Benar</span>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="text" name="pilihan_{{ $option }}_text" class="form-control mb-2" placeholder="Teks pilihan {{ strtoupper($option) }}">

                                    <input type="file" name="pilihan_{{ $option }}_gambar" class="form-control" accept="image/*" id="pilihan_{{ $option }}_gambar" onchange="previewImage(event, 'pilihan_{{ $option }}_preview')">
                                    <img id="pilihan_{{ $option }}_preview" src="#" alt="Preview Pilihan {{ $option }}" class="mt-2" style="display:none; width: 60%; height: auto;">
                                </div>
                                @endforeach

                                <div class="tkp-scores" style="display: none;">
                                    <label>Skor per Pilihan (TKP)</label>
                                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                    <div class="form-group">
                                        <label>Skor {{ $option }}</label>
                                        <input type="number" class="form-control" name="skor_{{ strtoupper($option) }}" min="0" max="5">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-primary mr-2" id="submitQuestions">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>

                        <div id="responseMessage" class="text-danger mt-3"></div>

                        @if(!empty($questions) && $questions->count() > 0)
                        @foreach($questions as $q)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>Soal Nomor {{ $loop->iteration }}</h3>
                            </div>
                            <div class="card-body">
                                <p><strong>Subject:</strong> {{ $q->subject->title ?? '-' }}</p>
                                <p>{{ $q->soal }}</p>

                                <!-- Tampilkan gambar jika ada -->
                                @if(!empty($q->image))
                                <div class="mb-2">
                                    <img src="{{ asset($q->image) }}" alt="Gambar Soal" class="img-fluid" style=" max-width: 70%;">
                                </div>
                                @endif

                                <ul style="list-style-type: none;">
                                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                    <li>
                                        <strong>{{ $option }}.</strong>
                                        @php
                                        $isi = $q->{'pilihan_' . strtolower($option)};
                                        @endphp

                                        @if(!empty($isi))
                                        @if(filter_var($isi, FILTER_VALIDATE_URL) || strpos($isi, 'tojilc/') === 0)
                                        <img src="{{ asset($isi) }}" alt="Pilihan {{ $option }}" style="max-width: 60%; height: auto;">
                                        @else
                                        {{ $isi }}
                                        @endif
                                        @else
                                        No image available
                                        @endif

                                        @if($q->subject_id == 3)
                                        (Skor: {{ $q->{'skor_' . strtolower($option)} }})
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @if($q->subject_id != 3) <!-- Hapus jawaban benar jika subject adalah TKP -->
                                <p><strong>Jawaban Benar:</strong> {{ $q->jawaban_benar }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @endcan

                        <div class="container-fluid text-center">
                            <button id="startButton" class="btn btn-primary btn-lg mt-5">Mulai Tes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event, previewId) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById(previewId);
                output.src = reader.result;
                output.style.display = "block";
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        $(document).ready(function() {
            let soalSudahDitambahkan = false;

            $('#btnTambahSoal').on('click', function() {
                if (soalSudahDitambahkan) return;

                const template = $('.form-soal').first();
                const clone = template.clone();
                clone.removeClass('d-none');

                // Menangani perubahan subject
                clone.find('.subject-select').on('change', function() {
                    const subject = $(this).val();
                    const jawabanBenar = clone.find('.jawaban-benar');
                    const tkpScores = clone.find('.tkp-scores');

                    if (subject === '3') {
                        tkpScores.show();
                        jawabanBenar.hide();
                    } else if (subject === '1' || subject === '2') {
                        tkpScores.hide();
                        jawabanBenar.show();
                    } else {
                        tkpScores.hide();
                        jawabanBenar.hide();
                    }
                });

                $('#containerSoal').append(clone);
                soalSudahDitambahkan = true;
            });

            $('#submitQuestions').on('click', function() {
                const tryoutId = $('#tryout_id').val();
                const formData = new FormData();

                // Ambil data dari satu soal
                const soalItem = $('.soal-item').first(); // Ambil hanya satu soal
                const subject = soalItem.find('.subject-select').val();
                const soal = soalItem.find('textarea[name="soal"]').val();
                const image = soalItem.find('input[name="image"]')[0].files[0];

                formData.append('subject', subject);
                formData.append('soal', soal);

                if (image) {
                    formData.append('image', image);
                }

                ['A', 'B', 'C', 'D', 'E'].forEach(option => {
                    const pilihanText = soalItem.find(`input[name="pilihan_${option}_text"]`).val();
                    const pilihanGambar = soalItem.find(`input[name="pilihan_${option}_gambar"]`)[0].files[0];
                    formData.append(`pilihan_${option}_text`, pilihanText);
                    if (pilihanGambar) {
                        formData.append(`pilihan_${option}_gambar`, pilihanGambar);
                    }

                    // Ambil skor jika subject adalah TKP
                    if (subject === '3') {
                        const skor = soalItem.find(`input[name="skor_${option}"]`).val();
                        formData.append(`skor_${option}`, skor ? skor : null); // Pastikan ini diambil dengan benar
                    }
                });

                // Kosongkan jawaban benar jika subject adalah TKP
                const jawabanBenar = subject === '3' ? null : soalItem.find('input[name="jawaban_benar"]:checked').val();
                formData.append('jawaban_benar', jawabanBenar);

                formData.append('tryout_id', tryoutId);

                $.ajax({
                    url: "{{ route('question.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#responseMessage').text(data.message);
                        if (data.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        $('#responseMessage').text('Terjadi kesalahan saat menambahkan soal.');
                    }
                });
            });

            $('#startButton').on('click', function() {
                let countdown = 5; // Set countdown time in seconds
                const button = $(this);
                button.prop('disabled', true); // Disable button during countdown
                button.text(`Mulai dalam ${countdown} detik...`);
                const interval = setInterval(function() {
                    countdown--;
                    button.text(`Mulai dalam ${countdown} detik...`);
                    if (countdown <= 0) {
                        clearInterval(interval);
                        window.location.href = `/question/${$('#tryout_id').val()}`; // Redirect to the tryout page
                    }
                }, 1000);
            });
        });
    </script>
    @endpush

    @endsection
