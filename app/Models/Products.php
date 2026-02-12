<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'category_id',
        'supplier_id',
        'unit_price',
        'quantity_per_unit',
        'units_in_stock',
        'units_on_order',
        'reorder_level',
        'discontinued',
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }
}
