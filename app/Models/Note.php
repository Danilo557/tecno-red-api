<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Note extends Model
{
    use HasFactory,ApiTrait;
    protected $allowIncluded = [];
    protected $allowFilter = [];
    protected $allowSort = [];
    protected $guarded = ['id', 'created_at',"updated_at"];


    public function noteable()
    {
        return $this->morphTo();
    }


}
