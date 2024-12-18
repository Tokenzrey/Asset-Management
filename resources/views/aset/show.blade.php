@extends('includes.template')

@section('menunya')
    <h2>
        Aset <i class="fa fa-solid fa-arrow-right"></i> Detail {{ $aset->nama }}
    </h2>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class=" mt-2 mt-sm-0">
                        <a href="{{ route('aset.index') }}">
                            <i class="fa fa-arrow-circle-left"></i>
                        </a>
                    </div>
                    <div class="text-center">
                        <div class="clearfix"></div>
                        <div>
                            @if ($aset->gambar != null)
                                <img class="avatar-lg img-thumbnail" src="{{ asset('storage/' . $aset['gambar']) }}"
                                    alt="" width="170px" />
                            @else
                                <img class="avatar-lg rounded-circle img-thumbnail"
                                    src="{{ asset('simas/images/ava.png') }}" alt="" width="100px" />
                            @endif
                        </div>
                        <h5 class="mt-3 mb-1">
                            {{ $aset->nama }}
                        </h5>
                        <hr class="my-4">
                        <img src="data:image/png;base64,
                                {!! base64_encode(
                                    QrCode::format('png')->size(200)->errorCorrection('H')->generate($aset->kode),
                                ) !!} ">
                        <a href="{{ route('aset.cetakqrcode', ['id' => $aset->kode]) }}" class="btn btn-primary"
                            style="width:110px; margin:5px 0;">Cetak QR Code</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
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
                                <li class="nav-item"><a href="#detail-aset" data-bs-toggle="tab"
                                        class="nav-link active show">Detail</a>
                                </li>
                                @if (session('userdata')['status'] == 'ADMIN')
                                <li class="nav-item"><a href="#pengaturan-asets" data-bs-toggle="tab"
                                        class="nav-link">Pengaturan</a>
                                </li>
                                @endif
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="detail-aset" class="tab-pane fade active show">
                                    <div class="profile-personal-info">
                                        <h4 class="text-primary mt-5 mb-4"><u>Detail Aset {{ $aset->nama }}</u></h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Kode Aset :
                                                    {{ $aset->kode }}
                                                </h5>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Nama Aset :
                                                    {{ $aset->nama }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Brand Aset :
                                                    {{ $aset->brand->name }}
                                                </h5>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Vendor :
                                                    {{ $aset->vendor->nama }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Nama Penerima :
                                                    {{ $aset->nama_penerima }}
                                                </h5>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Kategori :
                                                    {{ $aset->kategori->nama }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="mt-2"> Tanggal Pembelian:
                                                    {{ $aset->tanggal_pembelian }}
                                                </h5>
                                            </div>

                                            <div class="col-md-6">
                                                <h5 class="mt-2">Tempat Peletakan :
                                                    {{ $aset->tempat }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Kondisi :
                                                    {{ $aset->kondisi }}
                                                </h5>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Jenis Pemeliharaan :
                                                    {{ $aset->jenis_pemeliharaan->nama }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Lokasi Aset :
                                                    {{ $aset->ruang->nama }}
                                                </h5>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Jumlah Stok :
                                                    {{ $aset->jumlah }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="mt-2">Masa Manfaat:
                                                    {{ \Carbon\Carbon::parse($aset->tanggal_pembelian)->addYears($aset->kategori->masa_manfaat)->format('d-m-Y') }}
                                                </h5>
                                            </div>

                                            <div class="col-md-6">
                                                <h5 class="mt-2">Serial Number :
                                                    {{ $aset->deskripsi }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (session('userdata')['status'] == 'ADMIN')
                                <div id="pengaturan-asets" class="tab-pane fade">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <br>
                                            <h4 class="text-primary mb-4"><u>Pengaturan Aset</u></h4>
                                            <form action="{{ route('aset.update', $aset->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <label><b>Kode</b></label>
                                                            <input type="text" class="form-control" id="kode"
                                                                placeholder="Masukkan Kode" name="kode" disabled
                                                                value="{{ $aset->kode }}" required>
                                                        </div>
                                                        <div class="col-xl-6 mt-2">
                                                            <label><b>Tanggal Pembelian</b></label>
                                                            <input type="date" class="form-control"
                                                                id="tanggal_pembelian"
                                                                placeholder="Masukkan Tanggal Pembelian"
                                                                name="tanggal_pembelian"
                                                                value="{{ $aset->tanggal_pembelian }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-6 mt-2">
                                                            <label><b>Vendor</b></label>
                                                            <select class="form-control" name="vendor_id"
                                                                id="vendor_id" required>
                                                                <option value="{{ $aset->vendor_id }}" hidden>
                                                                    {{ $aset->vendor->nama }}</option>
                                                                @foreach ($vendor as $data)
                                                                    <option value="{{ $data->id }}"
                                                                        {{ $sup == $data->id ? 'selected' : '' }}>
                                                                        {{ $data->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-xl-6 mt-2 ">
                                                            <label><b>Nama Penerima</b></label>
                                                            <input type="text" class="form-control" id="nama_penerima"
                                                                placeholder="Masukkan Nama Penerima" name="nama_penerima"
                                                                disabled value="{{ $aset->nama_penerima }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-12 ">
                                                            <label><b>Nama Aset</b></label>
                                                            <input type="text" class="form-control" id="nama"
                                                                placeholder="Masukkan Nama Aset" name="nama"
                                                                value="{{ $aset->nama }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-12 mt-2">
                                                            <label>
                                                                <b>Gambar</b>
                                                            </label>
                                                            <div>
                                                                @if ($aset->gambar)
                                                                    <img class="img-thumbnail"
                                                                        src="{{ asset('storage/' . $aset->gambar) }}"
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
                                                            {{-- <input type="text" class="form-control" id="brand"
                                                                placeholder="Masukkan Brand Aset" name="brand"
                                                                value="{{ $aset->brand }}" required> --}}
                                                            <select class="form-control" name="brand_id" id="brand_id" required>
                                                                <option value="{{ $aset->brand->id }}" hidden>
                                                                    {{ $aset->brand->name }}
                                                                </option>
                                                                @foreach ($brands as $data)
                                                                <option value="{{ $data->id }}" {{ $jp==$data->id ? 'selected' : '' }}>
                                                                    {{ $data->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-xl-6 mt-2">
                                                            <label><b>Jenis Pemeliharaan</b></label>
                                                            <select class="form-control" name="jenis_pemeliharaan_id"
                                                                id="jenis_pemeliharaan_id" required>
                                                                <option value="{{ $aset->jenis_pemeliharaan_id }}" hidden>
                                                                    {{ $aset->jenis_pemeliharaan->nama }}
                                                                </option>
                                                                @foreach ($jenis_pemeliharaan as $data)
                                                                    <option value="{{ $data->id }}"
                                                                        {{ $jp == $data->id ? 'selected' : '' }}>
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
                                                                <option value="{{ $aset->kondisi }}" hidden>
                                                                    {{ $aset->kondisi }}
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
                                                                <option value="{{ $aset->kategori_id }}" hidden>
                                                                    {{ $aset->kategori->nama }}</option>
                                                                @foreach ($kategori as $data)
                                                                    <option value="{{ $data->id }}"
                                                                        {{ $kat == $data->id ? 'selected' : '' }}>
                                                                        {{ $data->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-6 mt-2">
                                                            <label><b>Lokasi Aset</b></label>
                                                            <select class="form-control" name="ruang_id" id="ruang_id"
                                                                required>
                                                                <option value="{{ $aset->ruang_id }}" hidden>
                                                                    {{ $aset->ruang->nama }}
                                                                </option>
                                                                @foreach ($ruang as $data)
                                                                    <option value="{{ $data->id }}"
                                                                        {{ $rua == $data->id ? 'selected' : '' }}>
                                                                        {{ $data->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-xl-6 mt-2">
                                                            <label><b>Penempatan Aset</b></label>
                                                            <input type="text" class="form-control" id="tempat"
                                                                placeholder="Masukkan Penempatan Aset" name="tempat"
                                                                value="{{ $aset->tempat }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-12 mt-2">
                                                            <label><b>Serial Number</b></label>
                                                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control"
                                                                placeholder="Masukkan Deskripsi">{{ $aset->deskripsi }}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-primary mt-3" type="submit">Perbarui Data
                                                        Aset</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('footer')
    @endsection
