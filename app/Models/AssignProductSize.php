<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_id',
        'status',
    ];

    public function sizeName(){
        return $this->hasOne(ProductSize::class,'id','size_id');
    }
    
}
