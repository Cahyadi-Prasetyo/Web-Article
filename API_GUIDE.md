# 📚 API & Frontend Guide - Article System

## 🔐 Sistem Bearer Token Authentication

### Apa itu Bearer Token?
**Ya, sistem ini sudah menerapkan Bearer Token Authentication** menggunakan Laravel Sanctum.

**Cara Kerja:**
1. User login → Server generate token → Token dikirim ke client
2. Client simpan token di **localStorage** browser
3. Setiap request API → Client kirim token via header `Authorization: Bearer {token}`
4. Server validasi token → Jika valid, proses request → Return response

**Lokasi Penyimpanan Token:**
- **Frontend**: `localStorage.setItem('auth_token', token)` di browser
- **Backend**: Table `personal_access_tokens` di database

**Keamanan:**
- Token di-hash di database
- Token expire otomatis (bisa diatur di config)
- Token dihapus saat logout

---

## 📁 Struktur File

### Backend (Laravel)
```
routes/api.php                          → Definisi endpoint API
app/Http/Controllers/
  ├── AuthController.php                → Login, Register, Logout
  ├── ArticleController.php             → CRUD artikel user
  └── AdminArticleController.php        → Approve, Reject artikel
app/Http/Middleware/
  ├── AdminMiddleware.php               → Proteksi route admin
  └── UserMiddleware.php                → Proteksi route user
app/Models/
  ├── User.php                          → Model user
  └── Articles.php                      → Model artikel
```

### Frontend (JavaScript)
```
resources/js/
  ├── app.js                            → Entry point
  ├── bootstrap.js                      → Setup axios
  ├── auth.js                           → Helper autentikasi (DEPRECATED)
  ├── api/
  │   ├── config.js                     → Konfigurasi API & token management
  │   ├── auth.js                       → API calls autentikasi
  │   └── articles.js                   → API calls artikel
  └── utils/
      └── helpers.js                    → Utility functions
```

---

## 🔄 Flow Authentication dengan Bearer Token

### 1. Register & Login
```javascript
// User register/login
POST /api/login
Body: { email, password }

// Server response
{
  "user": { id, name, email, role },
  "access_token": "1|xxxxxxxxxxxxx"  // ← Bearer Token
}

// Frontend simpan token
localStorage.setItem('auth_token', token);
localStorage.setItem('user', JSON.stringify(user));
```

### 2. Request dengan Token
```javascript
// Frontend kirim request
GET /api/my-articles
Headers: {
  "Authorization": "Bearer 1|xxxxxxxxxxxxx",
  "Content-Type": "application/json"
}

// Backend validasi token
Middleware auth:sanctum → Cari token di DB → Load user → Process request
```

### 3. Logout
```javascript
// Frontend hapus token
POST /api/logout
Headers: { "Authorization": "Bearer {token}" }

// Backend hapus token dari DB
localStorage.removeItem('auth_token');
localStorage.removeItem('user');
```

---

## 🌐 API Endpoints

### Public (Tanpa Token)
| Method | Endpoint | Fungsi |
|--------|----------|--------|
| POST | `/api/register` | Daftar user baru |
| POST | `/api/login` | Login & dapat token |
| GET | `/api/articles` | List artikel published |
| GET | `/api/articles/{slug}` | Detail artikel |

### User (Perlu Token)
| Method | Endpoint | Fungsi |
|--------|----------|--------|
| GET | `/api/profile` | Get profile user |
| POST | `/api/logout` | Logout & hapus token |
| GET | `/api/my-articles` | List artikel milik user |
| POST | `/api/my-articles` | Buat artikel baru |
| PUT | `/api/my-articles/{id}` | Update artikel |
| DELETE | `/api/my-articles/{id}` | Hapus artikel |

### Admin (Perlu Token Admin)
| Method | Endpoint | Fungsi |
|--------|----------|--------|
| GET | `/api/admin/articles` | List semua artikel |
| GET | `/api/admin/articles/pending` | List artikel pending |
| POST | `/api/admin/articles/{id}/approve` | Approve artikel |
| POST | `/api/admin/articles/{id}/reject` | Reject artikel |
| POST | `/api/admin/articles/{id}/unpublish` | Unpublish artikel |
| DELETE | `/api/admin/articles/{id}` | Hapus artikel |

---

## 💻 Frontend JavaScript Modules

### 1. `resources/js/api/config.js`
**Fungsi**: Konfigurasi API & Token Management

```javascript
// Token Management
getToken()              // Ambil token dari localStorage
setToken(token)         // Simpan token ke localStorage
removeToken()           // Hapus token dari localStorage

// User Management
getUser()               // Ambil user data dari localStorage
setUser(user)           // Simpan user data ke localStorage
removeUser()            // Hapus user data dari localStorage

// Auth Check
isAuthenticated()       // Cek apakah user sudah login
isAdmin()               // Cek apakah user adalah admin

// API Request Helper
apiRequest(endpoint, options)  // Wrapper fetch dengan auto-inject token
```

**Contoh Penggunaan:**
```javascript
import { apiRequest, setToken, getToken } from './api/config.js';

// Request dengan token otomatis
const articles = await apiRequest('/my-articles');

// Token otomatis ditambahkan ke header:
// Authorization: Bearer {token}
```

---

### 2. `resources/js/api/auth.js`
**Fungsi**: API Calls untuk Autentikasi

```javascript
register(userData)      // Daftar user baru
login(credentials)      // Login user
logout()                // Logout user
getCurrentUser()        // Get user profile
```

**Contoh Penggunaan:**
```javascript
import { login, logout } from './api/auth.js';

// Login
const data = await login({ 
  email: 'user@example.com', 
  password: 'password123' 
});
// Token otomatis disimpan ke localStorage

// Logout
await logout();
// Token otomatis dihapus dari localStorage
```

---

### 3. `resources/js/api/articles.js`
**Fungsi**: API Calls untuk Artikel

```javascript
// Public
getArticles(params)           // List artikel published
getArticle(slug)              // Detail artikel

// User
getAdminArticles(params)      // List artikel (admin)
createArticle(articleData)    // Buat artikel
updateArticle(id, data)       // Update artikel
deleteArticle(id)             // Hapus artikel
```

**Contoh Penggunaan:**
```javascript
import { createArticle, getArticles } from './api/articles.js';

// Buat artikel (token otomatis diambil dari localStorage)
const article = await createArticle({
  title: 'Judul Artikel',
  categories: 'Technology',
  content: 'Konten lengkap...',
  excerpt: 'Ringkasan',
});

// Get artikel published (tanpa token)
const articles = await getArticles({ page: 1 });
```

---

### 4. `resources/js/auth.js` (DEPRECATED)
**Status**: File ini duplikat dengan `api/config.js`

**Rekomendasi**: 
- Gunakan `api/config.js` dan `api/auth.js` untuk konsistensi
- File `auth.js` di root bisa dihapus atau digunakan sebagai wrapper

---

### 5. `resources/js/utils/helpers.js`
**Fungsi**: Utility Functions

```javascript
formatDate(dateString)          // Format tanggal ke format Indonesia
truncate(text, length)          // Potong teks panjang
showToast(message, type)        // Tampilkan notifikasi
showLoading(element)            // Tampilkan loading spinner
hideLoading(element)            // Sembunyikan loading spinner
validateForm(formData, rules)   // Validasi form
getStatusBadge(status)          // Get CSS class untuk status badge
debounce(func, wait)            // Debounce function untuk search
```

**Contoh Penggunaan:**
```javascript
import { formatDate, showToast } from './utils/helpers.js';

// Format tanggal
const date = formatDate('2025-11-19T10:00:00.000000Z');
// Output: "19 November 2025, 10:00"

// Tampilkan notifikasi
showToast('Artikel berhasil disimpan!', 'success');
```

---

### 6. `resources/js/bootstrap.js`
**Fungsi**: Setup Axios untuk HTTP requests

```javascript
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
```

**Catatan**: File ini setup axios, tapi API modules menggunakan `fetch()` API.

---

### 7. `resources/js/app.js`
**Fungsi**: Entry point aplikasi

```javascript
import './bootstrap';
```

**Catatan**: File ini hanya import bootstrap.js, bisa ditambahkan inisialisasi lain.

---

## 🔒 Keamanan Bearer Token

### Penyimpanan Token
```javascript
// ✅ BENAR: Simpan di localStorage
localStorage.setItem('auth_token', token);

// ❌ SALAH: Jangan simpan di cookie tanpa httpOnly
document.cookie = `token=${token}`;
```

### Pengiriman Token
```javascript
// ✅ BENAR: Kirim via Authorization header
headers: {
  'Authorization': `Bearer ${token}`
}

// ❌ SALAH: Jangan kirim via URL
fetch(`/api/articles?token=${token}`)
```

### Validasi Token (Backend)
```php
// Middleware auth:sanctum otomatis validasi token
Route::middleware('auth:sanctum')->group(function () {
    // Protected routes
});

// Token dicari di table personal_access_tokens
// Jika tidak valid → 401 Unauthorized
```

---

## 📊 Status Artikel

```
draft → pending → published
              ↓
           rejected → (edit) → pending
           
published → archived
```

**Aturan:**
- User hanya bisa edit artikel `draft` atau `rejected`
- User tidak bisa edit artikel `pending` atau `published`
- Admin bisa approve/reject artikel `pending`
- Admin bisa unpublish artikel `published` → `archived`

---

## 🧪 Testing API dengan cURL

### 1. Login & Simpan Token
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'

# Response: { "access_token": "1|xxxxx" }
# Simpan token untuk request selanjutnya
```

### 2. Request dengan Token
```bash
curl -X GET http://localhost:8000/api/my-articles \
  -H "Authorization: Bearer 1|xxxxx" \
  -H "Content-Type: application/json"
```

### 3. Create Article dengan Token
```bash
curl -X POST http://localhost:8000/api/my-articles \
  -H "Authorization: Bearer 1|xxxxx" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Article",
    "categories": "Technology",
    "content": "Article content...",
    "excerpt": "Article summary",
    "action": "draft"
  }'
```

---

## ✅ Kesimpulan

### Sistem Bearer Token
- ✅ **Sudah terimplementasi** menggunakan Laravel Sanctum
- ✅ **Token disimpan** di localStorage (frontend) & database (backend)
- ✅ **Auto-inject token** via `apiRequest()` helper
- ✅ **Middleware protection** untuk route user & admin

### Frontend Modules
- ✅ **api/config.js**: Token management & API wrapper
- ✅ **api/auth.js**: Login, register, logout
- ✅ **api/articles.js**: CRUD artikel
- ✅ **utils/helpers.js**: Utility functions
- ⚠️ **auth.js** (root): Duplikat, bisa dihapus

### Rekomendasi
1. Hapus `resources/js/auth.js` untuk menghindari duplikasi
2. Gunakan `api/config.js` dan `api/auth.js` secara konsisten
3. Tambahkan token expiration handling (refresh token)
4. Implementasi HTTPS di production untuk keamanan token

**API sudah production-ready dengan Bearer Token Authentication!** 🎉
