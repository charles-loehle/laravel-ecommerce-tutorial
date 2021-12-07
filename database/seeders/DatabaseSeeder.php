<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Category::create([
          'name' => 'laptop',
          'slug' => 'laptop',
          'description' => 'laptop category',
          'image' => 'files/photo1.jpg'
        ]);

        Category::create([
            'name' => 'mobile phone',
            'slug' => 'mobile-phone',
            'description' => 'mobile phone category',
            'image' => 'files/photo1.jpg'
        ]);

        Category::create([
            'name' => 'books',
            'slug' => 'books',
            'description' => 'books category',
            'image' => 'files/books.jpg'
        ]);

        Subcategory::create([
            'name' => 'dell',
            'category_id' => 1
          ]);
        
        Subcategory::create([
        'name' => 'hp',
        'category_id' => 1
        ]);
    
        Subcategory::create([
            'name' => 'lenovo',
            'category_id' => 1
        ]);
       
        Product::create([
            'name' => 'HP Laptops',
            'image' => 'files/hp-laptop-grey.jpeg',
            'price' => rand(700, 1000),
            'description' => 'this is a description of hp laptop',
            'additional_info' => 'This is additional info',
            'category_id' => 1,
            'subcategory_id' => 1
        ]);

        Product::create([
            'name' => 'Dell Laptops',
            'image' => 'files/dell-laptop.jpeg',
            'price' => rand(700, 1000),
            'description' => 'this is a description of a dell laptop',
            'additional_info' => 'This is additional info',
            'category_id' => 1,
            'subcategory_id' => 1
        ]);

        Product::create([
            'name' => 'Lenovo Laptops',
            'image' => 'files/lenovo-laptop.jpeg',
            'price' => rand(700, 1000),
            'description' => 'this is a description of a lenovo laptop',
            'additional_info' => 'This is additional info',
            'category_id' => 1,
            'subcategory_id' => 2
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail',
            'password' => bcrypt('password'),
            'email_verified_at' => NOW(),
            'address' => 'USA',
            'phone_number' => '1112223333',
            'is_admin' => 1
        ]);
    }
}
