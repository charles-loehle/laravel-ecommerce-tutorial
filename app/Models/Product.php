<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'additional_info',
        'category_id',
        'subcategory_id'
    ];

    public function category() {
     // SELECT * FROM categories WHERE categories.id = products.category_id;
     // SELECT categories.id, categories.name, products.category_id, products.name FROM categories INNER JOIN products ON categories.id = products.category_id;
     // categories.id = products.category_id;
      return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
