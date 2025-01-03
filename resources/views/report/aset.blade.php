<!-- MAIN CONTENT-->
<!-- Bootstrap CSS-->
<link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
<div class="container mt-3">
    <div id="kop" class="row">
        <div class="col-sm-2">
            <img class="img-fluid" src="{{ asset('simas/images/inventory.png') }}" />
        </div>
        <div class="col-sm-10 text-center">
            <h3>PT XYZ</h3>
            <h5>Kota Sidoarjo</h5>
            <p>Jawa Timur
                <br>email : xyz@gmail.com
            </p>
        </div>
    </div>
    <hr>
    <br>
    <h3 class="text-center">Data Aset</h3>
    <table class="table table-bordered table-striped table-earning text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Tempat</th>
                <th>Kategori</th>
                <th>Vendor</th>
                <th>Tanggal Beli</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach ($aset as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kondisi }}</td>
                    {{--<td>
                        @if ($item['gambar'])
                            <img class="img-thumbnail" src="{{ asset('storage/' . $item['gambar']) }}" alt=""
                                width="60px">
                        @endif
                    </td>--}}
                    <td>{{ $item->ruang->nama }}</td>
                    <td>{{ $item->tempat }}</td>
                    <td>{{ $item->kategori->nama }}</td>
                    <td>{{ $item->vendor->nama }}</td>
                    <td>{{ $item->tanggal_pembelian }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    window.print();
</script>
