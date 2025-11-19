# � Arbticle Management System

Platform manajemen artikel berbasis web dengan sistem role-based access control dan workflow approval. Dibangun menggunakan Laravel 12 dan Tailwind CSS, sistem ini memungkinkan user untuk membuat artikel yang harus melalui proses review admin sebelum dipublikasikan.

## 📖 Deskripsi Projek

**Article Management System** adalah aplikasi web full-stack yang dirancang untuk mengelola publikasi artikel dengan sistem persetujuan bertingkat. Sistem ini mengimplementasikan 3 level akses (Guest, User, Admin) dengan workflow yang jelas untuk memastikan kualitas konten sebelum dipublikasikan.

### Fitur Utama:
- 🔐 **Authentication & Authorization**: Sistem login dengan Laravel Sanctum (Bearer Token)
- 👥 **Role-Based Access Control**: 3 role dengan permission berbeda (Guest, User, Admin)
- ✍️ **Article CRUD**: User dapat membuat, edit, dan hapus artikel sendiri
- ✅ **Approval Workflow**: Artikel harus di-approve admin sebelum published
- 📊 **Status Management**: 5 status artikel (draft, pending, published, rejected, archived)
- 🌐 **RESTful API**: API endpoints lengkap dengan dokumentasi
- 📱 **Responsive Design**: UI modern dengan Tailwind CSS
- 🔒 **Security**: CSRF protection, password hashing, middleware protection

## ⚡ Quick Start

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup database
cp .env.example .env
php artisan key:generate
# Edit .env untuk database config

# 3. Migrate & seed
php artisan migrate:fresh
php artisan db:seed --class=AdminSeeder

# 4. Build & run
npm run build
php artisan serve
```

Buka: `http://localhost:8000`

## 🔑 Akun Default

| Role  | Email                | Password     |
|-------|---------------------|--------------|
| Admin | admin@example.com   | password123  |
| User  | user@example.com    | password123  |

## 📊 Fitur Utama

### Guest (Pengunjung)
- ✅ Lihat artikel published di homepage
- ✅ Baca detail artikel

### User (Penulis)
- ✅ Buat artikel (status: draft)
- ✅ Edit artikel sendiri (draft/rejected)
- ✅ Submit artikel untuk review (→ pending)
- ✅ Hapus artikel sendiri (draft/rejected)
- ❌ Tidak bisa publish sendiri

### Admin
- ✅ Lihat semua artikel
- ✅ Approve artikel (pending → published)
- ✅ Reject artikel dengan alasan (pending → rejected)
- ✅ Unpublish artikel (published → archived)
- ✅ Hapus artikel apapun

## 🔄 Workflow Artikel

```
User buat artikel (draft)
    ↓
User submit (pending)
    ↓
Admin review
    ↓
┌───────┴────────┐
↓                ↓
Approve      Reject
↓                ↓
Published    Rejected
             ↓
        User edit & submit ulang
```

## 📁 Struktur File Penting

```
app/Http/Controllers/
├── AuthController.php              # Auth (register, login, logout)
├── ArticleController.php           # User & public article
└── AdminArticleController.php      # Admin approval system

app/Http/Middleware/
├── AdminMiddleware.php             # Proteksi admin routes
└── UserMiddleware.php              # Proteksi user routes

resources/views/
├── home.blade.php                  # Homepage (public)
├── article-detail.blade.php        # Detail artikel
├── login/                          # Login & register pages
├── user/                           # User dashboard & CRUD
├── admin/                          # Admin dashboard & approval
└── layouts/admin.blade.php         # Admin layout

routes/
├── api.php                         # API endpoints
└── web.php                         # Web routes
```

## 🌐 Halaman Web

| URL | Deskripsi | Akses |
|-----|-----------|-------|
| `/` | Homepage | Public |
| `/login` | Login page | Public |
| `/register` | Register page | Public |
| `/articles/{slug}` | Detail artikel | Public |
| `/user/dashboard` | Dashboard user | User |
| `/user/create` | Buat artikel | User |
| `/user/edit/{id}` | Edit artikel | User |
| `/admin/dashboard` | Dashboard admin | Admin |
| `/admin/articles` | List artikel | Admin |
| `/admin/articles/{id}` | Detail & approve | Admin |

## 🔌 API Endpoints

### Public
```
POST   /api/register
POST   /api/login
GET    /api/articles              # List published
GET    /api/articles/{slug}       # Detail published
```

### User (Auth Required)
```
GET    /api/my-articles           # List artikel sendiri
POST   /api/my-articles           # Buat artikel
PUT    /api/my-articles/{id}      # Edit artikel
DELETE /api/my-articles/{id}      # Hapus artikel
POST   /api/my-articles/{id}/submit  # Submit review
```

### Admin (Auth Required)
```
GET    /api/admin/articles              # List semua
GET    /api/admin/articles/pending      # List pending
POST   /api/admin/articles/{id}/approve # Approve
POST   /api/admin/articles/{id}/reject  # Reject
POST   /api/admin/articles/{id}/unpublish # Unpublish
DELETE /api/admin/articles/{id}         # Hapus
```

## 📝 Status Artikel

| Status | Deskripsi | Aksi User | Aksi Admin |
|--------|-----------|-----------|------------|
| **draft** | Baru dibuat | Edit, Submit, Hapus | - |
| **pending** | Menunggu review | - | Approve, Reject |
| **published** | Sudah approved | - | Unpublish, Hapus |
| **rejected** | Ditolak admin | Edit, Submit ulang | Hapus |
| **archived** | Di-unpublish | - | Hapus |

## 🎯 Cara Pakai

### Sebagai User:
1. Register/Login → Redirect ke `/user/dashboard`
2. Klik "Buat Artikel Baru" → Isi form → Simpan (draft)
3. Klik "Submit Review" → Status jadi pending
4. Tunggu admin approve/reject
5. Jika approved → Artikel tampil di homepage
6. Jika rejected → Edit & submit ulang

### Sebagai Admin:
1. Login → Redirect ke `/admin/dashboard`
2. Lihat artikel pending
3. Klik "Review" → Lihat detail
4. Approve atau Reject (dengan alasan)
5. Artikel approved tampil di homepage

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12 (PHP 8.2+)
- **Authentication**: Laravel Sanctum (Bearer Token)
- **Database**: MySQL
- **ORM**: Eloquent

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS 3
- **JavaScript**: Vanilla JS + Fetch API
- **Build Tool**: Vite

### Development Tools
- **Package Manager**: Composer (PHP), NPM (JS)
- **Testing**: PHPUnit
- **Code Style**: Laravel Pint

## 🏗️ Arsitektur Sistem

### Backend Architecture
```
┌─────────────────────────────────────────────────┐
│                   Client                        │
│            (Browser / API Client)               │
└────────────────┬────────────────────────────────┘
                 │ HTTP Request + Bearer Token
                 ↓
┌─────────────────────────────────────────────────┐
│              Laravel Routes                     │
│         (routes/api.php, web.php)               │
└────────────────┬────────────────────────────────┘
                 │
                 ↓
┌─────────────────────────────────────────────────┐
│              Middleware Layer                   │
│  • auth:sanctum (Token Validation)              │
│  • AdminMiddleware (Role Check)                 │
│  • UserMiddleware (Auth Check)                  │
└────────────────┬────────────────────────────────┘
                 │
                 ↓
┌─────────────────────────────────────────────────┐
│              Controllers                        │
│  • AuthController (Login, Register)             │
│  • ArticleController (User CRUD)                │
│  • AdminArticleController (Approval)            │
└────────────────┬────────────────────────────────┘
                 │
                 ↓
┌─────────────────────────────────────────────────┐
│              Models (Eloquent ORM)              │
│  • User (users table)                           │
│  • Articles (articles table)                    │
└────────────────┬────────────────────────────────┘
                 │
                 ↓
┌─────────────────────────────────────────────────┐
│              MySQL Database                     │
│  • users                                        │
│  • articles                                     │
│  • personal_access_tokens                       │
└─────────────────────────────────────────────────┘
```

### Frontend Architecture
```
resources/js/
├── api/
│   ├── config.js          → API base config & token management
│   ├── auth.js            → Authentication API calls
│   └── articles.js        → Article CRUD API calls
├── utils/
│   └── helpers.js         → Utility functions
├── bootstrap.js           → Axios setup
└── app.js                 → Entry point

resources/views/
├── layouts/
│   ├── app.blade.php      → Public layout
│   └── admin.blade.php    → Admin layout
├── home.blade.php         → Homepage (public)
├── login/                 → Auth pages
├── user/                  → User dashboard & CRUD
└── admin/                 → Admin dashboard & approval
```

## 📚 Dokumentasi Lengkap

| File | Deskripsi |
|------|-----------|
| `API_GUIDE.md` | Dokumentasi API lengkap, Bearer Token, Frontend modules |
| `ARTICLE_SYSTEM_GUIDE.md` | Guide sistem artikel & workflow |

### Dokumentasi API
- ✅ Authentication endpoints (register, login, logout)
- ✅ User endpoints (CRUD artikel sendiri)
- ✅ Admin endpoints (approval system)
- ✅ Public endpoints (view published articles)
- ✅ Bearer Token authentication flow
- ✅ Error handling & status codes

## 🔐 Security Features

### Authentication & Authorization
- ✅ **Laravel Sanctum**: Token-based authentication
- ✅ **Bearer Token**: Disimpan di localStorage (frontend) & database (backend)
- ✅ **Password Hashing**: Bcrypt algorithm
- ✅ **CSRF Protection**: Enabled untuk web routes
- ✅ **Middleware Protection**: Role-based access control

### Data Validation
- ✅ **Input Validation**: Laravel validation rules
- ✅ **Ownership Check**: User hanya bisa edit artikel sendiri
- ✅ **Status Validation**: Artikel hanya bisa diedit di status tertentu
- ✅ **XSS Protection**: Blade template escaping

### API Security
- ✅ **Token Expiration**: Configurable token lifetime
- ✅ **Rate Limiting**: API throttling (optional)
- ✅ **CORS**: Configured untuk API access

## 🚀 Deployment

### Requirements
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- Node.js & NPM
- Web server (Apache/Nginx)

### Production Setup
```bash
# 1. Clone & install
git clone <repository-url>
cd web-article
composer install --optimize-autoloader --no-dev
npm install
npm run build

# 2. Environment
cp .env.example .env
php artisan key:generate
# Edit .env untuk production config

# 3. Database
php artisan migrate --force
php artisan db:seed --class=AdminSeeder

# 4. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

SANCTUM_STATEFUL_DOMAINS=yourdomain.com
SESSION_DOMAIN=.yourdomain.com
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ArticleTest

# With coverage
php artisan test --coverage
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

Built with ❤️ using Laravel & Tailwind CSS

## 📞 Support

Untuk pertanyaan atau issue, silakan buka issue di repository ini atau hubungi maintainer.

---

**Version**: 1.0.0  
**Last Updated**: November 2025
