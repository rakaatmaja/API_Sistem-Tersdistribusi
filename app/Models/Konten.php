<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_konten';

    protected $fillable = [
        'title', 
        'deskripsi', 
        'kategori_konten', 
        'gambar_konten'
    ];
}
