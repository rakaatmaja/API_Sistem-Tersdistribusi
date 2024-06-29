<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{
    use HasFactory;
    protected $table = 'komens';
    protected $primaryKey = 'id_komen';
    public $timestamps = true;

    protected $fillable = [
        'komen', 
        'id', 
        'id_konten', 
        'timestamp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function konten()
    {
        return $this->belongsTo(Konten::class, 'id_konten');
    }
}
