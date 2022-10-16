@extends('layouts.app')
@section('content')

<div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Alat</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>kode</th>
                                            <th>status</th>
                                            <th>tanggal ditambahkan</th>
                                            <th>option</th>
                                        </tr>
                                        @foreach($key as $s)
                                        <tr>
                                            <th>{{$s->id}}</th>
                                            <th>{{$s->status}}</th>
                                            <th>{{$s->created_at}}</th>
                                            <th><a href="deletedevice/{{$s->id}}" type="button" class="btn btn-danger">hapus</a></th>
                                        </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


@endsection