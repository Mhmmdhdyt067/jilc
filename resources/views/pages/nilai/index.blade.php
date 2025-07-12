@extends('layouts.app')

@section('content')
<div class="container my-3">
    <div class="row">
        @foreach ($nilaiPerSubject as $nilai)
        @php
        $chartId = 'chart_subject_' . $loop->index;
        @endphp
        <div class="col-xl-4">
            <div class="card card-custom gutter-b card-stretch">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title font-weight-bolder">{{ $nilai->subject->title }}</h3>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="flex-grow-1" style="position: relative;">
                        <div id="{{ $chartId }}" class="chart-widget" style="height: 200px;"></div>
                    </div>
                    <div class="pt-5">
                        <h3 class="text-center">{{ $nilai->status }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <div class="row mb-3">
        <a href="/dashboard" class="btn btn-success btn-shadow-hover font-weight-bolder w-100 py-3">Kembali Ke Menu</a>
    </div>
</div>
@php
$chartData = $nilaiPerSubject->map(function ($item, $i) {
if ($item->subject->title === 'Total Poin') {
        $maxPoin = 550;
    } else {
        $maxPoin = match($item->subject->kode) {
            'TWK' => 30 * 5,
            'TIU' => 35 * 5,
            'TKP' => 45 * 5,
            default => 100
        };
};

$percent = ($item->total_poin / $maxPoin) * 100;

return [
'id' => 'chart_subject_' . $i,
'nilai' => $item->total_poin,
'percent' => round($percent, 2),
'subject' => $item->subject->title
];
});
@endphp
@push('widget')
<script>
    let chartData = @json($chartData);
</script>
@endpush

@endsection