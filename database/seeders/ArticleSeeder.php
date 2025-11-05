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

        $articles = [
            [
                'title' => 'Getting Started with Laravel 11',
                'categories' => 'Laravel,PHP,Web Development',
                'content' => 'Laravel 11 brings exciting new features and improvements to the popular PHP framework. In this comprehensive guide, we will explore the key features, installation process, and best practices for building modern web applications with Laravel 11.',
                'excerpt' => 'Learn about the new features and improvements in Laravel 11',
                'status' => 'published',
                'published_at' => now()->subDays(5)
            ],
            [
                'title' => 'Modern JavaScript ES2024 Features',
                'categories' => 'JavaScript,Frontend,Programming',
                'content' => 'JavaScript continues to evolve with new features that make development more efficient and enjoyable. ES2024 introduces several new methods and syntax improvements that every developer should know about.',
                'excerpt' => 'Explore the latest JavaScript features in ES2024',
                'status' => 'published',
                'published_at' => now()->subDays(3)
            ],
            [
                'title' => 'Building RESTful APIs with Laravel',
                'categories' => 'API,Laravel,Backend',
                'content' => 'RESTful APIs are the backbone of modern web applications. This tutorial covers how to build robust, scalable APIs using Laravel, including authentication, validation, and best practices.',
                'excerpt' => 'Complete guide to building RESTful APIs with Laravel',
                'status' => 'published',
                'published_at' => now()->subDays(7)
            ],
            [
                'title' => 'Vue.js 3 Composition API Deep Dive',
                'categories' => 'Vue.js,Frontend,JavaScript',
                'content' => 'The Composition API in Vue.js 3 provides a more flexible way to organize component logic. Learn how to leverage this powerful feature to build maintainable Vue applications.',
                'excerpt' => 'Master Vue.js 3 Composition API with practical examples',
                'status' => 'published',
                'published_at' => now()->subDays(2)
            ],
            [
                'title' => 'Database Optimization Techniques',
                'categories' => 'Database,MySQL,Performance',
                'content' => 'Database performance is crucial for web application success. This article covers indexing strategies, query optimization, and other techniques to improve database performance.',
                'excerpt' => 'Learn essential database optimization techniques',
                'status' => 'published',
                'published_at' => now()->subDays(10)
            ],
            [
                'title' => 'Introduction to Docker for Developers',
                'categories' => 'Docker,DevOps,Containerization',
                'content' => 'Docker has revolutionized how we deploy and manage applications. This beginner-friendly guide covers Docker basics, containerization concepts, and practical examples.',
                'excerpt' => 'Get started with Docker containerization',
                'status' => 'published',
                'published_at' => now()->subDays(1)
            ],
            [
                'title' => 'Advanced PHP Design Patterns',
                'categories' => 'PHP,Design Patterns,Architecture',
                'content' => 'Design patterns are proven solutions to common programming problems. Explore advanced PHP design patterns and learn when and how to implement them in your projects.',
                'excerpt' => 'Master advanced PHP design patterns',
                'status' => 'draft',
                'published_at' => now()->addDays(2)
            ],
            [
                'title' => 'React Hooks Best Practices',
                'categories' => 'React,JavaScript,Frontend',
                'content' => 'React Hooks have changed how we write React components. Learn the best practices, common pitfalls, and advanced techniques for using hooks effectively.',
                'excerpt' => 'Best practices for using React Hooks',
                'status' => 'published',
                'published_at' => now()->subDays(4)
            ],
            [
                'title' => 'Microservices Architecture with Laravel',
                'categories' => 'Microservices,Laravel,Architecture',
                'content' => 'Microservices architecture offers scalability and flexibility for large applications. Learn how to implement microservices using Laravel and related technologies.',
                'excerpt' => 'Build scalable microservices with Laravel',
                'status' => 'draft',
                'published_at' => now()->addDays(5)
            ],
            [
                'title' => 'CSS Grid vs Flexbox: When to Use What',
                'categories' => 'CSS,Frontend,Web Design',
                'content' => 'CSS Grid and Flexbox are powerful layout systems. Understanding when to use each one is crucial for creating efficient and maintainable layouts.',
                'excerpt' => 'Compare CSS Grid and Flexbox for better layouts',
                'status' => 'published',
                'published_at' => now()->subDays(6)
            ]
        ];

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