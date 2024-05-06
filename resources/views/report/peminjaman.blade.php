<!-- MAIN CONTENT-->
<!-- Bootstrap CSS-->
<link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
<div class="container mt-3">
    <div id="kop" class="row">
        <div class="col-sm-2">
            <img class="img-fluid" src="{{ asset('simas/images/inventory.png') }}" />
        </div>
        <div class="col-sm-10 text-center">
            <h3>PT ABC</h3>
            <h5>Sidoarjo</h5>
            <p>Jawa Timur
                <br>email : testing@gmail.com website : https://yusuf-oksabri.my.id
            </p>
        </div>
    </div>
    <hr>
    <br>
    <h3 class="text-center">Data Peminjaman Aset</h3>
    <table class="table table-bordered table-striped table-earning text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Aset</th>
                <th>Peminjam</th>
                <th>Gambar</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($peminjaman as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ $item->aset->nama }}</td>
                    <td>
                        @if ($item->aset['gambar'])
                            <img class="img-thumbnail" src="{{ asset('storage/' . $item->aset['gambar']) }}" alt=""
                                width="60px">
                        @endif
                    </td>
                    <td>{{ $item->tanggal_pinjam }}</td>
                    <td>{{ $item->tanggal_kembali }}</td>
                    <td>{{ $item->keperluan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    window.print();
</script>
