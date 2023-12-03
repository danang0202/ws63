## Cara instalasi
Cara instalasi cukup mudah. Yang perlu dipastikan adalah bahwa di perangkat sudah terinstall aplikasi [composer](https://getcomposer.org/download/) . Kalau sudah, tinggal pergi ke direktori penyimpanan yang diinginkan kemudian melakukan cloning
```
git clone <link github ini>
```
Kemudian, tinggal ketikkan
```
composer install
```
Web Service sudah bisa digunakan.

## Yang perlu diperhatikan
Tiga file yang harus diubah ketika mengganti kuesioner listing di CAPI adalah: (misalkan mengganti kuesioner listing riset 1) `ListingR1`, `RumahTanggaR1`, dan `RutaModelR1`. Itu adalah tiga file yang utama yang harus diubah. Namun, sangat ditperbolehkan jika ingin mengubah file lainnya juga untuk menyesuaikan kebutuhan. Misalnya, di angkatan 62 ada perubahan file `SampelModelR12` (menambah kolom riset).

Versi PHP minimum: 8.1

## Yang perlu dilakukan ke depannya
- [ ] Merapikan file, dalam artian, menghapus file yang tidak diperlukan.
- [ ] Menyesuaikan penamaan file, misalnya `isKoor` jadi `isPML`
- [ ] Menyesuaikan variabel-variabel agar sesuai dengan yang ada di databas
