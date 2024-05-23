<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Charge extends Model
{
    const ACTIVE = 1, INACTIVE = 2;
    const NORMAL = 1, MONTHLY = 2;
    use HasFactory, ApiTrait;
    protected $guarded = ['id', 'created_at', "updated_at"];

    protected $allowIncluded = ['payments'];
    protected $allowFilter = ["chargeable_type", "chargeable_id", "description", "date", "type", "status"];
    protected $allowSort = ["chargeable_type", "chargeable_id", "description", "date", "type", "status"];

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }
}
