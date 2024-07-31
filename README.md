# Eigen Backend Test

`demo url: ` [https://eigen-backend.acielana.my.id](https://eigen-backend.acielana.my.id)
`url login: ` [https://eigen-backend.acielana.my.id/login](https://eigen-backend.acielana.my.id/login)

## Tech Stack
1. Laravel 10
2. PHP v8.2
3. Composer v2.7.1

## Username Password Role
| Username | Password |
| ----------- | ----------- |
| admin@gmail.com | password |

## Instalasi
1. Buka Terminal. (ex: git bash, cmd, dll)
2. Clone repository ini menggunakan perintah `git clone https://github.com/ariaschecter/eigen-backend-test.git`
3. Change direktory menggunakan perintah `cd eigen-backend-test`
4. Masukkan perintah `composer install` untuk menginstall data vendor
5. Masukkan perintah `cp .env.example .env` untuk menyalin file `.env`
6. Masukkan perintah `php artisan key:generate` untuk mengenerate APP_KEY
7. Masukkan perintah `php artisan migrate` untuk melakukan migrasi database
8. Jika terdapat inputan di terminal tulis `yes` kemudian enter
9. Masukkan perintah `php artisan db:seed` agar DatabaseSeeder dijalankan dan membuat data di database
10. Masukkan perintah `php artisan l5-swagger:generate` agar Dokumentasi API dapat di generate
11. buka halaman `{url}/api/documentation` untuk melihat dokumentasi API
12. Masukkan perintah `php artisan test` untuk menjalankan test yang ada di folder tests 
