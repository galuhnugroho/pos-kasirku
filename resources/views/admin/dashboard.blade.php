@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon purple">
                                <i class="iconly-boldShow"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Total Penjualan Hari Ini</h6>
                            <h6 class="font-extrabold mb-0">Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon blue">
                                <i class="iconly-boldProfile"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Total Transaksi Hari Ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $totalTransactionHariIni }} Transaksi</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon green">
                                <i class="iconly-boldAdd-User"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Produk Hampir Habis</h6>
                            <h6 class="font-extrabold mb-0">{{ $produkHampirHabis }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon red">
                                <i class="iconly-boldUser"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Kasir Aktif</h6>
                            <h6 class="font-extrabold mb-0">{{ $totalKasirAktif }} Kasir</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        {{-- Grafik penjualan 7 hari --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Penjualan 7 Hari Terakhir</h4>
                </div>
                <div class="card-body">
                    <canvas id="chartPenjualan"></canvas>
                </div>
            </div>
        </div>

        {{-- Produk terlaris --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">5 Produk Terlaris</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-end">Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produkTerlaris as $produk)
                                <tr>
                                    <td>{{ $produk->product_name }}</td>
                                    <td class="text-end">{{ $produk->total_terjual }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($penjualan7Hari->pluck('tanggal'));
        const data = @json($penjualan7Hari->pluck('total'));

        new Chart(document.getElementById('chartPenjualan'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan',
                    data: data,
                    borderColor: '#435ebe',
                    backgroundColor: 'rgba(67, 94, 190, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
