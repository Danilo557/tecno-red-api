<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Statement extends Model
{
    const ACTIVE = 1, INACTIVE = 2;
    const MONTHLY = 1, DAILY = 2;
    use HasFactory, ApiTrait;

    protected $guarded = ['id', 'created_at', "updated_at"];

    protected $allowIncluded = [
         
        "payments", "client", "client.statements","charges",
        "client.statements.charges", 
        "client.statements.payments", 
    ];

    protected $allowFilter = [];
    protected $allowSort = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }


    public function charges()
    {
        return $this->morphMany(Charge::class, 'chargeable');
    }
}
