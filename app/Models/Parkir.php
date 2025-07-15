<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    use HasFactory;

    protected $table = 'parkir';

    protected $fillable = [
        'no_plat',
        'jam_masuk',
        'jenis_kendaraan',
        'tarif',
        'order_id',
        'status',
        'snap_token'
    ];
    
    public static function totalHariIni()
    {
        return self::whereDate('created_at', Carbon::today())->count();
    }

    // ✅ Total parkir aktif (belum bayar) hari ini
    public static function aktifHariIni()
    {
        return self::whereDate('created_at', Carbon::today())
                   ->where('status', 'belum_bayar')
                   ->count();
    }
}
