<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        //eliminar directorios se eliminan sus archvios
        Storage::deleteDirectory('posts');

        //eliminar y crear la carpeta
        Storage::makeDirectory('posts');



        User::factory()->create([
            'name' => 'gonza',
            'email' => 'gonza@example.com',
            'password'=>bcrypt('12345678')
        ]);

        Category::factory(10)->create();
        Post::factory(100)->create();



    }
}
