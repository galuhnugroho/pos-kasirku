@extends('layouts.app')

@section('title', 'POS')

@section('content')
    <div class="page-heading">
        <h3>Point of Sale</h3>
    </div>

    {{-- Alert stok tidak mencukupi --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- ==================== KOLOM KIRI: DAFTAR PRODUK ==================== --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Produk</h4>
                    {{-- Search produk --}}
                    <input type="text" id="searchProduct" class="form-control mt-2" placeholder="Cari produk...">
                </div>
                <div class="card-body">
                    {{-- Filter kategori --}}
                    <div class="mb-3 d-flex flex-wrap gap-2" id="categoryFilter">
                        <button class="btn btn-sm btn-primary category-btn active" data-category="all">
                            Semua
                        </button>
                        {{-- Kategori akan di-generate dari produk yang ada --}}
                        @php
                            $categories = $products->pluck('category')->unique('id')->filter();
                        @endphp
                        @foreach ($categories as $category)
                            <button class="btn btn-sm btn-outline-primary category-btn" data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Grid produk --}}
                    <div class="row g-3" id="productGrid">
                        @forelse ($products as $product)
                            <div class="col-6 col-lg-4 product-item" data-name="{{ strtolower($product->name) }}"
                                data-category="{{ $product->category_id }}">
                                <div class="card h-100 product-card border" style="cursor: pointer; transition: all 0.2s;"
                                    onclick="addToCartDirect({{ $product->id }})">
                                    {{-- Gambar produk --}}
                                    @if ($product->image)
                                        <img src="{{ Storage::url($product->image) }}" class="card-img-top"
                                            style="height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="height: 120px;">
                                            <i class="bi bi-box-seam fs-2 text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body p-2">
                                        <p class="card-title fw-bold mb-1 small">{{ $product->name }}</p>
                                        <p class="text-primary fw-bold mb-1 small">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-muted mb-0" style="font-size: 11px;">
                                            Stok: {{ $product->stock }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted text-center">Tidak ada produk tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== KOLOM KANAN: KERANJANG ==================== --}}
        <div class="col-md-4">
            <div class="card" style="position: sticky; top: 20px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Keranjang</h4>
                    @if (count($cart) > 0)
                        <form action="{{ route('kasir.cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Kosongkan keranjang?')">
                                <i class="bi bi-trash"></i> Kosongkan
                            </button>
                        </form>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if (count($cart) > 0)
                        <div style="max-height: 350px; overflow-y: auto;">
                            <table class="table table-sm mb-0">
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach ($cart as $item)
                                        @php $total += $item['subtotal'] @endphp
                                        <tr>
                                            <td class="ps-3">
                                                <p class="mb-0 fw-bold small">{{ $item['name'] }}</p>
                                                <small class="text-muted">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                </small>
                                            </td>
                                            <td class="text-center" style="width: 120px; white-space: nowrap;">
                                                {{-- Tombol kurangi qty --}}
                                                <form action="{{ route('kasir.cart.update') }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $item['product_id'] }}">
                                                    <input type="hidden" name="action" value="decrease">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-secondary px-1 py-0">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                </form>
                                                <span class="mx-1 fw-bold">{{ $item['quantity'] }}</span>
                                                {{-- Tombol tambah qty --}}
                                                <form action="{{ route('kasir.cart.update') }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $item['product_id'] }}">
                                                    <input type="hidden" name="action" value="increase">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-secondary px-1 py-0">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-end pe-2">
                                                <small class="fw-bold">
                                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                </small>
                                            </td>
                                            <td style="width: 30px;">
                                                {{-- Tombol hapus item --}}
                                                <form action="{{ route('kasir.cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $item['product_id'] }}">
                                                    <button type="submit" class="btn btn-sm text-danger p-0">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Ringkasan & Tombol Checkout --}}
                        <div class="p-3 border-top">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Subtotal</span>
                                <span class="fw-bold small">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Total Sementara</span>
                                <span class="fw-bold text-primary">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#checkoutModal">
                                <i class="bi bi-cash-coin me-1"></i> Checkout
                            </button>
                        </div>
                    @else
                        {{-- Keranjang kosong --}}
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Keranjang masih kosong</p>
                            <small class="text-muted">Klik produk untuk menambahkan</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Form hidden untuk addToCart via JS --}}
    <form id="addToCartForm" action="{{ route('kasir.cart.add') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="product_id" id="addProductId">
    </form>
@endsection

@push('scripts')
    <script>
        // Tambah ke keranjang via klik card
        function addToCartDirect(productId) {
            document.getElementById('addProductId').value = productId;
            document.getElementById('addToCartForm').submit();
        }

        // Search produk
        document.getElementById('searchProduct').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(function(item) {
                const name = item.getAttribute('data-name');
                item.style.display = name.includes(query) ? '' : 'none';
            });
        });

        // Filter kategori
        document.querySelectorAll('.category-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('active', 'btn-primary');
                    b.classList.add('btn-outline-primary');
                });
                this.classList.add('active', 'btn-primary');
                this.classList.remove('btn-outline-primary');

                const category = this.getAttribute('data-category');
                document.querySelectorAll('.product-item').forEach(function(item) {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // ==================== MODAL CHECKOUT JS ====================
        const subtotalEl = document.getElementById('modalSubtotal');
        const inputDiskon = document.getElementById('inputDiskon');
        const inputBayar = document.getElementById('inputBayar');

        if (subtotalEl && inputDiskon && inputBayar) {
            const PPN_RATE = 0.11;
            const subtotal = parseFloat(subtotalEl.getAttribute('data-value')) || 0;

            function formatRupiah(angka) {
                return 'Rp ' + Math.floor(angka).toLocaleString('id-ID');
            }

            function hitungTotal() {
                const diskon = parseFloat(inputDiskon.value) || 0;
                const afterDiskon = Math.max(subtotal - diskon, 0);
                const ppn = afterDiskon * PPN_RATE;
                const total = afterDiskon + ppn;

                document.getElementById('modalDiskonDisplay').textContent = '- ' + formatRupiah(diskon);
                document.getElementById('modalAfterDiskon').textContent = formatRupiah(afterDiskon);
                document.getElementById('modalPPN').textContent = formatRupiah(ppn);
                document.getElementById('modalTotal').textContent = formatRupiah(total);

                // hitung kembalian
                hitungKembalian(total);
                return total;
            }

            function hitungKembalian(total) {
                const bayar = parseFloat(inputBayar.value) || 0;
                const kembalian = bayar - total;

                const kembalianEl = document.getElementById('modalKembalian');
                const btnProses = document.getElementById('btnProses');

                if (bayar <= 0) {
                    kembalianEl.textContent = 'Rp 0';
                    kembalianEl.classList.remove('text-danger');
                    kembalianEl.classList.add('text-success');
                    btnProses.disabled = true;
                } else if (kembalian < 0) {
                    kembalianEl.textContent = 'Uang kurang ' + formatRupiah(Math.abs(kembalian));
                    kembalianEl.classList.add('text-danger');
                    kembalianEl.classList.remove('text-success');
                    btnProses.disabled = true;
                } else {
                    kembalianEl.textContent = formatRupiah(kembalian);
                    kembalianEl.classList.remove('text-danger');
                    kembalianEl.classList.add('text-success');
                    btnProses.disabled = false;
                }
            }

            // Event listeners
            inputDiskon.addEventListener('input', hitungTotal);
            inputBayar.addEventListener('input', function() {
                const total = hitungTotal();
            });

            // Reset modal saat dibuka
            document.getElementById('checkoutModal').addEventListener('show.bs.modal', function() {
                inputDiskon.value = 0;
                inputBayar.value = '';
                hitungTotal();
            });
        }
    </script>
@endpush

{{-- ==================== MODAL CHECKOUT ==================== --}}
@if (count($cart) > 0)
    @php
        $subtotal = collect($cart)->sum('subtotal');
    @endphp
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-cash-coin me-2"></i> Proses Pembayaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kasir.checkout') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- Ringkasan --}}
                        <div class="bg-light rounded p-3 mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Subtotal</span>
                                <span id="modalSubtotal" data-value="{{ $subtotal }}">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Diskon</span>
                                <span id="modalDiskonDisplay" class="text-danger">- Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Setelah Diskon</span>
                                <span id="modalAfterDiskon">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">PPN (11%)</span>
                                <span id="modalPPN">Rp {{ number_format($subtotal * 0.11, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold fs-6">Total Bayar</span>
                                <span id="modalTotal" class="fw-bold fs-6 text-primary">
                                    Rp {{ number_format($subtotal + $subtotal * 0.11, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Input Diskon --}}
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Diskon (Rp)</label>
                            <input type="number" name="discount" id="inputDiskon" class="form-control"
                                placeholder="0" value="0" min="0">
                            <small class="text-muted">Isi 0 jika tidak ada diskon</small>
                        </div>

                        {{-- Input Jumlah Bayar --}}
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Jumlah Bayar (Rp)</label>
                            <input type="number" name="paid_amount" id="inputBayar" class="form-control"
                                placeholder="Masukkan jumlah uang pembeli" required min="0">
                        </div>

                        {{-- Kembalian --}}
                        <div class="bg-light rounded p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">Kembalian</span>
                                <span id="modalKembalian" class="fw-bold fs-5 text-success">Rp 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnProses" class="btn btn-primary" disabled>
                            <i class="bi bi-check-circle me-1"></i> Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
