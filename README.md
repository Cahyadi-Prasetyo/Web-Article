# 🚀 Website Article dengan Role & Approval System

Sistem manajemen artikel dengan 3 role (Guest, User, Admin) dan workflow approval yang lengkap.

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

- **Backend**: Laravel 12
- **Frontend**: Blade + Tailwind CSS + Vanilla JS
- **Auth**: Laravel Sanctum (Token-based)
- **Database**: MySQL

## 📚 Dokumentasi Lengkap

Lihat file `PANDUAN_LENGKAP.md` untuk dokumentasi detail termasuk:
- Setup lengkap
- API documentation
- Database schema
- Testing guide
- Troubleshooting

## 🔐 Security Notes

- Token disimpan di localStorage
- Middleware proteksi untuk setiap role
- CSRF protection enabled
- Password hashing dengan bcrypt

## 📞 Support

Untuk dokumentasi lengkap, lihat:
- `PANDUAN_LENGKAP.md` - Dokumentasi detail
- `ARTICLE_SYSTEM_GUIDE.md` - Guide sistem article

---

**Built with ❤️ using Laravel & Tailwind CSS**
