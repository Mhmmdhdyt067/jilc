@extends('layouts.app')

@section('content')
<div class="container my-3">
    <div class="row">
        <div class="col-xl-6">
            <!--begin::Stats Widget 25-->
            <div class="card card-custom card-stretch gutter-b bg-light-primary">
                <div class="card-body d-flex p-0">
                    <div class="flex-grow-1 p-8 card-rounded bgi-no-repeat d-flex align-items-center">
                        <div class="row">
                            <div class="col-12 col-xl-5">
                                <img src="{{asset('images/login/kedinasan.png')}}" alt="" width="100%">
                            </div>
                            <div class="col-12 col-xl-7">
                                <h4 class="text-danger font-weight-bolder">TRY OUT KEDINASAN </h4>
                                <p class="text-dark-50 my-5 font-size-xl font-weight-bold">Try Out Kedinasan ini dirancang khusus untuk membantu peserta mempersiapkan diri menghadapi Seleksi Kompetensi Dasar (SKD) dalam tes masuk sekolah kedinasan.</p>
                                <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-danger font-weight-bold py-2 px-6 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        KLIK DISINI
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="/tryout/mini">Mini</a>
            <a class="dropdown-item" href="/tryout/akbar">Akbar</a>
        </div>
    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Stats Widget 25-->
        </div>
        <div class="col-xl-3">
            <!--begin::Stats Widget 26-->
            <div class="card card-custom bg-light-danger card-stretch gutter-b">
                <!--begin::ody-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-danger">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $user }}</span>
                    <span class="font-weight-bold text-muted font-size-sm">Jumlah Siswa</span>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 26-->
        </div>
        <div class="col-xl-3">
            <!--begin::Stats Widget 27-->
            <div class="card card-custom bg-light-warning card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-warning">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3" />
                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$tryout}}</span>
                    <span class="font-weight-bold text-muted font-size-sm">Jumlah Tryout</span>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 27-->
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <!--begin::Charts Widget 3-->
            <div class="card card-custom card-stretch gutter-b">
                <!--begin::Header-->
                <div class="card-header h-auto border-0">
                    <div class="card-title py-5">
                        <h3 class="card-label">
                            <span class="d-block text-dark font-weight-bolder">Grafik Pengerjaan Try Out</span>
                            <span class="d-block text-muted mt-2 font-size-sm">Jumlah Siswa yang mengerjakan Tryout</span>
                        </h3>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body" style="position: relative;">
                    <div id="kt_charts_widget_3_chart2" style="min-height: 365px;">
                    </div>
                    <div class="resize-triggers">
                        <div class="expand-trigger">
                            <div style="width: 457px; height: 418px;"></div>
                        </div>
                        <div class="contract-trigger"></div>
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Charts Widget 3-->
        </div>
    </div>
</div>

<script>
    let listtryout = @json($listtryout);
    let jumlahsiswa = @json($jumlahsiswa);
</script>
@endsection