<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function pos()
    {
        $products = Product::where('stock', '>', 0)->get();
        $cart = session()->get('cart', []);
        return view('kasir.pos', compact('products', 'cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            // cek stok sebelum tambah qty
            if ($cart[$product->id]['quantity'] >= $product->stock) {
                return redirect()->route('kasir.pos')
                    ->with('error', 'Stok ' . $product->name . ' tidak mencukupi!');
            }

            $cart[$product->id]['quantity']++;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['price'] * $cart[$product->id]['quantity'];
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('kasir.pos');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            if ($request->action === 'increase') {
                $product = Product::find($productId);
                // cek stok sebelum tambah
                if ($cart[$productId]['quantity'] >= $product->stock) {
                    return redirect()->route('kasir.pos')
                        ->with('error', 'Stok ' . $product->name . ' tidak mencukupi!');
                }

                $cart[$productId]['quantity']++;
                $cart[$productId]['subtotal'] = $cart[$productId]['price'] * $cart[$productId]['quantity'];
            } else if ($request->action === 'decrease') {
                $cart[$productId]['quantity']--;
                $cart[$productId]['subtotal'] = $cart[$productId]['price'] * $cart[$productId]['quantity'];

                if ($cart[$productId]['quantity'] <= 0) {
                    unset($cart[$productId]);
                }
            }
        }

        session()->put('cart', $cart);
        return redirect()->route('kasir.pos');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        unset($cart[$productId]);
        session()->put('cart', $cart);
        return redirect()->route('kasir.pos');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('kasir.pos');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, &$transactionId) {
            $cart = session()->get('cart', []);
            $subtotal = collect($cart)->sum('subtotal');
            $diskon = $request->discount ?? 0;

            // 1. Hitung semua angka
            $afterDiskon  = $subtotal - $diskon;
            $ppnAmount    = $afterDiskon * 0.11;
            $totalPrice   = $afterDiskon + $ppnAmount; // afterDiskon + ppn
            $changeAmount = $request->paid_amount - $totalPrice; // paid_amount - totalPrice

            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(
                Transaction::whereDate('created_at', today())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            // 3. Simpan transaksi
            $transaction = Transaction::create([
                'user_id'        => Auth::id(),
                'invoice_number' => $invoiceNumber,
                'subtotal'       => $subtotal,
                'discount'       => $diskon,
                'ppn_percent'    => 11,
                'ppn_amount'     => $ppnAmount,
                'total_price'    => $totalPrice,
                'paid_amount'    => $request->paid_amount,
                'change_amount'  => $changeAmount,
            ]);

            foreach ($cart as $item) {
                $transaction->transactionItems()->create([
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $item['subtotal'],
                ]);
                Product::find($item['product_id'])->decrement('stock', $item['quantity']);
            }

            session()->forget('cart');
            $transactionId = $transaction->id; // ← simpan id sebelum keluar closure
        });

        return redirect()->route('kasir.receipt', $transactionId);
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load('transactionItems', 'user');
        return view('kasir.receipt', compact('transaction'));
    }

    public function history()
    {
        $transactions = Transaction::where('user_id',  Auth::id())->with('transactionItems')->latest()->get();

        return view('kasir.history', compact('transactions'));
    }
}
