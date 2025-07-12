@extends('layouts.app')

@section('content')
<div class="container my-3">
    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Tambah TryOut</h3>

                </div>
                <!--begin::Form-->
                <form action="{{ route('tryout.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-8">

                        </div>
                        <div class="form-group">
                            <label>Nama Try Out</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Masukkan Nama Try Out">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Waktu</label>
                            <input type="number" name="waktu" class="form-control" id="waktu" placeholder="Waktu">
                        </div>
                        <div class="form-group">
    <label for="jenis">Jenis</label>
    <select name="jenis" class="form-control" id="jenis">
        <option value="mini">Mini</option>
        <option value="akbar">Akbar</option>
    </select>
</div>

                        <div class="form-group">
                            <label>Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Waktu Selesai</label>
                            <input type="datetime-local" name="end_time" class="form-control">

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>

@endsection