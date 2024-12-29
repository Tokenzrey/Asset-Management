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
                <br>email : XYZ@gmail.com
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
                <th>Status</th>
                <th>Tanggal Pemeliharaan</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($jp as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->aset->nama }}</td>
                                        <td><span class="text-center">{{ $item->status }}</span>
                                        </td>
                                        <td>{{ $item->tanggal_mulai }}</td>
                                        <td>{{ $item->tanggal_selesai }}</td>
                                    </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    window.print();
</script>
