@extends('includes.template')

@section('menunya')
Report
@endsection

@section('content')
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laporan</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin-lte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('admin-lte/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/AdminLTE.min.css') }}">
</head>

<body class="">
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div>
                    <div class="small-box bg-white rounded">
                        <div class="inner">
                            <h3 class="text-white"></h3>
                            <p class="text-primary"><b>Report <br> Aset</b></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-briefcase" aria-hidden="true"></i>
                        </div>
                        <button class="small-box bg-primary text-white text-center" data-bs-toggle="modal"
                            data-bs-target="#modalReportAset" style="padding: 8px 0; width: 100%; border: 0;">Print
                            <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div>
                    <div class="small-box bg-white rounded">
                        <div class="inner">
                            <h3 class="text-white"></h3>
                            <p class="text-primary"><b>Report <br> Peminjaman Aset</b></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-th-list"></i>
                        </div>
                        <button class="small-box bg-primary text-white text-center" data-bs-toggle="modal"
                            data-bs-target="#modalReportPeminjaman"
                            style="padding: 8px 0; width: 100%; border: 0;">Print
                            <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
                {{--
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div>
                    <a href="{{ route('report.history_pemeliharaan') }}" class="small-box bg-white rounded">
                        <div class="inner">
                            <h3 class="text-white"></h3>
                            <p class="text-primary"><b>Report <br> Pemeliharan Aset</b></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-wrench" aria-hidden="true"></i>
                        </div>
                        <div class="small-box bg-primary text-white text-center">Print <i
                                class="fa fa-arrow-circle-right"></i></div>
                    </a>
                </div>--}}
            </div>
        </div>
    </section>
    <!-- Modal untuk Report Aset -->
    <div class="modal fade" id="modalReportAset" tabindex="-1" role="dialog" aria-labelledby="modalLabelAset"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelExport">Export Data ke PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('report.aset') }}" method="GET">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="month">Periode Bulan</label>
                            <select class="form-control" id="month_aset" name="month_aset">
                                <option value="">--- Pilih Bulan ---</option>
                                @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m,
                                    1)) }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="year">Periode Tahun</label>
                            <select class="form-control" id="year_aset" name="year_aset">
                                <option value="">--- Pilih Tahun ---</option>
                                @for ($y = date('Y'); $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="allData_aset" name="all_data_aset" value="1">
                            <label class="form-check-label" for="allData_aset">Export Semua Data</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Report Peminjaman -->
    <div class="modal fade" id="modalReportPeminjaman" tabindex="-1" role="dialog"
        aria-labelledby="modalLabelPeminjaman" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelExport">Export Data ke PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('report.peminjaman') }}" method="GET">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="month">Periode Bulan</label>
                            <select class="form-control" id="month_peminjaman" name="month_peminjaman">
                                <option value="">--- Pilih Bulan ---</option>
                                @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m,
                                    1)) }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="year">Periode Tahun</label>
                            <select class="form-control" id="year_peminjaman" name="year_peminjaman">
                                <option value="">--- Pilih Tahun ---</option>
                                @for ($y = date('Y'); $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="allData_peminjaman" name="all_data_peminjaman" value="1">
                            <label class="form-check-label" for="allData_peminjaman">Export Semua Data</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
</body>

</html>
@endsection
@section(' footer')
@endsection
