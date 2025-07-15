<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Penjaga extends Model
{
    use HasFactory;
    protected $table = 'penjaga';

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'alamat',
        'nama',
        'no_hp',
        'foto',
    ];

    protected $appends = ['foto_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor untuk mendapatkan URL foto
     */

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto); // <-- pastikan ini pakai asset() bukan Storage::url()
        }
        return asset('images/default-avatar.png'); // fallback image
    }
    /**
     * Accessor untuk mendapatkan foto dengan URL penuh
     */
    public function getFotoFullUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png'); // default image
    }

    /**
     * Boot method untuk handle delete
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($penjaga) {
            // Hapus foto saat model dihapus
            if ($penjaga->foto && Storage::exists('public/' . $penjaga->foto)) {
                Storage::delete('public/' . $penjaga->foto);
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
     * Scope untuk pencarian nama
     */
    public function scopeSearchByNama($query, $nama)
    {
        return $query->where('nama', 'like', '%' . $nama . '%');
    }
}