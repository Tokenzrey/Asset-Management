@extends('includes.template')

@section('menunya')
<h2>
    Master <i class="fa fa-solid fa-arrow-right"></i> Data Kategori
</h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kategori</h4>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('userdata')['status'] == 'ADMIN')
                    <div>
                        <button type="button" class="btn btn-primary mb-4 " data-bs-toggle="modal" data-bs-target=".modal"
                            style="margin-bottom: 1rem;"><i class="mdi mdi-plus me-1"></i>Tambah Data</button>
                    </div>

                    <!-- center modal tambah data -->
                    <div class="modal fade modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <img src="{{ asset('simas/images/inventory.png') }}" alt="" width="70px">
                                    <h3 class="modal-title"><b>Tambah Kategori</b></h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('kategori.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label><b>Nama Kategori</b></label>
                                                    <input type="text" class="form-control" id="nama"
                                                        placeholder="Masukkan Nama Kategori" name="nama" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label><b>Masa Manfaat</b></label>
                                                    <input type="number" class="form-control" id="masa_manfaat"
                                                          name="masa_manfaat" required maxlength="3">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 d-flex">
                                            <button type="button" class="btn btn-danger light"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" name="add" class="btn btn-primary">Tambahkan
                                                Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    @endif
                </div>
                <div class="card-body card-body-table" id="cetak">
                    <div class="table-responsive">
                        @csrf
                        <table class="table table-striped mb-2" id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Masa Manfaat</th>
                                    @if (session('userdata')['status'] == 'ADMIN')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            <tbody>
                                @foreach ($kategori as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->masa_manfaat }} Tahun</td>
                                        @if (session('userdata')['status'] == 'ADMIN')
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-edit text-white shadow btn-xs sharp me-1" title="Edit"
                                                    data-bs-toggle="modal" data-bs-target=".edit{{ $item->id }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <a onclick="confirmation(event)"
                                                    href="{{ route('kategori.destroy', ['id' => $item->id]) }}"
                                                    class="btn btn-delete text-white shadow btn-xs sharp me-1"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @if (session('userdata')['status'] == 'ADMIN')
                                    <!-- center modal edit data -->
                                    <div class="modal fade edit{{ $item->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <img src="{{ asset('simas/images/inventory.png') }}"
                                                        alt="" width="70px">
                                                    <h3 class="modal-title"><b>Edit Kategori</b></h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('kategori.update', $item->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <label for="iduser"><b>Nama Kategori</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama" value="{{ $item->nama }}"
                                                                        placeholder="Masukkan Nama Kategori" name="nama"
                                                                        required>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <label for="iduser"><b>Masa Manfaat</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="masa_manfaat" value="{{ $item->masa_manfaat }}"
                                                                        placeholder="Masukkan Masa Manfaat Aset" name="masa_manfaat"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 d-flex">
                                                            <button type="button" class="btn btn-danger light"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" name="add"
                                                                class="btn btn-primary">Update Data</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section(' footer')
@endsection
