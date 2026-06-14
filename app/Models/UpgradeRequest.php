<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpgradeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'identity_number',
        'identity_date',
        'identity_place',
        'phone',
        'business_license',
        'property_name',
        'property_price',
        'property_acreage',
        'property_city',
        'property_address',
        'property_description',
        'property_photo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
