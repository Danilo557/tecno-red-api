<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Invoice extends Model
{
    const ACTIVE = 1, INACTIVE = 2;
    use HasFactory, ApiTrait;

    protected $allowIncluded = ["store", "products","products.brand", "charges","files"];
    protected $allowFilter = ['folio', 'date'];
    protected $allowSort = ['folio', 'date'];

    protected $guarded = ['id', 'created_at', "updated_at"];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', "amount");
    }
    public function charges()
    {
        return $this->morphMany(Charge::class, 'chargeable');
    }

    public function files()
    {
        return $this->morphMany(File::class,'fileable');
    }

    
}
