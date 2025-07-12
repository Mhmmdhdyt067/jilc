@extends('layouts.app')

@section('content')

<form id="tryout-form" action="{{ route('question.update', $tryout->id) }}" method="POST">
    @method('PATCH')
    @csrf
    <div class="container-fluid">
        <div class="row my-4 text-center">
            <div class="col-12">
                <h2>{{ $tryout->title }}</h2>
                <h5 id="timer" class="text-danger font-weight-bold"></h5>
            </div>
        </div>

        <div class="row">
            {{-- Bagian Sidebar Navigasi Soal --}}
            <div class="col-xl-3 col-lg-4 col-md-4 col-12 mb-4">
                <div class="card card-custom card-shadowless card-stretch gutter-b card-spacer p-4">
                    <div class="card-body text-center">
                        <div class="d-flex flex-wrap justify-content-start align-items-center">
                            @foreach($questions as $index => $question)
                            <button type="button"
                                class="btn m-1 question-button {{ $loop->first ? 'btn-primary' : 'btn-outline-primary' }}"
                                data-question-id="{{ $question->id }}"
                                data-question-index="{{ $index }}"
                                id="btn-{{ $question->id }}"
                                style="flex: 0 0 calc(20% - 8px);">
                                <span class="btn-text">{{ $index + 1 }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Card Soal --}}
            <div class="col-xl-9 col-lg-8 col-md-8 col-12">
                @foreach ($questions as $index => $question)
                <div class="card card-custom bg-light card-stretch gutter-b question-card"
                    id="question-{{ $question->id }}" style="{{ $loop->first ? '' : 'display: none;' }}"
                    data-question-index="{{ $index }}">

                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bold text-dark">Soal {{ $loop->iteration }}</h3>
                    </div>

                    <div class="card-body pt-2 text-left">
                        {{-- Tampilkan Gambar Soal --}}
                        @if ($question->image)
                        <div class="mb-3 text-center">
                            <img src="{{ asset($question->image) }}" width="400px" alt="Soal Gambar">
                        </div>
                        @endif

                        {{-- Tampilkan Teks Soal --}}
                        @if ($question->soal)
                        <h5>{!! nl2br(e($question->soal)) !!}</h5>
                        @endif

                        {{-- Input Hidden untuk Jawaban (akan diisi via JS) --}}
                        <input type="hidden" name="answers[{{ $question->id }}]" value="" class="hidden-answer-input" />

                        {{-- Opsi Pilihan Jawaban --}}
                        <div class="form-group mt-5">
                            <div class="radio-inline">
                                <div class="pilihan-wrapper">
                                    @foreach(['a', 'b', 'c', 'd', 'e'] as $option)
                                        <label class="radio pilihan-item">
                                            <input type="radio" name="radio_answers[{{ $question->id }}]" value="{{ $option }}" data-question-id="{{ $question->id }}" />
                                            <span></span>
                                            @php
                                                $isi = $question->{'pilihan_' . strtolower($option)};
                                            @endphp
                                            @if(strpos($isi, 'tojilc/') === 0)
                                                <img src="{{ asset($isi) }}" alt="Pilihan {{ strtoupper($option) }}" style="max-width: 40%; height: auto;">
                                            @else
                                                {{ $isi }}
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Navigasi 'Sebelumnya' dan 'Selanjutnya' --}}
                    <div class="card-footer d-flex justify-content-between border-0">
                        <button type="button" class="btn btn-primary btn-prev">Sebelumnya</button>
                        <button type="button" class="btn btn-primary btn-next">Selanjutnya</button>
                    </div>

                </div>
                @endforeach

                {{-- Hapus tombol 'Selesai dan Kirim' yang lama --}}
                {{-- <button type="submit" class="btn btn-success mt-3 w-100">Selesai dan Kirim</button> --}}
            </div>
        </div>
    </div>
</form>

@push('scripts')
@php
$waktu = $tryout->waktu * 60;
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalTime = @json($waktu); // waktu dalam detik
        let timeLeft = totalTime;
        const timerDisplay = document.getElementById('timer');
        const form = document.getElementById('tryout-form');
        const questionCards = document.querySelectorAll('.question-card');
        const questionButtons = document.querySelectorAll('.question-button');
        const prevButtons = document.querySelectorAll('.btn-prev');
        const nextButtons = document.querySelectorAll('.btn-next');
        const radioInputs = document.querySelectorAll('input[type="radio"]');
        const hiddenAnswerInputs = document.querySelectorAll('.hidden-answer-input');
        
        let currentQuestionIndex = 0;
        const totalQuestions = questionCards.length;

        // --- TIMER LOGIC ---
        function updateTimer() {
    const hours = Math.floor(timeLeft / 3600);
    const minutes = Math.floor((timeLeft % 3600) / 60);
    const seconds = timeLeft % 60;

    // Tambahkan leading zero jika perlu
    const format = num => num < 10 ? `0${num}` : num;

    timerDisplay.textContent = `${format(hours)}.${format(minutes)}.${format(seconds)}`;

    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        alert('Waktu habis! Jawaban Anda akan otomatis dikirim.');
        submitForm();
    } else {
        timeLeft--;
    }
}
        
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);

        // --- QUESTION NAVIGATION LOGIC ---
        function showQuestion(index) {
            // Sembunyikan semua card soal
            questionCards.forEach(card => card.style.display = 'none');
            
            // Tampilkan card soal yang sesuai
            const currentCard = questionCards[index];
            if (currentCard) {
                currentCard.style.display = 'block';
                
                // Atur status tombol 'Sebelumnya'
                const prevBtn = currentCard.querySelector('.btn-prev');
                if (prevBtn) {
                    prevBtn.disabled = (index === 0);
                }
                
                // Atur teks tombol 'Selanjutnya'
                const nextBtn = currentCard.querySelector('.btn-next');
                if (nextBtn) {
                    if (index === totalQuestions - 1) {
                        nextBtn.textContent = 'Selesai dan Kirim';
                        nextBtn.classList.remove('btn-primary');
                        nextBtn.classList.add('btn-success');
                    } else {
                        nextBtn.textContent = 'Selanjutnya';
                        nextBtn.classList.remove('btn-success');
                        nextBtn.classList.add('btn-primary');
                    }
                }
                
                // Update status tombol navigasi di sidebar
                questionButtons.forEach((btn, i) => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                    if (i === index) {
                        btn.classList.remove('btn-outline-primary');
                        btn.classList.add('btn-primary');
                    }
                });
            }
            
            currentQuestionIndex = index;
        }

        function saveAnswer(questionId) {
            const selectedRadio = document.querySelector(`input[name="radio_answers[${questionId}]"]:checked`);
            const hiddenInput = document.querySelector(`input.hidden-answer-input[name="answers[${questionId}]"]`);
            
            if (hiddenInput) {
                hiddenInput.value = selectedRadio ? selectedRadio.value : '';
            }
            
            // Tandai tombol navigasi di sidebar
            const btn = document.getElementById('btn-' + questionId);
            if (btn) {
                const textSpan = btn.querySelector('.btn-text');
                if (selectedRadio) {
                    btn.classList.remove('btn-outline-primary', 'btn-primary');
                    btn.classList.add('btn-primary');
                    textSpan.innerHTML = '&#10003;'; // Ceklis
                } else {
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-primary');
                    textSpan.innerText = btn.getAttribute('data-question-index')*1 + 1;
                }
            }
        }

        function submitForm() {
            // Validasi dan simpan semua jawaban terakhir sebelum submit
            questionCards.forEach(card => {
                const qId = card.id.replace('question-', '');
                saveAnswer(qId);
            });
            
            // Cek apakah semua soal sudah dijawab (opsional)
            let unansweredCount = 0;
            hiddenAnswerInputs.forEach(input => {
                if (!input.value) {
                    unansweredCount++;
                }
            });

            if (unansweredCount > 0) {
                const confirmSubmit = confirm(`Anda belum menjawab ${unansweredCount} soal. Apakah Anda yakin ingin mengirim jawaban?`);
                if (!confirmSubmit) {
                    return; // Batalkan submit jika user tidak yakin
                }
            }
            
            form.submit();
        }

        // --- EVENT LISTENERS ---
        
        // Listener untuk tombol "Sebelumnya"
        prevButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const currentCard = this.closest('.question-card');
                const qId = currentCard.id.replace('question-', '');
                saveAnswer(qId); // Simpan jawaban soal saat ini
                
                if (currentQuestionIndex > 0) {
                    showQuestion(currentQuestionIndex - 1);
                }
            });
        });

        // Listener untuk tombol "Selanjutnya" / "Selesai dan Kirim"
        nextButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const currentCard = this.closest('.question-card');
                const qId = currentCard.id.replace('question-', '');
                saveAnswer(qId); // Simpan jawaban soal saat ini

                if (currentQuestionIndex < totalQuestions - 1) {
                    showQuestion(currentQuestionIndex + 1);
                } else {
                    // Ini adalah soal terakhir, submit form
                    submitForm();
                }
            });
        });

        // Listener untuk tombol sidebar (navigasi langsung)
        questionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const newIndex = parseInt(this.getAttribute('data-question-index'));
                const currentCard = questionCards[currentQuestionIndex];
                if (currentCard) {
                    const qId = currentCard.id.replace('question-', '');
                    saveAnswer(qId); // Simpan jawaban soal sebelum pindah
                }
                
                showQuestion(newIndex);
            });
        });

        // Listener untuk radio button (langsung update hidden input dan sidebar)
        radioInputs.forEach(input => {
            input.addEventListener('change', function() {
                const qId = this.getAttribute('data-question-id');
                saveAnswer(qId); // Update hidden input dan tombol sidebar
            });
        });
        
        // --- INITIALIZATION ---
        // Tampilkan soal pertama saat halaman dimuat
        showQuestion(0);
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endpush

@push('style')
<style>
    .pilihan-wrapper {
        display: flex;
        flex-direction: column;
    }

    /* Setiap item pilihan (label) */
    .pilihan-item {
        display: flex;
        align-items: center; /* Sejajarkan secara vertikal di tengah */
        gap: 15px; /* Jarak antara radio dan teks/gambar */
        padding: 15px 20px; /* Padding di dalam item */
        background-color: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 12px; /* Sudut lebih melengkung */
        cursor: pointer;
        transition: all 0.3s ease; /* Transisi untuk efek hover */
    }

    /* Efek saat di-hover */
    .pilihan-item:hover {
        background-color: #f0f0f0;
        border-color: #c0c0c0;
        transform: translateY(-2px); /* Sedikit naik saat di-hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); /* Tambah bayangan */
    }

    /* Style untuk input radio asli */
    .pilihan-item input[type="radio"] {
        /* Sembunyikan radio button bawaan browser */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;

        /* Ukuran radio button kustom */
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 50%; /* Bulat sempurna */
        outline: none;
        cursor: pointer;
        transition: border-color 0.3s ease, background-color 0.3s ease;
        position: relative;
        flex-shrink: 0; /* Pastikan tidak mengecil saat ada teks panjang */
    }

    /* Style untuk radio button saat dicek */
    .pilihan-item input[type="radio"]:checked {
        border-color: #3699FF; /* Warna border saat dipilih */
        background-color: #3699FF; /* Warna background saat dipilih */
    }
    
    /* Titik di tengah radio button saat dicek */
    .pilihan-item input[type="radio"]:checked::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: white;
    }

    /* Teks pilihan */
    .pilihan-item span {
        flex-grow: 1; /* Biarkan teks mengisi ruang yang tersisa */
        font-size: 1rem;
        line-height: 1.5;
    }

    /* Gambar pilihan */
    .pilihan-item img {
        width: auto;
        max-height: 100px;
        display: block; /* Hindari spasi di bawah gambar */
    }
    
    /* Hilangkan margin-bottom pada label bawaan dari framework */
    .radio-inline .radio {
        margin-right: 0 !important;
        margin-bottom: 0 !important;
    }

    /* Style untuk tombol navigasi */
    .card-body.text-center > .d-flex {
    /* Container untuk tombol-tombol nomor */
    display: flex;
    flex-wrap: wrap; /* Izinkan item untuk pindah baris */
    justify-content: space-between; /* Rata kiri dan kanan */
    align-items: center;
    gap: 8px; /* Jarak antar tombol */
}

/* Style untuk setiap tombol nomor soal */
.question-button {
    /* Flex-basis: 18% untuk 5 item per baris */
    flex-basis: 5%; /* (100% / 5) - margin/gap */
    max-width: 18%; /* Batasi lebar maksimum */
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    font-size: 1rem;
    border-radius: 2px; /* Tambahkan border radius */
    padding: 5px; /* Sesuaikan padding */
    transition: all 0.2s;
}

/* Hapus margin yang ada di class m-1 */
.question-button.m-1 {
    margin: 0 !important;
}

/* Style untuk tombol aktif/terpilih */
.question-button.btn-primary {
    background-color: #3699FF;
    border-color: #3699FF;
    color: white;
}

/* Style untuk tombol yang sudah dijawab */
.question-button.btn-success {
    background-color: #28a745; /* Hijau */
    border-color: #28a745;
    color: white;
}

/* Style untuk tombol yang belum dijawab */
.question-button.btn-outline-primary {
    background-color: transparent;
    border-color: #007bff;
    color: #007bff;
}

.btn-text {
    font-size: 1rem; /* Ukuran teks atau ceklis */
}
    
    /* Tombol navigasi di dalam card soal */
    .card-footer .btn-prev {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .card-footer .btn-prev:hover:not(:disabled) {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .card-footer .btn-prev:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@endsection