# Panduan Sistem Article dengan Role & Approval

## Struktur Role

### 1. **Guest (Pengunjung)**
- Tidak perlu login
- Hanya bisa melihat artikel yang sudah **published**

### 2. **User (Penulis)**
- Harus login
- Bisa membuat artikel (status: draft)
- Bisa edit artikel sendiri (hanya jika status: draft atau rejected)
- Bisa submit artikel untuk review (draft/rejected → pending)
- Bisa hapus artikel sendiri (hanya jika status: draft atau rejected)
- **TIDAK BISA** publish artikel sendiri
- **TIDAK BISA** edit/hapus artikel yang sudah pending/published

### 3. **Admin**
- Harus login sebagai admin
- Bisa melihat semua artikel (semua status)
- Bisa approve artikel (pending → published)
- Bisa reject artikel dengan alasan (pending → rejected)
- Bisa unpublish artikel (published → archived)
- Bisa hapus artikel apapun

## Status Artikel

1. **draft** - Artikel baru dibuat, masih dikerjakan user
2. **pending** - Artikel sudah disubmit, menunggu review admin
3. **published** - Artikel sudah diapprove admin, tampil untuk public
4. **rejected** - Artikel ditolak admin (user bisa edit dan submit ulang)
5. **archived** - Artikel di-unpublish oleh admin

## API Endpoints

### Authentication
```
POST /api/register          - Daftar user baru
POST /api/login             - Login
POST /api/logout            - Logout (auth required)
GET  /api/profile           - Lihat profile (auth required)
```

### Public (Guest)
```
GET  /api/articles          - Lihat semua artikel published
GET  /api/articles/{slug}   - Lihat detail artikel published
```

### User Routes (auth + user middleware)
```
GET    /api/my-articles              - Lihat artikel milik sendiri
POST   /api/my-articles              - Buat artikel baru (draft)
PUT    /api/my-articles/{id}         - Edit artikel sendiri
DELETE /api/my-articles/{id}         - Hapus artikel sendiri
POST   /api/my-articles/{id}/submit  - Submit artikel untuk review
```

### Admin Routes (auth + admin middleware)
```
GET    /api/admin/articles              - Lihat semua artikel (filter: ?status=pending)
GET    /api/admin/articles/pending      - Lihat artikel pending
POST   /api/admin/articles/{id}/approve - Approve artikel
POST   /api/admin/articles/{id}/reject  - Reject artikel (perlu rejection_reason)
POST   /api/admin/articles/{id}/unpublish - Unpublish artikel
DELETE /api/admin/articles/{id}         - Hapus artikel
```

## Setup & Instalasi

### 1. Jalankan Migration
```bash
php artisan migrate:fresh
```

### 2. Seed Admin & User
```bash
php artisan db:seed --class=AdminSeeder
```

**Default Credentials:**
- Admin: `admin@example.com` / `password123`
- User: `user@example.com` / `password123`

### 3. Test API

#### Login sebagai User
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'
```

#### Buat Artikel (User)
```bash
curl -X POST http://localhost:8000/api/my-articles \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Artikel Pertama Saya",
    "categories": "Technology",
    "content": "Ini adalah konten artikel...",
    "excerpt": "Ringkasan artikel"
  }'
```

#### Submit untuk Review (User)
```bash
curl -X POST http://localhost:8000/api/my-articles/1/submit \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Login sebagai Admin
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password123"}'
```

#### Lihat Artikel Pending (Admin)
```bash
curl -X GET http://localhost:8000/api/admin/articles/pending \
  -H "Authorization: Bearer ADMIN_TOKEN"
```

#### Approve Artikel (Admin)
```bash
curl -X POST http://localhost:8000/api/admin/articles/1/approve \
  -H "Authorization: Bearer ADMIN_TOKEN"
```

#### Reject Artikel (Admin)
```bash
curl -X POST http://localhost:8000/api/admin/articles/1/reject \
  -H "Authorization: Bearer ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"rejection_reason": "Konten tidak sesuai standar"}'
```

## Aturan Bisnis

### User
- ✅ Bisa buat artikel (otomatis status: draft)
- ✅ Bisa edit artikel sendiri (hanya draft/rejected)
- ✅ Bisa submit artikel untuk review
- ❌ Tidak bisa publish sendiri
- ❌ Tidak bisa edit artikel yang sudah pending/published
- ❌ Tidak bisa hapus artikel yang sudah pending/published

### Admin
- ✅ Bisa lihat semua artikel
- ✅ Bisa approve artikel pending
- ✅ Bisa reject artikel pending dengan alasan
- ✅ Bisa unpublish artikel published
- ✅ Bisa hapus artikel apapun

### Guest
- ✅ Bisa lihat artikel published
- ❌ Tidak bisa akses endpoint lain

## Database Schema

### users
- id
- name
- email
- password
- role (enum: 'admin', 'user')
- timestamps

### articles
- id
- title
- categories
- slug (unique)
- content
- excerpt
- status (enum: 'draft', 'pending', 'published', 'rejected', 'archived')
- published_at (nullable)
- author_id (foreign key → users)
- rejection_reason (nullable, text)
- timestamps

## Flow Artikel

```
[User buat artikel] → draft
       ↓
[User submit] → pending
       ↓
[Admin review]
       ↓
    ┌──────┴──────┐
    ↓             ↓
 approve       reject
    ↓             ↓
published    rejected
    ↓             ↓
[Admin unpublish] [User edit & submit ulang]
    ↓
 archived
```
