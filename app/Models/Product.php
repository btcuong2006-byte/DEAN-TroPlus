<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'address',
        'city',
        'acreage',
        'description',
        'photo',
        'status',
        'favorite_count',
        'lat',
        'lng', // ✅ thêm
    ];
    /**
     * Người đăng phòng
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Danh mục phòng
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Bình luận
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Người yêu thích phòng
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * Đánh giá người thuê
     */
    public function tenantReviews()
    {
        return $this->hasMany(TenantReview::class);
    }
}
