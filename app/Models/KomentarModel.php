<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarModel extends Model
{
    protected $table = 'komentar', $guarded = [];

    public function tamu()
    {
        return $this->hasOne(TamuModel::class, 'kode_tamu', 'kode_tamu');
    }
}
