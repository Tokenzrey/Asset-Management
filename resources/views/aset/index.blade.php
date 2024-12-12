@extends('includes.template')

@section('menunya')
<h2>
    Aset <i class="fa fa-solid fa-arrow-right"></i> Data Aset
</h2>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-12">
                    <div class="card-header">
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
                        @php
                        $kat = old('kategori_id');
                        $ad = old('anggaran_dana_id');
                        $jp = old('jenis_pemeliharaan_id');
                        $rua = old('ruang_id');
                        $sup = old('vendor_id');
                        @endphp
                        <div>
                            @if (session('userdata')['status'] == 'ADMIN')
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target=".modal" style="margin-bottom: 1rem;"><i
                                    class="mdi mdi-plus me-1"></i>Tambah Data
                            </button>
                            @endif
                            <a href="{{ route('aset.scan_qrcode') }}">
                                <button type="button" class="btn btn-qrcode mb-2 text-white"
                                    style="margin-bottom: 1rem;">
                                    <i class="fa fa-qrcode"></i> By Qr-Code
                                </button>
                            </a>
                            <a href="{{ route('aset.export') }}">
                                <button type="button" class="btn btn-export-excel mb-2 text-white"
                                    style="margin-bottom: 1rem;">
                                    <i class="fa fa-file-excel"></i> Export Excel
                                </button>
                            </a>
                            <a href="#" id="modalTrigger" class="btn btn-import-excel text-white">
                                <i class="fa fa-file-excel"></i> Import Excel
                            </a>
                        </div>
                        <div>
                        </div>

                        @if (session('userdata')['status'] == 'ADMIN')
                        <!-- center modal tambah data -->
                        <div class="modal fade modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <img src="{{ asset('simas/images/inventory.png') }}" alt="" width="70px">
                                        <h3 class="modal-title"><b>Tambah Data Aset</b>
                                        </h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('aset.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <label><b>Nama
                                                                Penerima</b></label>
                                                        <input type="text" class="form-control" id="nama_penerima"
                                                            placeholder="Masukkan Nama Penerima" name="nama_penerima"
                                                            value="{{ old('nama_penerima') }}" required>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6 mt-2">
                                                        <label><b>Vendor</b></label>
                                                        <select class="form-control" name="vendor_id" id="vendor_id"
                                                            required>
                                                            <option value="" hidden>Pilih
                                                                Vendor</option>
                                                            @foreach ($vendor as $data)
                                                            <option value="{{ $data->id }}" {{ $sup==$data->id ?
                                                                'selected' : '' }}>
                                                                {{ $data->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-xl-6 mt-2 ">
                                                        <label><b>Tanggal Pembelian</b></label>
                                                        <input type="date" class="form-control" id="tanggal_pembelian"
                                                            placeholder="Masukkan Tanggal Pembelian"
                                                            name="tanggal_pembelian"
                                                            value="{{ old('tanggal_pembelian') }}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-12 mt-2">
                                                        <label><b>Nama Aset</b></label>
                                                        <input type="text" class="form-control" id="nama"
                                                            placeholder="Masukkan Nama Aset" name="nama"
                                                            value="{{ old('nama') }}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-12 mt-2">
                                                        <label>
                                                            <b>Gambar</b>
                                                        </label>
                                                        <input class="form-control" type="file" id="gambar"
                                                            name="gambar" placeholder="Pilih Gambar" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6 mt-2">
                                                        <label><b>Brand</b></label>
                                                        {{-- <input type="text" class="form-control" id="brand"
                                                            placeholder="Masukkan Brand Aset" name="brand"
                                                            value="{{ old('brand') }}" required> --}}
                                                        <select class="form-control" name="brand_id" id="brand_id"
                                                            required>
                                                            <option value="" hidden>
                                                                Data Brand
                                                            </option>
                                                            @foreach ($brands as $data)
                                                            <option value="{{ $data->id }}" {{ $jp==$data->id ?
                                                                'selected' : '' }}>
                                                                {{ $data->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-6 mt-2">
                                                        <label><b>Jenis
                                                                Pemeliharan</b></label>
                                                        <select class="form-control" name="jenis_pemeliharaan_id"
                                                            id="jenis_pemeliharaan_id" required>
                                                            <option value="" hidden>Pilih
                                                                Jenis
                                                                Pemeliharaan
                                                            </option>
                                                            @foreach ($jenis_pemeliharaan as $data)
                                                            <option value="{{ $data->id }}" {{ $jp==$data->id ?
                                                                'selected' : '' }}>
                                                                {{ $data->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6 mt-2">
                                                        <label><b>Kondisi</b></label>
                                                        <select class="form-control" name="kondisi" id="kondisi"
                                                            required>
                                                            <option value="" hidden>Pilih Kondisi Aset</option>
                                                            @foreach ($kondisi as $kondisis)
                                                            <option value="{{ $kondisis }}">
                                                                {{ $kondisis }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-xl-6 mt-2">
                                                        <label><b>Kategori</b></label>
                                                        <select class="form-control" name="kategori_id" id="kategori_id"
                                                            required>
                                                            <option value="" hidden>
                                                                Pilih Kategori Aset
                                                            </option>
                                                            @foreach ($kategori as $data)
                                                            <option value="{{ $data->id }}" {{ $kat==$data->id ?
                                                                'selected' : '' }}>
                                                                {{ $data->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 mt-2">
                                                        <label><b>Lokasi
                                                                Aset</b></label>
                                                        <select class="form-control" name="ruang_id" id="ruang_id"
                                                            required>
                                                            <option value="" hidden>Pilih
                                                                Lokasi
                                                                Aset</option>
                                                            @foreach ($ruang as $data)
                                                            <option value="{{ $data->id }}" {{ $rua==$data->id ?
                                                                'selected' : '' }}>
                                                                {{ $data->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-xl-6 mt-2">
                                                        <label><b>Penempatan
                                                                Aset</b></label>
                                                        <input type="text" class="form-control" id="tempat"
                                                            placeholder="Masukkan Penempatan Aset" name="tempat"
                                                            value="{{ old('tempat') }}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-12 mt-2">
                                                        <label><b>Serial Number</b></label>
                                                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="5"
                                                            class="form-control"
                                                            placeholder="Masukkan Serial Number Aset"
                                                            value="{{ old('deskripsi') }}"></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer border-top-0 d-flex mt-2">
                                                <button type="button" class="btn btn-danger light text-center"
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

                        <!-- center modal import excel data aset  -->
                        <div class="modal fade" id="modalImportExcel" tabindex="-1" role="dialog"
                            aria-labelledby="modalImportExcelLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <img src="{{ asset('simas/images/inventory.png') }}" alt="" width="70px">
                                        <h3 class="modal-title"><b>Import Data Aset</b>
                                        </h3>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>

                                    </div>
                                    <form action="{{ route('aset.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xl-12 mt-2">
                                                        <input class="form-control" type="file" name="file"
                                                            placeholder="Pilih Gambar" required>
                                                        <a href="{{ route('download-sample') }}">Download File
                                                            Contoh</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer border-top-0 d-flex mt-2">
                                                <button type="button" class="btn btn-danger light text-center"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" name="add" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div>
                    <div class="card-body card-body-table">
                        <div class="table-responsive" id="cetak">
                            @csrf
                            <table class="table mb-2 display" id="example3">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Gambar</th>
                                        <th>Kondisi</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Waktu Pemeliharaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @php
                                $no = 1;
                                @endphp
                                <tbody>
                                    @foreach ($aset as $item)
                                    <tr class="text-center @if ($item->is_maintenance_time) table-danger @endif">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            @if ($item['gambar'])
                                            <img class="img-thumbnail" src="{{ asset('storage/' . $item['gambar']) }}"
                                                alt="" width="60px">
                                            @endif
                                        </td>
                                        <td>{{ $item->kondisi }}</td>
                                        <td>{{ $item->ruang->nama }}</td>
                                        @if($item->DITERIMA)
                                        <td style="color:red">Sedang Dipinjam</td>
                                        @else
                                        <td style="color:green">Tersedia</td>
                                        @endif
                                        <td>@if($item->is_maintenance_time) <span class="text-success"><i
                                                    class="fas fa-check-circle"></i></span> @else <span
                                                class="text-danger"><i class="fas fa-times-circle"></i></span>@endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-qrcode text-white shadow btn-xs sharp me-1"
                                                    title="Qr-Code"
                                                    href="{{ route('aset.qrcode', ['id' => $item->kode]) }}">
                                                    <i class="fa fa-qrcode"></i></a>
                                                <a class="btn btn-detail text-white shadow btn-xs sharp me-1"
                                                    title="Detail" href="{{ route('aset.show', ['id' => $item->id]) }}">
                                                    <i class="fas fa-eye"></i></a>
                                                @if (session('userdata')['status'] == 'ADMIN')
                                                <a class="btn btn-edit text-white shadow btn-xs sharp me-1" title="Edit"
                                                    data-bs-toggle="modal" data-bs-target=".edit{{ $item->id }}">
                                                    <i class="fas fa-edit"></i></a>
                                                <a onclick="confirmation(event)"
                                                    href="{{ route('aset.destroy', ['id' => $item->id]) }}"
                                                    class="btn btn-delete text-white shadow btn-xs sharp me-1"
                                                    title="Hapus">
                                                    <i class="fa fa-trash"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    @if (session('userdata')['status'] == 'ADMIN')
                                    <!-- center modal edit data -->
                                    <div class="modal fade edit{{ $item->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <img src="{{ asset('simas/images/inventory.png') }}" alt=""
                                                        width="70px">
                                                    <h3 class="modal-title">
                                                        <b>Edit Aset</b>
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('aset.update', $item->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <label><b>Kode</b></label>
                                                                    <input type="text" class="form-control" id="kode"
                                                                        placeholder="Masukkan Kode"
                                                                        value="{{ $item->kode }}" disabled>
                                                                    <input type="hidden" name="kode"
                                                                        value="{{ $item->kode }}">
                                                                </div>

                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Tanggal
                                                                            Pembelian</b></label>
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_pembelian"
                                                                        placeholder="Masukkan Tanggal Pembelian"
                                                                        name="tanggal_pembelian"
                                                                        value="{{ $item->tanggal_pembelian }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Vendor</b></label>
                                                                    <select class="form-control" name="vendor_id"
                                                                        id="vendor_id" required>
                                                                        <option value="{{ $item->vendor_id }}" hidden>
                                                                            {{ $item->vendor->nama }}
                                                                        </option>
                                                                        @foreach ($vendor as $data)
                                                                        <option value="{{ $data->id }}" {{ $sup==$data->
                                                                            id ? 'selected' : '' }}>
                                                                            {{ $data->nama }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-xl-6 mt-2 ">
                                                                    <label><b>Nama
                                                                            Penerima</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama_penerima"
                                                                        placeholder="Masukkan Nama Penerima" disabled
                                                                        value="{{ $item->nama_penerima }}" required>
                                                                    <input type="hidden" name="nama_penerima"
                                                                        value="{{ $item->nama_penerima }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-12 ">
                                                                    <label><b>Nama
                                                                            Aset</b></label>
                                                                    <input type="text" class="form-control" id="nama"
                                                                        placeholder="Masukkan Nama Aset" name="nama"
                                                                        value="{{ $item->nama }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-12 mt-2">
                                                                    <label>
                                                                        <b>Gambar</b>
                                                                    </label>
                                                                    <div>
                                                                        @if ($item->gambar)
                                                                        <img class="img-thumbnail"
                                                                            src="{{ asset('storage/' . $item->gambar) }}"
                                                                            alt="" width="100px">
                                                                        <input class="form-control mt-1" type="file"
                                                                            id="gambar" name="gambar">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Brand</b></label>
                                                                    {{-- <input type="text" class="form-control"
                                                                        id="brand" placeholder="Masukkan Brand Aset"
                                                                        name="brand" value="{{ $item->brand }}"
                                                                        required> --}}
                                                                    <select class="form-control" name="brand_id"
                                                                        id="brand_id" required>
                                                                        <option value="{{ $item->brand->id }}" hidden>
                                                                            {{ $item->brand->name }}
                                                                        </option>
                                                                        @foreach ($brands as $data)
                                                                        <option value="{{ $data->id }}" {{ $jp==$data->
                                                                            id ? 'selected' : '' }}>
                                                                            {{ $data->name }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Jenis
                                                                            Pemeliharaan</b></label>
                                                                    <select class="form-control"
                                                                        name="jenis_pemeliharaan_id"
                                                                        id="jenis_pemeliharaan_id" required>
                                                                        <option
                                                                            value="{{ $item->jenis_pemeliharaan_id }}"
                                                                            hidden>
                                                                            {{ $item->jenis_pemeliharaan->nama }}
                                                                        </option>
                                                                        @foreach ($jenis_pemeliharaan as $data)
                                                                        <option value="{{ $data->id }}" {{ $jp==$data->
                                                                            id ? 'selected' : '' }}>
                                                                            {{ $data->nama }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Kondisi</b></label>
                                                                    <select class="form-control" name="kondisi"
                                                                        id="kondisi" required>
                                                                        <option value="{{ $item->kondisi }}" hidden>
                                                                            {{ $item->kondisi }}
                                                                        </option>
                                                                        @foreach ($kondisi as $kondisis)
                                                                        <option value="{{ $kondisis }}">
                                                                            {{ $kondisis }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Kategori</b></label>
                                                                    <select class="form-control" name="kategori_id"
                                                                        id="kategori_id" required>
                                                                        <option value="{{ $item->kategori_id }}" hidden>
                                                                            {{ $item->kategori->nama }}
                                                                        </option>
                                                                        @foreach ($kategori as $data)
                                                                        <option value="{{ $data->id }}" {{ $kat==$data->
                                                                            id ? 'selected' : '' }}>
                                                                            {{ $data->nama }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Lokasi
                                                                            Aset</b></label>
                                                                    <select class="form-control" name="ruang_id"
                                                                        id="ruang_id" required>
                                                                        <option value="{{ $item->ruang_id }}" hidden>
                                                                            {{ $item->ruang->nama }}
                                                                        </option>
                                                                        @foreach ($ruang as $data)
                                                                        <option value="{{ $data->id }}" {{ $rua==$data->
                                                                            id ? 'selected' : '' }}>
                                                                            {{ $data->nama }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-xl-6 mt-2">
                                                                    <label><b>Penempatan
                                                                            Aset</b></label>
                                                                    <input type="text" class="form-control" id="tempat"
                                                                        placeholder="Masukkan Penempatan Aset"
                                                                        name="tempat" value="{{ $item->tempat }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-12 mt-2">
                                                                    <label><b>Serial Number</b></label>
                                                                    <textarea name="deskripsi" id="deskripsi" cols="30"
                                                                        rows="5" class="form-control"
                                                                        placeholder="Masukkan Deskripsi">{{ $item->deskripsi }}
                                                                                                                </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="modal-footer border-top-0 d-flex">
                                                        <button type="button" class="btn btn-danger light"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" name="add" class="btn btn-primary">Update
                                                            Data</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                    @endif
                                    @endforeach
                        </div><!-- /.modal -->
                        </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section(' footer')
@endsection