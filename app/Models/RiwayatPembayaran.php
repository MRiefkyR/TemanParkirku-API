<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembayaran';

    protected $fillable = [
        'user_id', 'tanggal', 'nominal', 'status', 'metode','order_id'
    ];
    
    public function riwayatPembayaran()
    {
        return $this->hasMany(RiwayatPembayaran::class);
    }
      public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
