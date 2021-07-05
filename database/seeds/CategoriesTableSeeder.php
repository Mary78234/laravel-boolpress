<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   //1 creo set di dati 
        $data = ['HTML', 'CSS', 'JavaScript', 'PHP'];

        //2 li carico nel model Category con un ciclo
        foreach ($data as $value) {
            $new_cat = new Category();
            $new_cat->name = $value;
            $new_cat->slug = Str::slug($value, '-');
            $new_cat->save();
        }
    }
}
