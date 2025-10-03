@extends('master')
@section('title', 'Dashboard Admin - ')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <!-- Jumlah User -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Jumlah User</h4>
                                </div>
                                <div class="card-body">
                                    {{ $userCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>

                <div class="row">
                    <!-- Produk Terbaru -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Produk Terbaru</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                        <li class="media">
                                                <img class="mr-3 rounded" width="50"
                                                 src="default.png"
                                                 alt="produk">
                                            <div class="media-body">
                                                <div class="float-right text-primary">
                                                    tes
                                                </div>
                                                <div class="media-title">tes</div>
                                                <span class="text-small text-muted">Rp</span>
                                            </div>
                                        </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
