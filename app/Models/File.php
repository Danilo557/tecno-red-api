<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class File extends Model
{
    use HasFactory,ApiTrait;
    protected $allowIncluded = [];
    protected $allowFilter = [];
    protected $allowSort = [];

    const IMAGE=1;
    const FILE=2;


    protected $guarded = ['id', 'created_at',"updated_at"];
}
