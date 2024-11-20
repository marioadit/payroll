<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perusahaan extends Model
{
    protected $table = 'perusahaan';
    protected $primarykey = 'id_perusahaan';

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
    ];}
