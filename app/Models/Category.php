<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected $guarded = [];

    public function statusBadge()
    {
        return $this->status == 1 ? '<span class="badge badge-pill badge-status bg-success">Active</span>' : '<span class="badge badge-pill badge-status bg-danger">Inactive</span>';
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id','id');
    }
}
