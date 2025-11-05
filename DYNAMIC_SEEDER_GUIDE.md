# Dynamic Article Seeder Guide

## Overview
ArticleSeeder sekarang menggunakan **Faker** untuk menggenerate artikel secara dinamis tanpa data dummy yang hardcoded. Setiap kali seeder dijalankan, akan menghasilkan artikel yang berbeda-beda.

## Features

### 🎯 **Dynamic Content Generation**
- **Title**: Menggunakan template yang bervariasi dengan teknologi random
- **Categories**: Kombinasi 2-4 kategori dari 30+ kategori tersedia
- **Content**: Paragraf realistis dengan struktur artikel yang proper
- **Excerpt**: Summary singkat dari artikel
- **Slug**: Auto-generated dan dijamin unique

### 📊 **Smart Status Distribution**
- **70%** artikel berstatus `published`
- **20%** artikel berstatus `draft`
- **10%** artikel berstatus `archived`

### 📅 **Intelligent Date Handling**
- **Published articles**: Random date dalam 30 hari terakhir
- **Archived articles**: Random date 30-60 hari yang lalu
- **Draft articles**: 30% chance punya scheduled publish date

### 🏷️ **Available Categories**
```
Laravel, PHP, JavaScript, Vue.js, React, Node.js,
Database, MySQL, PostgreSQL, MongoDB,
Frontend, Backend, Full Stack,
API, REST, GraphQL,
DevOps, Docker, Kubernetes,
Web Development, Mobile Development,
Design Patterns, Architecture,
Performance, Security, Testing,
CSS, HTML, TypeScript,
Python, Java, C#,
Microservices, Cloud Computing, AWS
```

### 📝 **Title Templates**
```
- Getting Started with %s
- Advanced %s Techniques
- Best Practices for %s Development
- Complete Guide to %s
- Mastering %s in 2024
- %s Tips and Tricks
- Building Modern Applications with %s
- Understanding %s Architecture
- %s Performance Optimization
- Introduction to %s for Beginners
```

## Configuration

### Mengubah Jumlah Artikel
Edit variabel `$articleCount` di dalam method `run()`:
```php
// Generate jumlah artikel (default 15, bisa diubah)
$articleCount = 25; // Ubah sesuai kebutuhan
```

### Menambah Kategori Baru
Tambahkan ke array `$availableCategories`:
```php
$availableCategories = [
    // ... existing categories
    'New Category',
    'Another Category'
];
```

### Mengubah Template Title
Tambahkan template baru ke array `$titleTemplates`:
```php
$titleTemplates = [
    // ... existing templates
    'Deep Dive into %s',
    'Modern %s Development'
];
```

### Mengubah Distribusi Status
Edit array `$statusWeights`:
```php
$statusWeights = [
    'published' => 80,  // 80% published
    'draft' => 15,      // 15% draft
    'archived' => 5     // 5% archived
];
```

## Usage

### Jalankan Seeder
```bash
# Jalankan hanya ArticleSeeder
php artisan db:seed --class=ArticleSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

### Reset dan Seed Ulang
```bash
# Reset database dan jalankan semua seeder
php artisan migrate:fresh --seed
```

## Sample Output
Ketika seeder dijalankan, akan menghasilkan output seperti:
```
Generating 15 dynamic articles...
Created article 1: Advanced Laravel Techniques
Created article 2: Getting Started with React
Created article 3: Building Modern Applications with Docker
...
Successfully created 15 dynamic articles!
```

## Content Structure
Setiap artikel yang dihasilkan memiliki struktur:

1. **Introduction paragraph** - Memperkenalkan topik
2. **Main content** (3-6 paragraphs) - Konten utama artikel
3. **Technical paragraph** - Referensi teknis dan best practices
4. **Conclusion paragraph** - Kesimpulan dan ringkasan

## Benefits

### ✅ **Advantages**
- **No hardcoded data** - Setiap run menghasilkan data berbeda
- **Realistic content** - Struktur artikel yang proper
- **Flexible configuration** - Mudah disesuaikan
- **Unique slugs** - Tidak ada duplikasi
- **Proper relationships** - Semua artikel ditulis oleh admin

### 🎯 **Use Cases**
- **Development testing** - Data realistis untuk testing
- **Demo purposes** - Konten yang bervariasi untuk demo
- **Performance testing** - Generate banyak artikel untuk load testing
- **UI/UX testing** - Berbagai panjang konten untuk testing layout

## Customization Examples

### Generate Artikel Spesifik Teknologi
```php
// Fokus pada Laravel saja
$technology = 'Laravel';
$title = sprintf($template, $technology);
```

### Generate Artikel dengan Tanggal Spesifik
```php
// Semua artikel published hari ini
$publishedAt = now();
```

### Generate Artikel dengan Kategori Spesifik
```php
// Hanya kategori web development
$selectedCategories = ['Web Development', 'Frontend', 'Backend'];
```

## Notes
- Seeder memerlukan admin user yang sudah ada
- Faker library sudah included dalam Laravel
- Slug otomatis dibuat unique dengan counter jika diperlukan
- Content di-generate dalam bahasa Inggris (bisa dikustomisasi untuk bahasa lain)