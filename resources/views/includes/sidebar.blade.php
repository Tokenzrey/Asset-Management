<div class="sidebar-user text-center">
    <div class="badge-bottom mb-2">
        <img alt="image" width="100" src="{{ asset('simas/images/inventory.png') }}">
    </div>
    <span class="badge badge-primary">
        @if (session('userdata')['status'] != 'ADMIN' || session('userdata')['status'] != 'DIREKSI')
        {{ session('userdata')['username'] }}
        @else
        {{ session('userdata')['username'] }}
        @endif
    </span>
</div>

<ul class="metismenu" id="menu">
    @if (session('userdata')['status'] == 'ADMIN' || session('userdata')['status'] == 'DIREKSI')
    <li>
        @php
        $dashboardRoute = session('userdata')['status'] == 'ADMIN' ? 'dashboard.admin' : 'dashboard.user';
        @endphp

        <a href="{{ route($dashboardRoute) }}">
            <i class="fas fa-home"></i>
            <span class="nav-text">Dashboard</span>
        </a>
    </li>
    <li>
        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
            <i class="fa fa-list-alt"></i>
            <span class="nav-text">Master </span>
        </a>
        <ul aria-expanded="false">
            <li><a href="{{ route('user.index') }}">Data Pengguna</a></li>
            <li><a href="{{ route('divisi.index') }}">Data Divisi</a></li>
            <li><a href="{{ route('vendor.index') }}">Data Vendor</a></li>
            <li><a href="{{ route('brand.index') }}">Data Brand</a></li>
            <li><a href="{{ route('kategori.index') }}">Data Kategori</a></li>
            <li><a href="{{ route('ruang.index') }}">Data Lokasi</a></li>
            <li><a href="{{ route('jenis_pemeliharaan.index') }}">Data Jenis Pemeliharaan</a></li>
        </ul>
    </li>

    <li>
        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
            <i class="fa fa-briefcase"></i>
            <span class="nav-text">Aset </span>
        </a>
        <ul aria-expanded="false">
            <li><a href="{{ route('aset.index') }}">Data Aset</a></li>
            {{-- <li><a href="{{ route('aset.history') }}">History Aset</a></li> --}}
            {{--<li><a href="{{ route('aset.scan_qrcode') }}">Scann QrCode</a></li>--}}
            @if (session('userdata')['status'] == 'ADMIN')
            <li><a href="{{ route('jadwal_pemeliharaan.index') }}">Penjadwalan Pemeliharaan</a></li>
            @endif
        </ul>
    </li>
    @else
    <li><a href="{{ route('dashboard.user') }}">
            <i class="fas fa-home"></i>
            <span class="nav-text">Dashboard</span>
        </a>
    </li>
    <li><a href="{{ route('peminjaman.index') }}">
            <i class="fa fa-handshake"></i>
            <span class="nav-text">Peminjaman Manual</span>
        </a>
    </li>
    <li><a href="{{ route('peminjaman.qrcode') }}">
            <i class="fa fa-qrcode"></i>
            <span class="nav-text">Peminjaman Qr-Code</span>
        </a>
    </li>
    <li><a href="{{ route('peminjaman.user-history') }}">
            <i class="fa fa-file"></i>
            <span class="nav-text">History Peminjaman</span>
        </a>
    </li>
    @endif
    @if (session('userdata')['status'] == 'ADMIN' || session('userdata')['status'] == 'DIREKSI')
    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
            <i class="fa fa-handshake"></i>
            <span class="nav-text">Transaksi</span>
        </a>
        <ul aria-expanded="false">
            <li><a href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
            <li><a href="{{ route('peminjaman.data') }}">Data Peminjaman</a></li>
            <li><a href="{{ route('aset.scan_qrcode') }}">Scann QrCode</a></li>
            <li><a href="{{ route('peminjaman.data-history') }}">History Peminjaman</a></li>
        </ul>
    </li>
    <li><a href="{{ route('report.index') }}">
            <i class="fa fa-file"></i>
            <span class="nav-text">Report</span>
        </a>
    </li>
    @endif
    <li><a href="{{ route('logout') }}">
            <i class="fa fa-sign-out"></i>
            <span class="nav-text">Logout</span>
        </a>
    </li>

</ul>