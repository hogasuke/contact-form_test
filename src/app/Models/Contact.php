<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail'
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('first_name', 'like', '%' . $keyword . '%')
                ->orWhere('last_name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

    public function scopeGenderSearch($query, $gender)
    {
        if ($gender === null || $gender === '') {
            return $query;
        }
        return $query->where('gender', $gender);
    }

    public function scopeCategorySearch($query, $category_id)
    {
        if ($category_id === null || $category_id === '') {
            return $query;
        }
        return $query->where('category_id', $category_id);
    }
}