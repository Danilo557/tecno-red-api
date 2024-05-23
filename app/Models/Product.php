<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Product extends Model
{
    use HasFactory,ApiTrait;
    
    protected $allowIncluded = ["brand","invoices"];
    protected $allowFilter = [];
    protected $allowSort = [];

    protected $guarded = ['id', 'created_at',"updated_at"];

    

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class)->withPivot('quantity', "amount");
    }
}
