<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'user_id',
        'tanggal_transaksi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'transaction_service', 'transaction_id', 'service_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public static function createFromCart($data)
    {
        $transaction = new Transaction();

        $transaction->user_id = Auth::user()->id ?? 1;
        $transaction->tanggal_transaksi = now();
        $transaction->status = 'pending';

        $transaction->save();

        return $transaction;
    }

    public static function calculateTotal($data)
    {
        $total = 0;

        foreach ($data as $item) {
            $price = Service::find($item['id'])->price;
            $total += $price * $item['quantity'];
        }

        return $total;
    }
}