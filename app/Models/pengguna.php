<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'foto',
        'last_payment_method',
    ];

    protected $appends = ['foto_url', 'foto_full_url'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor untuk URL foto
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Accessor untuk URL penuh foto
     */
    public function getFotoFullUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Boot method untuk hapus foto saat pengguna dihapus
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pengguna) {
            if ($pengguna->foto && Storage::exists('public/' . $pengguna->foto)) {
                Storage::delete('public/' . $pengguna->foto);
            }
        });
    }

    /**
     * Scope untuk filter berdasarkan jenis kelamin
     */
    public function scopeByJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    /**
     * Scope pencarian nama / no hp
     */
    public function scopeSearchByNama($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama', 'like', '%' . $keyword . '%')
              ->orWhere('no_hp', 'like', '%' . $keyword . '%')
              ->orWhere('alamat', 'like', '%' . $keyword . '%');
        });
    }
}
