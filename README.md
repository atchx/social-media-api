# Social Media API

API sosial media sederhana menggunakan framework Laravel.

## Deskripsi

Proyek ini adalah implementasi sederhana dari API sosial media yang dibangun menggunakan Laravel. Proyek ini menyediakan beberapa endpoint untuk manajemen pengguna, posting, dan interaksi dengan posting, seperti menyukai dan mengomentari.

## Fitur

- Manajemen pengguna: Registrasi, login, update profil, mencari pengguna, dan lain-lain.
- Posting: Menambahkan posting, mengedit posting, menyukai posting, mengomentari posting, dan lain-lain.
- Interaksi: Mengikuti dan berhenti mengikuti pengguna lain.

## Persyaratan

- PHP >= 7.4
- Composer
- Laravel
- MySQL atau database lain yang didukung oleh Laravel
- Postman (untuk pengujian dan dokumentasi API)

## Instalasi

1. Clone repositori ini:

    ```bash
    git clone https://github.com/username/social-media-api.git
    ```

2. Masuk ke direktori proyek:

    ```bash
    cd social-media-api
    ```

3. Instal dependensi menggunakan Composer:

    ```bash
    composer install
    ```

4. Salin file `.env.example` menjadi `.env` dan konfigurasikan pengaturan database Anda:

    ```bash
    cp .env.example .env
    ```

5. Buatlah kunci aplikasi:

    ```bash
    php artisan key:generate
    ```

6. Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di database:

    ```bash
    php artisan migrate
    ```

7. (Opsional) Jalankan seeder untuk mengisi database dengan data contoh:

    ```bash
    php artisan db:seed
    ```

8. Jalankan server Laravel:

    ```bash
    php artisan serve
    ```

## Penggunaan

Untuk menggunakan API, Anda dapat menggunakan Postman atau alat serupa. Impor koleksi Postman dari file `postman_collection.json` untuk mendapatkan akses ke semua endpoint API.

## Kontribusi

Kontribusi selalu diterima! Silakan buka *issue* atau kirimkan *pull request* dengan perbaikan atau fitur baru.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

Pastikan untuk mengganti bagian "username" pada URL git Anda dan menyertakan informasi lain yang relevan sesuai kebutuhan proyek Anda. Juga, pastikan untuk menyertakan informasi spesifik seperti cara penggunaan, persyaratan, dan instruksi instalasi yang dibutuhkan untuk menjalankan proyek dengan benar.
