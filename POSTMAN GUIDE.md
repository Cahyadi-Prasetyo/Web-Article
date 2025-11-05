# Postman Guide
## Cara Testing dengan Postman

### 1. **Pastikan Server Berjalan**
```bash
php artisan serve
```
Server akan berjalan di: `http://127.0.0.1:8000`

### 2. **Test Endpoints**

#### A. Login Admin
```
POST http://127.0.0.1:8000/api/login
Content-Type: application/json

{
    "email": "admin@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "role": "admin"
    },
    "access_token": "2|Y5ly6OMtLdLQsOpHKzLkacZ86GBRy4j2WI7fK94A7fe77cc4",
    "token_type": "Bearer"
}
```

#### B. Get Articles (Public)
```
GET http://127.0.0.1:8000/api/articles
Accept: application/json
```

#### C. Create Article (Admin Only)
```
POST http://127.0.0.1:8000/api/articles
Authorization: Bearer {your_token_here}
Content-Type: application/json

{
    "title": "Test Article",
    "categories": "Test,API",
    "content": "This is a test article content",
    "excerpt": "Test excerpt",
    "status": "published"
}
```

#### D. Get Admin Articles
```
GET http://127.0.0.1:8000/api/admin/articles
Authorization: Bearer {your_token_here}
Accept: application/json
```

### 3. **Headers yang Diperlukan**

#### Untuk Semua Request:
- `Accept: application/json`

#### Untuk Request dengan Body:
- `Content-Type: application/json`

#### Untuk Protected Routes:
- `Authorization: Bearer {token}`

### 4. **Common Issues & Solutions**

#### Issue: "Unauthenticated"
- **Cause**: Token tidak disertakan atau salah
- **Solution**: Pastikan header `Authorization: Bearer {token}` benar

#### Issue: "Access denied. Admin role required"
- **Cause**: User bukan admin
- **Solution**: Login dengan akun admin (admin@example.com)

#### Issue: "Article not found"
- **Cause**: Slug atau ID artikel tidak ditemukan
- **Solution**: Gunakan slug yang benar dari response GET /articles

#### Issue: "Validation errors"
- **Cause**: Data yang dikirim tidak sesuai validasi
- **Solution**: Periksa field yang required dan format data

### 5. **Sample Postman Collection**

Buat collection baru di Postman dengan requests berikut:

1. **Login Admin**
   - Method: POST
   - URL: `{{base_url}}/api/login`
   - Body: raw JSON dengan email dan password

2. **Get Articles**
   - Method: GET
   - URL: `{{base_url}}/api/articles`

3. **Create Article**
   - Method: POST
   - URL: `{{base_url}}/api/articles`
   - Headers: Authorization Bearer token
   - Body: raw JSON dengan data artikel

4. **Update Article**
   - Method: PUT
   - URL: `{{base_url}}/api/articles/{{article_id}}`
   - Headers: Authorization Bearer token
   - Body: raw JSON dengan data yang akan diupdate

5. **Delete Article**
   - Method: DELETE
   - URL: `{{base_url}}/api/articles/{{article_id}}`
   - Headers: Authorization Bearer token

### 6. **Environment Variables**
Buat environment di Postman:
- `base_url`: `http://127.0.0.1:8000`
- `admin_token`: (copy dari response login)

### 7. **Pre-request Scripts**
Untuk otomatis set token setelah login, gunakan script:
```javascript
pm.test("Login successful", function () {
    var jsonData = pm.response.json();
    pm.environment.set("admin_token", jsonData.access_token);
});
```

## Status: ✅ FIXED
API sekarang berfungsi dengan baik dan dapat ditest menggunakan Postman!