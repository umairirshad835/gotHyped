<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'actual_price',
        'market_price',
        'auction_price',
        'auction_time',
        'description',
        'image1',
        'image2',
        'image3',
        'status',
        'auction_status',
        'checkout_status',
    ];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function sizes(){
        return $this->hasMany(AssignProductSize::class,'product_id','id');
    }

    public function productWin(){
        return $this->belongsTo(Winner::class,'product_id','id');
    }

    // public function favoriteProduct(){
    //     return $this->belongsTo(FavoriteItem::class,'product_id','id');
    // }

    public function productAlert(){
        return $this->belongsTo(NotifyAlert::class,'product_id','id');
    }

    public function AuctionStart(){
        return $this->hasMany(AuctionStart::class,'auction_id','id');
    }

    public function winner(){
        return $this->hasMany(Winner::class,'product_id','id');
    }

    public function auctionBidUsed(){
        return $this->belongsTo(AuctionBidUsed::class,'auction_id','id');
    }

    public function favorite(){
        return $this->hasOne(FavoriteItem::class,'product_id','id');
    } 

    public function alert(){
        return $this->hasOne(NotifyAlert::class,'product_id','id');
    }
}
