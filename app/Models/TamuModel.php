<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TamuModel extends Model
{
    protected $table = 'tamu', $guarded = [];

    public function uploader()
    {
        return $this->hasOne(User::class, 'id', 'uploaded_by');
    }
}
