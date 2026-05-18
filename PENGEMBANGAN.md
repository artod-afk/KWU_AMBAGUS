# Dokumentasi Pengembangan Sistem Toko Sembako

## Ringkasan Pengembangan

Sistem telah dikembangkan dengan menambahkan fitur **Catatan Keuangan** yang terintegrasi dengan sistem **Kelola Stok Barang** yang sudah ada.

## Fitur Baru yang Ditambahkan

### 1. Dashboard Utama (Halaman Home)
- **Lokasi**: `resources/views/dashboard.blade.php`
- **Fitur**:
  - Desain modern dengan 2 card utama
  - Card 1: Kelola Stok Barang → mengarah ke `/products`
  - Card 2: Catatan Keuangan → mengarah ke `/finance/report`
  - Responsive untuk mobile
  - Animasi hover pada card

### 2. Modul Pemasukan (Income)
- **Route**: `/finance/incomes`
- **Controller**: `App\Http\Controllers\IncomeController`
- **Model**: `App\Models\Income`
- **Fitur**:
  - Tambah data pemasukan (penjualan barang)
  - Edit data pemasukan
  - Hapus data pemasukan
  - Pencarian data
  - **Otomatis mengurangi stok** saat transaksi dibuat
  - **Otomatis mengembalikan stok** saat transaksi dihapus
  - Auto-calculate total (jumlah × harga jual)
  - Validasi stok tersedia

### 3. Modul Pengeluaran (Expense)
- **Route**: `/finance/expenses`
- **Controller**: `App\Http\Controllers\ExpenseController`
- **Model**: `App\Models\Expense`
- **Fitur**:
  - Tambah data pengeluaran (pembelian barang)
  - Edit data pengeluaran
  - Hapus data pengeluaran
  - Pencarian data (produk & supplier)
  - **Otomatis menambah stok** saat transaksi dibuat
  - **Otomatis mengurangi stok** saat transaksi dihapus
  - Auto-calculate total (jumlah × harga beli)
  - Field supplier opsional

### 4. Laporan Keuangan
- **Route**: `/finance/report`
- **Controller**: `App\Http\Controllers\FinanceReportController`
- **Fitur**:
  - Ringkasan total pemasukan
  - Ringkasan total pengeluaran
  - Perhitungan keuntungan (pemasukan - pengeluaran)
  - Filter berdasarkan tanggal
  - Grafik line chart pemasukan & pengeluaran
  - Tabel riwayat transaksi terbaru (10 terakhir)
  - Quick links ke halaman pemasukan & pengeluaran

## Database

### Tabel Baru

#### 1. `incomes` (Pemasukan)
```sql
- id (bigint, primary key)
- product_id (foreign key → products.id)
- quantity (integer)
- selling_price (decimal 15,2)
- total (decimal 15,2)
- transaction_date (date)
- notes (text, nullable)
- created_at, updated_at
```

#### 2. `expenses` (Pengeluaran)
```sql
- id (bigint, primary key)
- product_id (foreign key → products.id)
- quantity (integer)
- purchase_price (decimal 15,2)
- total (decimal 15,2)
- supplier (string, nullable)
- transaction_date (date)
- notes (text, nullable)
- created_at, updated_at
```

### Migration Files
- `2026_05_18_000001_create_incomes_table.php`
- `2026_05_18_000002_create_expenses_table.php`

## Struktur File

### Controllers
```
app/Http/Controllers/
├── IncomeController.php          # CRUD Pemasukan
├── ExpenseController.php         # CRUD Pengeluaran
├── FinanceReportController.php   # Laporan Keuangan
└── DashboardController.php       # Dashboard Home (updated)
```

### Models
```
app/Models/
├── Income.php                    # Model Pemasukan
└── Expense.php                   # Model Pengeluaran
```

### Views
```
resources/views/
├── dashboard.blade.php           # Dashboard Home (updated)
└── finance/
    ├── incomes/
    │   ├── index.blade.php       # List Pemasukan
    │   ├── create.blade.php      # Form Tambah Pemasukan
    │   └── edit.blade.php        # Form Edit Pemasukan
    ├── expenses/
    │   ├── index.blade.php       # List Pengeluaran
    │   ├── create.blade.php      # Form Tambah Pengeluaran
    │   └── edit.blade.php        # Form Edit Pengeluaran
    └── report/
        └── index.blade.php       # Laporan Keuangan
```

### Routes
```php
// Dashboard
GET /dashboard → DashboardController@index

// Kelola Stok (existing)
GET /products → ProductController@index
// ... other product routes

// Keuangan
GET /finance/incomes → IncomeController@index
POST /finance/incomes → IncomeController@store
GET /finance/incomes/create → IncomeController@create
GET /finance/incomes/{income}/edit → IncomeController@edit
PUT /finance/incomes/{income} → IncomeController@update
DELETE /finance/incomes/{income} → IncomeController@destroy

GET /finance/expenses → ExpenseController@index
POST /finance/expenses → ExpenseController@store
GET /finance/expenses/create → ExpenseController@create
GET /finance/expenses/{expense}/edit → ExpenseController@edit
PUT /finance/expenses/{expense} → ExpenseController@update
DELETE /finance/expenses/{expense} → ExpenseController@destroy

GET /finance/report → FinanceReportController@index
```

## Navigasi

Menu navigasi telah diupdate di `resources/views/layouts/navigation.blade.php`:
- Dashboard
- Kelola Stok
- Keuangan

## Integrasi Stok & Keuangan

### Sinkronisasi Otomatis:

1. **Saat Pemasukan Dibuat** (Penjualan):
   - Stok produk **dikurangi** sesuai jumlah terjual
   - Menggunakan database transaction untuk konsistensi

2. **Saat Pemasukan Diedit**:
   - Stok lama **dikembalikan**
   - Stok baru **dikurangi**

3. **Saat Pemasukan Dihapus**:
   - Stok **dikembalikan**

4. **Saat Pengeluaran Dibuat** (Pembelian):
   - Stok produk **ditambah** sesuai jumlah dibeli
   - Menggunakan database transaction untuk konsistensi

5. **Saat Pengeluaran Diedit**:
   - Stok lama **dikurangi**
   - Stok baru **ditambah**

6. **Saat Pengeluaran Dihapus**:
   - Stok **dikurangi**

## Cara Menjalankan

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. (Opsional) Seed Database
```bash
php artisan db:seed
```

### 3. Jalankan Development Server
```bash
php artisan serve
```

### 4. Akses Aplikasi
- URL: `http://127.0.0.1:8000`
- Login dengan kredensial yang sudah dibuat

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Chart**: Chart.js
- **Database**: SQLite (atau sesuai konfigurasi)

## Fitur Lama yang Dipertahankan

✅ Semua fitur kelola stok barang tetap berfungsi:
- CRUD Produk
- Stok Alert
- Stock History
- Dashboard Stok (masih bisa diakses via `/products`)

## Catatan Penting

1. **Database Transaction**: Semua operasi yang melibatkan perubahan stok menggunakan DB transaction untuk memastikan konsistensi data.

2. **Validasi**: Semua form memiliki validasi server-side dan client-side.

3. **Responsive Design**: Semua halaman responsive untuk mobile, tablet, dan desktop.

4. **User Experience**: 
   - Auto-calculate total di form
   - Konfirmasi sebelum hapus
   - Alert message untuk feedback
   - Loading state untuk operasi async

5. **Security**: 
   - Semua route dilindungi middleware `auth`
   - CSRF protection aktif
   - Input validation

## Pengembangan Selanjutnya (Opsional)

Beberapa ide untuk pengembangan lebih lanjut:
- Export laporan ke PDF/Excel
- Notifikasi email untuk stok menipis
- Multi-user dengan role & permission
- Backup database otomatis
- Dashboard analytics lebih detail
- Integrasi dengan sistem kasir

---

**Dibuat pada**: 18 Mei 2026
**Developer**: Kiro AI Assistant
