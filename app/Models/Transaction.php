<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'invoice_number', 'subtotal', 'discount', 'ppn_percent', 'ppn_amount', 'total_price', 'paid_amount', 'change_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
