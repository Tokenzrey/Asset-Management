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
                        <a href="{{ route('report.aset') }}" class="small-box bg-white rounded">
                        <div class="inner">
                            <h3 class="text-white"></h3>
                            <p class="text-primary"><b>Report <br> Aset</b></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-briefcase" aria-hidden="true"></i>
                        </div>
                        <div class="small-box bg-primary text-white text-center">Print <i
                                class="fa fa-arrow-circle-right"></i></div>
                        </a>    
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div>
                        <a href="{{ route('report.peminjaman') }}" class="small-box bg-white rounded">
                        <div class="inner">
                            <h3 class="text-white"></h3>
                            <p class="text-primary"><b>Report <br> Peminjaman Aset</b></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-th-list"></i>
                        </div>
                        <div class="small-box bg-primary text-white text-center">Print <i
                                class="fa fa-arrow-circle-right"></i></div>
                        </a>
                    </div>
                {{--</div>
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
        <!-- ./wrapper -->
    </body>

    </html>
@endsection
@section(' footer')
@endsection
