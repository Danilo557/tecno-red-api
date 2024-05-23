<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Brand extends Model
{
    use HasFactory,ApiTrait;
    protected $guarded = ['id', 'created_at',"updated_at"];

    protected $allowIncluded = ['products'];
    protected $allowFilter = [];
    protected $allowSort = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
