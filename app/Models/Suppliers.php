<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'suppliers';

    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_id',
        'company_name',
        'contact_name',
        'contact_title',
        'address',
        'city',
        'region',
        'postal_code',
        'country',
        'phone',
        'fax',
        'homepage',
    ];
}
