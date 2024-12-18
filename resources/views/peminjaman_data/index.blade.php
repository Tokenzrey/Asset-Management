@extends('includes.template')

@section('menunya')
<h2>
    Transaksi <i class="fa fa-solid fa-arrow-right"></i> Data Peminjaman
</h2>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-12">
                    <div class="row container">
                        <div class="col 12 text-center">
                            <h3 class="container"><b>Data Peminjaman</b></h3>
                        </div>
                    </div>
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
                        <a href="{{ route('peminjaman.index') }}">
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                data-bs-target=".modal" style="margin-bottom: 1rem;"><i
                                    class="mdi mdi-plus me-1"></i>Pinjam Aset
                            </button>
                        </a>
                        <a href="{{ route('peminjaman.data-history') }}">
                            <button type="button" class="btn btn-primary-history mb-2 text-white"
                                style="margin-bottom: 1rem;">
                                <i class="fas fa-history"></i> History
                            </button>
                        </a>
                    </div>
                    <div class="card-body card-body-table">
                        <div class="table-responsive" id="cetak">
                            @csrf
                            <table class="table table-striped mb-2" id="example3" class="display">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>Nama Peminjam</th>
                                        <th>Nama Aset</th>
                                        <th>Keperluan</th>
                                        <th>Gambar</th>
                                        <th>Tanggal Pinjam</th>
                                        {{--<th>Tanggal Pengembalian</th>--}}
                                        @if (session('userdata')['status'] == 'ADMIN')
                                        <th>Approval Peminjaman</th>
                                        @endif
                                    </tr>
                                </thead>
                                @php
                                $no = 1;
                                @endphp
                                <tbody>
                                    @foreach ($peminjaman as $item)
                                    <?php
                                    $btn = '';
                                    if ($item->status == 'PROSES'):
                                        $badge = 'badge-info';
                                        $btn = '<a href="' . url('peminjaman/update?id=' . $item->id . '&status=diterima&id_aset=' . $item->aset_id) . '"
                                                  data-id="' . $item->id . '"
                                                  data-status="diterima"
                                                  class="btn btn-success btn-sm btn-terima">Diterima</a>
                                                <a href="' . url('peminjaman/update?id=' . $item->id . '&status=ditolak&id_aset=' . $item->aset_id) . '"
                                                  data-id="' . $item->id . '"
                                                  data-status="ditolak"
                                                  class="btn btn-danger btn-sm btn-tolak">Ditolak</a>';
                                    elseif ($item->status == 'DITERIMA'):
                                        $badge = 'badge-success';
                                        $btn = '<a href="' . url('peminjaman/update?id=' . $item->id . '&status=selesai&id_aset=' . $item->aset_id) . '"
                                                  data-id="' . $item->id . '"
                                                  data-status="selesai"
                                                  class="btn btn-selesai btn-sm">Selesai</a>';
                                    elseif ($item->status == 'SELESAI'):
                                        $badge = 'badge-success';
                                    else:
                                        $badge = 'badge-danger';
                                    endif;
                                    ?>
                                    <tr class="text-center">
                                        <td>{{ $no++ }}</td>
                                        <td><span class="badge {{ $badge }} text-center">
                                                {{ $item->status }}</span></td>
                                        <td>{{ $item->user->nama }}</td>
                                        <td>{{ $item->aset->nama }}</td>
                                        <td>{{ $item->keperluan }}</td>
                                        <td>
                                            @if ($item->aset['gambar'])
                                            <img class="img-thumbnail"
                                                src="{{ asset('storage/' . $item->aset['gambar']) }}" alt=""
                                                width="60px">
                                            @endif
                                        </td>
                                        <td>{{ $item->tanggal_pinjam }}</td>
                                        {{--<td>{{ $item->tanggal_kembali }}</td>--}}
                                        @if (session('userdata')['status'] == 'ADMIN')
                                        <td>
                                            {!! $btn !!}
                                        </td>
                                        @endif
                                    </tr>
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