<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;


class Client extends Model
{
    const ACTIVE = 1, INACTIVE = 2;
    use HasFactory, ApiTrait;
    
    protected $guarded = ['id', 'created_at',"updated_at"];

    protected $allowIncluded = ["statements","statements.payments","statements.charges"];
    protected $allowFilter = ["status","pay_day"];
    protected $allowSort = ["pay_day"];

    public function statements()
    {
        return $this->hasMany(Statement::class);
    }
}
