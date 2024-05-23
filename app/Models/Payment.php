<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Payment extends Model
{
    const ACTIVE = 1, INACTIVE = 2;
    use HasFactory, ApiTrait;

    protected $allowIncluded = ["note"];
    protected $allowFilter = ['paymentable_type', 'date', "status"];
    protected $allowSort = ['paymentable_type', 'date', "status"];

    protected $guarded = ['id', 'created_at', "updated_at"];

    
}
