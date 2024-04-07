<?php

namespace App\Models\Keller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_field',
        'fk_form_id',
        'jerarquia',
        'id_input',
        'name',
        'title',
        'type',
        'class',
        'icon',
    ];
}
