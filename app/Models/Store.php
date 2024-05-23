<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Store extends Model
{
    use HasFactory,ApiTrait;
    
    protected $allowIncluded = ['invoices',"invoices.products"];
    protected $allowFilter = [];
    protected $allowSort = [];

    protected $guarded = ['id', 'created_at',"updated_at"];
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
