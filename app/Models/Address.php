<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'cep', 'logradouro', 'bairro', 'cidade', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
