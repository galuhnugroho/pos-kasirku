@extends('layouts.app')

@section('title', 'Struk Pembayaran')

@section('content')
    <div class="page-heading">
        <h3>Struk Pembayaran</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">

                    {{-- Header Struk --}}
                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-0">TOKO SAYA</h4>
                        <p class="text-muted small mb-0">Jl. Contoh No. 123</p>
                        <p class="text-muted small mb-0">Telp: 08123456789</p>
                        <hr>
                        <p class="small mb-0">No. Invoice: <strong>{{ $transaction->invoice_number }}</strong></p>
                        <p class="small mb-0">Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        <p class="small mb-0">Kasir: {{ $transaction->user->name }}</p>
                    </div>

                    <hr>

                    {{-- Daftar Item --}}
                    <table class="table table-sm table-borderless">
                        <tbody>
                            @foreach ($transaction->transactionItems as $item)
                                <tr>
                                    <td>
                                        <p class="mb-0 small fw-bold">{{ $item->product_name }}</p>
                                        <small class="text-muted">
                                            {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </small>
                                    </td>
                                    <td class="text-end small fw-bold">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>

                    {{-- Rincian Pembayaran --}}
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted small">Subtotal</td>
                            <td class="text-end small">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if ($transaction->discount > 0)
                            <tr>
                                <td class="text-muted small">Diskon</td>
                                <td class="text-end small text-danger">
                                    - Rp {{ number_format($transaction->discount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-muted small">PPN ({{ $transaction->ppn_percent }}%)</td>
                            <td class="text-end small">Rp {{ number_format($transaction->ppn_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold">Total</td>
                            <td class="text-end fw-bold text-primary">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted small">Bayar</td>
                            <td class="text-end small">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kembalian</td>
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Footer --}}
                    <div class="text-center">
                        <p class="small text-muted mb-0">Terima kasih telah berbelanja!</p>
                        <p class="small text-muted">Barang yang sudah dibeli tidak dapat dikembalikan.</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('kasir.pos') }}" class="btn btn-primary flex-fill">
                            <i class="bi bi-plus-circle me-1"></i> Transaksi Baru
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary flex-fill">
                            <i class="bi bi-printer me-1"></i> Print Struk
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        @media print {

            /* Sembunyikan elemen yang tidak perlu saat print */
            .sidebar,
            .navbar,
            .page-heading,
            .btn,
            header,
            footer {
                display: none !important;
            }

            #sidebar {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
@endpush
