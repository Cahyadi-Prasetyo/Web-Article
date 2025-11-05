<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Articles;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada admin user terlebih dahulu
        $adminUser = User::where('role', 'admin')->first();
        
        if (!$adminUser) {
            $this->command->info('No admin user found. Please run UserSeeder first.');
            return;
        }

        foreach ($articles as $articleData) {
            // Generate slug from title
            $articleData['slug'] = Str::slug($articleData['title']);
            
            // Hanya admin yang bisa menjadi author
            $articleData['author_id'] = $adminUser->id;
            
            Articles::firstOrCreate(
                ['slug' => $articleData['slug']], 
                $articleData
            );
        }

        $this->command->info('Articles seeded successfully!');
    }
}
