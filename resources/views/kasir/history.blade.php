    @extends('layouts.app')
    @section('title', 'Riwayat')

    @section('content')
        <div class="page-heading">
            <h3>Riwayat Transaksi</h3>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>N0. INVOICE</th>
                                <th>TANGGAL</th>
                                <th>TOTAL BARANG</th>
                                <th>TOTAL PEMBAYARAN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="text-bold-500">{{ $loop->iteration }}</td>
                                    <td class="text-bold-500">{{ $transaction->invoice_number }}</td>
                                    <td class="text-bold-500">
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-bold-500">
                                        {{ $transaction->transactionItems->sum('quantity') }}
                                    </td>
                                    <td class="text-bold-500">
                                        Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Show</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
        </div>
    @endsection

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $('#table1').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });
        </script>
    @endpush
