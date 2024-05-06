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
    <h3 class="text-center">Data Supplier</h3>
    <table class="table table-bordered table-striped table-earning text-center">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($supplier as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    window.print();
</script>
