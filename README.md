
# BIZNET TEST

## 🚀 Quick Start

### Using Docker (Recommended)
```bash
# Start all services
docker-compose up -d

# Or use the batch file (Windows)
start-app.bat
```

### 📁 Project Structure

```
biznet/
├── ai-knowledge/           # Vue.js AI Chat Frontend
├── php/                    # PHP Barcode Generator
├── docker-compose.yml      # Service orchestration
├── entrypoint.sh          # Ollama auto-setup script
├── start-app.bat          # Windows startup script
└── nginx.conf             # Reverse proxy config
```

### 🔧 Services

| Service | Port | Description |
|---------|------|-------------|
| **AI Chat Frontend** | 3000 | Vue.js chat interface |
| **PHP Barcode Generator** | 8080 | Barcode/QR code generator |
| **Ollama AI Service** | 11434 | Local AI model (Gemma3:1b) |
| **Nginx Proxy** | 80 | Reverse proxy (optional) |

## SEO

Kunjungi halaman https://biznetnetworks.com/. Pada halaman tersebut, jelaskanlah kepada kami beberapa hal di bawah ini:

1. **Bagaimana menurut anda kondisi SEO dari website tersebut?**

    Berdasarkan penilaian manual serta audit SEO otomatis dari SEO Site Checkup
(https://seositecheckup.com/seo-audit/biznetnetworks.com),
    
*   **Skor SEO:** 68/100, yang berada di bawah skor rata-rata 75/100 untuk 100 situs teratas. Ini menunjukkan bahwa ada ruang signifikan untuk perbaikan.
*   **Masalah Ditemukan:** Terdapat 19 masalah penting (Failed), 7 peringatan (Warnings), dan 47 item yang sudah Passed.
*   **Isu Prioritas Tinggi:** Beberapa isu prioritas tinggi meliputi kecepatan loading halaman, kurangnya atribut "alt" pada gambar, dan tidak menggunakan protokol HTTP/2.


2. Apakah hal-hal yang bisa anda improve dari website tersebut agar dapat memaksimalkan SEO nya?

- **Percepat waktu muat halaman**  
  - Kompres gambar & konversi ke WebP  
  - Minifikasi CSS, JavaScript, dan HTML  
  - Aktifkan kompresi GZIP dan caching browser  
  - Manfaatkan CDN dan implementasi HTTP/2  

- **Tambahkan atribut `alt` pada semua gambar**  
  - Buat deskripsi `alt` yang jelas dan relevan untuk tiap `<img>`  

- **Implementasikan HTTP/2**  
  - Gunakan multiplexing dan header compression  

- **Tuntaskan semua isu “Failed”**  
  - Review dan perbaiki 19 masalah kritis  

- **Selesaikan peringatan (“Warnings”)**  
  - Atasi 7 isu tersisa untuk optimasi lebih lanjut  

3. Apakah yang bisa anda lakukan untuk mempercepat load dari halaman website tersebut?

- **Percepat waktu muat halaman**  
  - Kompres gambar & ubah ke WebP  
  - Minifikasi CSS, JavaScript, dan HTML  
  - Aktifkan GZIP, caching browser, dan CDN  

- **Lengkapi atribut `alt` pada gambar**  
  - Tuliskan deskripsi singkat dan relevan di setiap `alt`  

- **Implementasikan HTTP/2**  
  - Manfaatkan multiplexing dan header compression  

- **Tuntaskan semua isu “Failed”**  
  - Review dan perbaiki 19 masalah kritis satu per satu  

- **Atasi peringatan (“Warnings”)**  
  - Selesaikan 7 item peringatan untuk optimasi lebih lanjut  

## MySQL
Buatlah tabel di bawah ini : 
```sql
create table employees (
   id (INT, PRIMARY KEY),
   name (VARCHAR),
   department_id (INT),
   salary (DECIMAL)
);
create table departments (
   id (INT, PRIMARY KEY),
   department_name (VARCHAR)
);
```
Dengan Table diatas:

1. Buatlah query untuk menampilkan data employee_name, department_name dan salary.
```sql
SELECT
	a.name as employee_name,
	b.department_name,
	a.salary
FROM
	employees a
INNER JOIN departments b ON
	a.department_id = b.id;
```    

2. Buatlah query untuk menampilkan rata - rata salary dengan order descending dari setiap departemen dengan format department_id, department_name dan average salary.
```sql
SELECT
	b.id department_id,
	b.department_name,
	ROUND(AVG(a.salary)) as average_salary
FROM
	employees a
INNER JOIN departments b ON
	a.department_id = b.id
GROUP BY b.id
ORDER BY AVG(a.salary) DESC;
```

3. Buatlah query untuk update salary dari employee dengan penambahan sebanyak 5% dari salary pegawai saat ini.
```sql
UPDATE employees
SET salary = salary * 1.05;
```
--- 
Buatlah tabel di bawah ini : 
```sql
create table orders (
   order_id (INT, PRIMARY KEY),
   customer_id (INT),
   order_date (DATE),
   total_amount (DECIMAL)
);
```
Dengan tabel di atas : 

1. Buatlah query untuk menampilkan semua order pada bulan ini dengan format order_id, customer_id, order_date dan total_amount.
```sql
SELECT
	a.order_id,
	a.customer_id,
	a.order_date,
	a.total_amount
FROM
	orders a
WHERE MONTH(a.order_date) = MONTH(NOW());
```    

2. Buatlah query untuk menampilkan customer_id dan total_amount untuk order yang yang melebihi rata - rata total_amount dari semua order.
```sql
SELECT customer_id, total_amount
FROM orders
WHERE total_amount > (
    SELECT AVG(total_amount)
    FROM orders
);
```

3. Buatlah query untuk menambahkan field bonus dengan tipe data decimal pada tabel di atas.
```sql
ALTER TABLE orders add column bonus decimal;
```

## Javascript + HTML

Demo:
https://jsfiddle.net/jhml1202/4ufnhyps/20/

## PHP

Requirements:
- PHP ≥ 8.3  
- Composer  
- Web server (Apache, Nginx, atau sejenis) dengan modul PHP aktif  
- (Opsional) XAMPP, MAMP, atau Laragon untuk setup cepat  

Langkah Menjalankan secara Lokal:

1. Instal dependensi
   ```bash
   cd PHP
   composer install
   
2. Buka browser
     ```
     http:localhost/biznet-test/php
     ```
## Problem Solving

1. Cara Mengatasi 100 Request Sekaligus yang Membuat Aplikasi Hang

- **Optimasi Database Pooling**  
  - Atur koneksi: `max` wajar, `idle` timeout singkat  
  - Tambahkan circuit breaker & retry policy  
  - Pertimbangkan PgBouncer (PostgreSQL) atau proxy pooling sejenis  

- **Profiling & Refactor Kode**  
  - Profiling untuk temukan bottleneck (CPU, I/O)  
  - Ubah ke asynchronous/non-blocking I/O  
  - Manfaatkan caching (Redis/in-memory) untuk data yang sering diakses  

- **Skalabilitas Infrastruktur**  
  - Horizontal scaling di belakang load balancer  
  - Konfigurasi auto-scaling berdasarkan metrik (CPU, antrean request)  
  - Terapkan rate limiting/API gateway untuk atur burst traffic  

- **Proteksi Terhadap Traffic Abnormal**  
  - Identifikasi dan blok IP spam otomatis  
  - Gunakan WAF/API gateway dengan detection rules  
  - Terapkan token bucket/leaky bucket untuk smoothing  

- **Monitoring & Observability**  
  - Pasang metrik (response time, error rate, queue length)  
  - Setup alert untuk lonjakan error atau latensi  
  - Gunakan distributed tracing untuk melacak jalur request  

2. Bagaimanakah cara anda mengatasi Race Condition pada aplikasi anda? Jelaskan beserta contohnya

- **Pessimistic Locking (DB Transaction Lock)**  
  Gunakan `SELECT … FOR UPDATE` di dalam transaksi untuk mengunci baris sebelum update:  
  ```sql
  START TRANSACTION;
  SELECT stock FROM products WHERE id = 42 FOR UPDATE;
  UPDATE products SET stock = stock - 1 WHERE id = 42;
  COMMIT;


## AI KNOWLEDGE
Setelah service ollama dan ai-knowledge dijalankan, buka browser link: 
    ```
     localhost:3000
    ```
