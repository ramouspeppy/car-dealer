Kamu bekerja langsung pada project Laravel yang sedang terbuka di VS Code.

TUGAS UTAMA

Buat dan sempurnakan DASHBOARD ADMIN untuk website sales mobil yang sudah ada.

Website frontend SUDAH SELESAI.

JANGAN rebuild website.
JANGAN membuat website baru.
JANGAN mengubah frontend publik.
JANGAN mengubah fitur frontend yang sudah berjalan.

Fokus pekerjaan hanya:

- Dashboard Admin
- Visitor Analytics
- Page View Analytics
- Product Analytics
- Lead Analytics
- Inquiry Analytics
- Test Drive Analytics
- Konsultasi Gratis Analytics

Website ini adalah website personal sales mobil.

Website BUKAN marketplace dan BUKAN e-commerce.

Tidak ada kebutuhan:

- cart
- checkout
- payment online
- order online
- invoice
- transaksi online
- revenue dashboard

Tujuan dashboard adalah membantu sales memahami traffic website dan calon pelanggan.

Alur utama dashboard:

VISITOR
→ PAGE VIEW
→ PRODUCT INTEREST
→ LEADS
→ TEST DRIVE
→ KONSULTASI GRATIS

==================================================

1. # STACK EXISTING

Project menggunakan stack existing:

- Laravel 8
- PHP 7.4
- Stisla
- Bootstrap 4
- jQuery
- MySQL
- Blade

Sebelum coding, periksa versi sebenarnya melalui project.

Pertahankan stack existing.

JANGAN:

- upgrade Laravel
- upgrade PHP
- mengganti Stisla
- mengganti Bootstrap
- mengganti frontend framework
- melakukan refactor besar yang tidak diperlukan

Gunakan library yang sudah tersedia jika memungkinkan.

================================================== 2. WAJIB INSPECT PROJECT SEBELUM CODING
=======================================

Sebelum membuat perubahan, inspect project terlebih dahulu.

Periksa minimal:

- composer.json
- package.json
- routes/web.php
- route admin
- controller
- model
- migration
- database structure
- admin layout
- dashboard existing
- Product/Mobil
- Inquiry/Lead
- Test Drive
- Konsultasi Gratis
- Promo
- Berita
- authentication
- authorization/role
- JavaScript
- CSS
- Chart.js
- library visitor/analytics jika sudah ada

Cari struktur database yang sebenarnya.

Cari:

- nama model
- nama tabel
- field
- relationship
- route
- controller
- existing query
- existing component

JANGAN menebak nama model, tabel, field atau route.

Jika fitur sudah tersedia, gunakan fitur tersebut.

Jangan membuat model, tabel, controller atau sistem duplikat.

================================================== 3. TUJUAN DASHBOARD
===================

Dashboard harus memungkinkan sales mengetahui dalam beberapa detik:

- Berapa orang yang mengunjungi website?
- Berapa Page Views?
- Mobil apa yang paling banyak dilihat?
- Berapa Total Leads?
- Berapa Inquiry?
- Berapa Test Drive?
- Berapa Konsultasi Gratis?
- Leads berasal dari jenis apa?
- Mobil apa yang paling diminati?
- Siapa leads terbaru?

================================================== 4. KPI CARD
===========

Buat card KPI utama:

1. Pengunjung
2. Page Views
3. Total Leads
4. Test Drive
5. Konsultasi Gratis

Contoh visual:

Pengunjung
1.284
30 hari terakhir

Page Views
3.842
30 hari terakhir

Total Leads
42
30 hari terakhir

Test Drive
8
30 hari terakhir

Konsultasi Gratis
15
30 hari terakhir

Semua angka HARUS berasal dari database.

Jangan hardcode angka.

================================================== 5. TREND KPI
============

Jika data memungkinkan, tampilkan perbandingan dengan periode sebelumnya.

Contoh:

+12,4%
vs periode sebelumnya

atau:

-8,2%
vs periode sebelumnya

Trend harus dihitung dari data aktual.

Jangan membuat trend palsu.

Jika data pembanding tidak tersedia:

JANGAN tampilkan trend.

================================================== 6. FILTER PERIODE
=================

Dashboard memiliki filter periode.

Pilihan:

- Hari Ini
- 7 Hari
- 30 Hari
- Bulan Ini
- 3 Bulan
- Tahun Ini

DEFAULT:

30 Hari

Jika mudah, boleh tambahkan Custom Date Range.

Filter harus mempengaruhi statistik yang relevan.

Minimal:

- Pengunjung
- Page Views
- Visitor Chart
- Mobil Terpopuler
- Total Leads
- Test Drive
- Konsultasi Gratis
- Mobil Paling Diminati

Gunakan timezone aplikasi existing.

Jangan hardcode timezone.

================================================== 7. DEFINISI PERIODE
===================

Hari Ini:

Hanya tanggal hari ini.

7 Hari:

7 tanggal kalender termasuk hari ini.

30 Hari:

30 tanggal kalender termasuk hari ini.

Bulan Ini:

Tanggal 1 sampai hari ini.

3 Bulan:

3 bulan terakhir.

Tahun Ini:

Tanggal 1 Januari sampai hari ini.

Gunakan Carbon/Laravel date helper sesuai struktur existing.

================================================== 8. VISITOR ANALYTICS
====================

Implementasikan visitor tracking.

Saya tidak menentukan package tertentu.

Kamu harus memilih solusi sendiri berdasarkan:

- Laravel 8 compatibility
- PHP 7.4 compatibility
- shared hosting
- performance
- database footprint
- maintenance
- unique visitor
- page views
- page tracking
- product tracking
- reliability

Jangan memilih package hanya karena populer.

Jika package membutuhkan Laravel/PHP versi lebih tinggi:

JANGAN gunakan package tersebut.

Pilih:

- package kompatibel

atau:

- custom visitor tracking sederhana

Prioritas:

COMPATIBLE
LIGHTWEIGHT
STABLE
ACCURATE
EASY TO MAINTAIN

================================================== 9. DATA VISITOR
===============

Minimal visitor analytics harus dapat mengetahui:

- Unique Visitor
- Page Views
- tanggal/waktu
- halaman yang dikunjungi

Jika solusi memungkinkan dengan aman, boleh menyimpan:

- device
- browser
- OS
- referrer

Jangan menyimpan data pribadi yang tidak diperlukan.

Jangan mengekspos data sensitif visitor.

================================================== 10. VISITOR CHART
=================

Buat section:

STATISTIK PENGUNJUNG

Tampilkan:

- Visitors
- Page Views

Gunakan Chart.js jika sudah tersedia.

Jangan menambahkan library chart baru jika tidak diperlukan.

Chart harus:

- responsive
- clean
- modern
- tooltip informatif
- legend jelas
- smooth animation

================================================== 11. GROUPING CHART
==================

Hari Ini:

Jika tracking mendukung data per jam, tampilkan per jam.

Contoh:

08:00
09:00
10:00
11:00

Jika tidak mendukung data per jam, gunakan data yang tersedia.

Jangan membuat data palsu.

7 Hari:

Grouping per hari.

30 Hari:

Grouping per hari.

Bulan Ini:

Grouping per hari.

3 Bulan:

Jika data harian terlalu banyak, grouping per minggu.

Tahun Ini:

Grouping per bulan.

================================================== 12. MOBIL TERPOPULER
====================

Buat section:

MOBIL TERPOPULER

Gunakan Page Views.

Tampilkan mobil dengan jumlah page view tertinggi.

Gunakan Product/Mobil model existing.

Jangan membuat Product model baru.

Jika Product memiliki image, tampilkan thumbnail.

Contoh:

01
Suzuki Fronx
842 Views

02
Suzuki XL7
731 Views

03
Suzuki Ertiga
625 Views

Tambahkan progress bar yang menunjukkan proporsi terhadap mobil dengan views tertinggi.

Progress bar memiliki animasi ringan.

================================================== 13. TOTAL LEADS
===============

Total Leads berasal dari data lead yang benar-benar ada.

Minimal:

- Inquiry
- Test Drive
- Konsultasi Gratis

Jika masing-masing menggunakan tabel/model berbeda, lakukan aggregation dari data tersebut.

Jangan membuat tabel lead baru jika tidak diperlukan.

Jangan menghitung record dua kali jika struktur database memungkinkan identifikasi lead yang sama.

================================================== 14. JENIS LEADS
===============

Buat section:

JENIS LEADS

Tampilkan:

- Inquiry
- Test Drive
- Konsultasi Gratis

Gunakan Doughnut Chart atau Bar Chart.

Jika menggunakan Doughnut Chart:

Tampilkan total di tengah.

Tooltip:

Jumlah
Persentase

Semua data harus aktual.

================================================== 15. INQUIRY
===========

Cari sistem Inquiry existing.

Gunakan model, table, controller dan form existing.

Jangan membuat sistem Inquiry baru.

Dashboard harus menampilkan jika tersedia:

- Total Inquiry
- Inquiry berdasarkan periode
- Inquiry terbaru
- mobil yang diminati
- source
- status

Jika existing Inquiry memiliki field seperti:

name
phone
city
budget
product_id
payment_type
tenor
message
status
source
ip

gunakan sesuai struktur sebenarnya.

JANGAN mengasumsikan field tersebut pasti ada.

Inspect source code terlebih dahulu.

================================================== 16. TEST DRIVE
==============

Gunakan sistem Test Drive existing.

Tampilkan:

- Total Test Drive
- Test Drive berdasarkan periode
- status Test Drive
- Test Drive terbaru
- mobil paling banyak diminta

Gunakan status existing.

Jangan membuat status baru.

================================================== 17. KONSULTASI GRATIS
=====================

Website memiliki form:

KONSULTASI GRATIS

Cari implementasi existing.

Gunakan model/tabel/controller existing.

Tampilkan:

- Total Konsultasi Gratis
- berdasarkan periode
- konsultasi terbaru
- status jika tersedia
- mobil yang diminati jika product_id tersedia

Jika Konsultasi Gratis tidak mempunyai product_id:

JANGAN membuat relationship palsu.

================================================== 18. MOBIL PALING DIMINATI
=========================

Buat section:

MOBIL PALING DIMINATI

Jika struktur database memungkinkan, gabungkan:

Inquiry
Test Drive
Konsultasi Gratis

berdasarkan product_id.

Contoh:

Suzuki Fronx

Inquiry: 4
Test Drive: 3
Konsultasi: 5
Total: 12

Tampilkan ranking.

Gunakan progress bar atau visual ranking.

Jika salah satu form tidak memiliki product_id, gunakan hanya data yang tersedia.

================================================== 19. LEADS TERBARU
=================

Buat section:

LEADS TERBARU

Gunakan data existing.

Tampilkan jika tersedia:

- avatar/inisial
- Nama
- Jenis Lead
- Mobil
- Kota
- Budget
- Payment Type
- Status
- Waktu

Contoh:

RP
Rizky Pratama
Konsultasi Gratis
Suzuki Fronx
Medan
New
5 menit lalu

Gunakan DataTables jika sudah tersedia.

Jika halaman detail existing tersedia, gunakan link tersebut.

================================================== 20. TEST DRIVE TERBARU
======================

Jika layout memungkinkan, tampilkan:

TEST DRIVE TERBARU

Tampilkan:

- Nama
- Mobil
- Tanggal
- Status
- waktu dibuat

Gunakan data existing.

================================================== 21. KONSULTASI TERBARU
======================

Jika model/tabel tersedia:

KONSULTASI GRATIS TERBARU

Tampilkan:

- Nama
- Mobil
- Kota
- Status
- waktu

================================================== 22. QUICK ACTION
================

Jika route existing tersedia, boleh tambahkan Quick Action:

- Tambah Mobil
- Lihat Leads
- Test Drive
- Konsultasi

Jangan membuat route dummy.

Gunakan route existing.

================================================== 23. DESAIN UI/UX
================

Dashboard harus terlihat:

ELEGAN
MODERN
BERSIH
PROFESIONAL
RAPI
MENARIK
INTERAKTIF
RINGAN

Dashboard harus terasa seperti dashboard profesional untuk sales mobil.

Bukan sekadar admin panel dengan tabel dan angka.

Tetap menggunakan:

Stisla
Bootstrap 4

Jangan mengganti template.

================================================== 24. KPI CARD DESIGN
===================

Card KPI:

- border radius modern
- shadow halus
- icon
- angka besar
- label jelas
- spacing rapi
- hover effect

Gunakan icon library yang sudah tersedia.

Contoh icon jika Font Awesome sudah tersedia:

Pengunjung:
fa-users

Page Views:
fa-eye

Total Leads:
fa-user-plus

Test Drive:
fa-car

Konsultasi:
fa-comments

Jangan menambahkan icon library baru jika tidak diperlukan.

================================================== 25. COUNT-UP ANIMATION
======================

Saat dashboard pertama kali dibuka:

angka KPI menggunakan count-up animation.

Contoh:

0
100
300
800
1.284

Durasi sekitar:

500–1000ms

Animasi harus halus.

Jika data diperbarui melalui filter, animasikan perubahan angka dengan ringan.

Jangan menggunakan library besar hanya untuk count-up.

================================================== 26. MICRO INTERACTION
=====================

Tambahkan micro-interaction:

- card sedikit naik ketika hover
- icon transition
- button hover
- table row hover
- progress animation
- chart animation
- smooth filter interaction

Gunakan CSS transition sederhana.

Jangan berlebihan.

================================================== 27. FILTER UI
=============

Filter periode harus terlihat elegan.

Jika memungkinkan gunakan button group/segmented control.

Contoh:

Hari Ini
7 Hari
30 Hari
Bulan Ini
3 Bulan
Tahun Ini

State aktif harus jelas.

Ketika user memilih filter:

1. tampilkan loading
2. disable filter sementara
3. update KPI
4. update chart
5. update statistik
6. aktifkan kembali filter

================================================== 28. LOADING STATE
=================

Gunakan loading state yang elegan.

Prioritas:

- skeleton
- shimmer
- spinner kecil

Jangan gunakan spinner besar yang mengganggu.

Saat AJAX/request berjalan:

- user tidak dapat melakukan klik berulang
- tampilkan loading
- setelah selesai loading hilang

Jika error:

"Gagal memuat data. Silakan coba lagi."

Jangan tampilkan stack trace.

================================================== 29. CHART ANIMATION
===================

Chart memiliki animasi saat pertama kali ditampilkan.

Ketika filter berubah:

Update chart secara smooth.

Hindari chart berkedip.

Jangan menghancurkan dan membuat ulang chart secara tidak perlu jika dataset dapat diperbarui.

================================================== 30. MOBIL TERPOPULER UI
=======================

Tampilkan ranking:

01
02
03
04
05

Dengan:

- thumbnail
- nama mobil
- views
- progress

Progress bar dianimasikan saat tampil.

Jika image tidak tersedia:

gunakan placeholder.

================================================== 31. LEADS UI
============

Gunakan badge yang konsisten.

Jenis:

Inquiry
Test Drive
Konsultasi Gratis

Status gunakan status existing.

Gunakan avatar/inisial untuk membuat tabel lebih mudah dibaca.

Tambahkan row hover.

Jangan terlalu banyak warna.

================================================== 32. RELATIVE TIME
=================

Jika sesuai, tampilkan waktu relatif:

Baru saja
5 menit lalu
1 jam lalu
Kemarin
2 hari lalu

Gunakan timestamp sebenarnya.

Jangan mengubah timestamp database.

================================================== 33. EMPTY STATE
===============

Setiap widget harus memiliki empty state.

Contoh:

Belum ada data pengunjung pada periode ini.

Belum ada Inquiry.

Belum ada Test Drive.

Belum ada Konsultasi Gratis.

Belum ada data mobil populer.

Gunakan icon kecil dan layout yang rapi.

================================================== 34. RESPONSIVE
==============

Dashboard harus responsive:

Desktop
Laptop
Tablet
Mobile

Desktop:

KPI beberapa kolom.

Tablet:

2–3 kolom.

Mobile:

1–2 kolom.

Chart responsive.

Table dapat horizontal scroll jika diperlukan.

Jangan sampai layout rusak.

================================================== 35. PERFORMANCE
===============

Project kemungkinan berjalan di shared hosting.

Performance adalah prioritas.

Hindari:

- N+1
- query dalam loop
- mengambil seluruh visitor ke PHP
- menghitung data besar menggunakan Collection jika SQL bisa melakukannya
- AJAX berlebihan
- query yang sama berkali-kali

Gunakan:

- COUNT
- GROUP BY
- eager loading
- index
- cache jika diperlukan

Visitor tracking harus ringan.

Jangan membuat setiap page request menjadi proses berat.

================================================== 36. DATABASE
============

Periksa database existing sebelum migration.

Jangan membuat tabel duplikat.

Jangan membuat model duplikat.

Jangan membuat relationship duplikat.

Jika visitor package membutuhkan migration, gunakan migration yang kompatibel.

Tambahkan index jika diperlukan.

JANGAN:

DROP TABLE
TRUNCATE
DROP COLUMN

Jangan menghapus data existing.

================================================== 37. SECURITY
============

Dashboard mengikuti authentication dan authorization existing.

Jangan membuat login baru.

Validasi filter tanggal.

Jangan menerima raw SQL dari request.

Jangan expose informasi sensitif visitor.

================================================== 38. JAVASCRIPT
==============

Gunakan JavaScript existing.

Jika project menggunakan Vite, ikuti struktur existing.

Gunakan Chart.js jika tersedia.

Jangan menambahkan dependency baru tanpa kebutuhan.

Jika AJAX digunakan:

- loading
- error handling
- disable interaction
- update data

Pastikan tidak ada JavaScript error.

================================================== 39. ANIMASI PERFORMANCE
=======================

Animasi harus ringan.

Prioritas:

- opacity
- transform
- CSS transition

Durasi sekitar:

200–700ms

Hindari:

- animasi berulang
- bounce berlebihan
- parallax
- animasi berat
- efek yang mengganggu membaca data

Dashboard harus terasa premium tetapi tetap cepat.

================================================== 40. NO DUMMY DATA
=================

Dilarang menggunakan angka dummy production.

Jangan:

visitor = 1284
page_views = 3842
leads = 42

Semua harus berasal dari database.

================================================== 41. NO OVER ENGINEERING
=======================

Gunakan struktur Laravel sederhana.

Jangan membuat:

- repository pattern tanpa kebutuhan
- service berlapis tanpa kebutuhan
- controller berlebihan
- AJAX berlebihan
- dependency besar

Ikuti gaya coding existing project.

================================================== 42. URUTAN IMPLEMENTASI
=======================

Kerjakan dengan urutan:

1. Inspect project.
2. Identifikasi dashboard existing.
3. Identifikasi Product/Mobil.
4. Identifikasi Inquiry.
5. Identifikasi Test Drive.
6. Identifikasi Konsultasi Gratis.
7. Identifikasi visitor tracking existing.
8. Pilih solusi visitor analytics.
9. Implementasikan visitor tracking.
10. Implementasikan dashboard layout.
11. Implementasikan KPI.
12. Implementasikan filter periode.
13. Implementasikan visitor/page view chart.
14. Implementasikan Mobil Terpopuler.
15. Implementasikan Total Leads.
16. Implementasikan Jenis Leads.
17. Implementasikan Test Drive.
18. Implementasikan Konsultasi Gratis.
19. Implementasikan Mobil Paling Diminati.
20. Implementasikan Leads Terbaru.
21. Tambahkan UI animation.
22. Tambahkan loading state.
23. Optimalkan query.
24. Test.

================================================== 43. JANGAN BERHENTI PADA ANALISIS
=================================

Setelah melakukan inspection:

LANGSUNG IMPLEMENTASIKAN.

Jangan hanya memberikan rekomendasi.

Buat perubahan pada project secara langsung.

Jika menemukan implementasi existing yang sudah bagus:

gunakan dan sempurnakan.

Jika menemukan fitur existing yang tidak diperlukan untuk dashboard:

jangan ubah.

================================================== 44. VALIDASI AKHIR
==================

Setelah selesai, periksa:

- route dashboard
- controller
- Blade
- model
- migration
- query
- JavaScript
- browser console
- Laravel log

Pastikan:

- dashboard dapat dibuka
- visitor tercatat
- page view tercatat
- unique visitor bekerja
- chart tampil
- filter Hari Ini bekerja
- filter 7 Hari bekerja
- filter 30 Hari bekerja
- filter Bulan Ini bekerja
- filter 3 Bulan bekerja
- filter Tahun Ini bekerja
- Mobil Terpopuler bekerja
- Total Leads benar
- Inquiry tampil
- Test Drive tampil
- Konsultasi Gratis tampil
- Mobil Paling Diminati bekerja
- Leads Terbaru tampil
- loading bekerja
- animation bekerja
- empty state bekerja
- responsive bekerja
- tidak ada JavaScript error
- tidak ada N+1 query yang tidak diperlukan

================================================== 45. FINAL REPORT
================

Setelah implementasi selesai, berikan laporan singkat.

VISITOR ANALYTICS

- solusi/library
- versi
- alasan pemilihan
- compatibility

FILES CREATED

Daftar file baru.

FILES MODIFIED

Daftar file yang diubah.

DATABASE

- migration
- table
- index
- perubahan database

DASHBOARD FEATURES

Daftar fitur yang berhasil dibuat.

TESTING

- hasil testing
- error jika ada
- hal yang masih perlu diperhatikan.

==================================================
HASIL AKHIR YANG DIHARAPKAN
===========================

Saya ingin dashboard yang ketika dibuka langsung terasa:

ELEGAN
RAPI
MODERN
PROFESIONAL
MENARIK
INTERAKTIF
RINGAN

Tetapi tetap fokus pada informasi.

Dalam beberapa detik sales harus dapat mengetahui:

BERAPA PENGUNJUNG?

BERAPA PAGE VIEWS?

MOBIL APA YANG PALING BANYAK DILIHAT?

BERAPA TOTAL LEADS?

BERAPA INQUIRY?

BERAPA TEST DRIVE?

BERAPA KONSULTASI GRATIS?

MOBIL APA YANG PALING DIMINATI?

SIAPA LEADS TERBARU?

Prioritas:

VISITOR
→ PAGE VIEW
→ PRODUCT INTEREST
→ LEADS
→ TEST DRIVE
→ KONSULTASI GRATIS

==================================================
ATURAN PALING PENTING
=====================

WEBSITE SUDAH ADA.

JANGAN REBUILD WEBSITE.

JANGAN MENGUBAH FRONTEND PUBLIK.

JANGAN UPGRADE LARAVEL.

JANGAN UPGRADE PHP.

JANGAN GANTI STISLA.

JANGAN MEMBUAT E-COMMERCE.

JANGAN MEMBUAT DATA DUMMY.

JANGAN MENGHAPUS DATA.

INSPECT DAHULU.

SETELAH MEMAHAMI PROJECT, LANGSUNG KERJAKAN IMPLEMENTASINYA.

HASIL AKHIR HARUS MERUPAKAN DASHBOARD ADMIN SALES MOBIL YANG ELEGAN, RAPI, INTERAKTIF, RESPONSIVE, MEMILIKI ANIMASI RINGAN, DAN MENGGUNAKAN DATA NYATA DARI PROJECT.
