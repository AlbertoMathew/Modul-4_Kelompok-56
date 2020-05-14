<?php
session_start();
require 'Standard.php';
require 'Deluxe.php';
require 'PresidentSuite.php';
require_once 'Hotel.php';

if (isset($_POST['submitawal'])) {
    switch ($_POST['kelas']) {
        case "Standard":
            $class = new Standard(); // Instansiasi object Standard
            break;
        case "Deluxe":
            $class = new Deluxe(); // Instansiasi object Deluxe
            break;
        case "President Suite":
            $class = new PresidenSuite(); // Instansiasi object President Suite
            break;
        default:
            session_destroy(); // Jika tidak ada inputan terhadap form kelas hotel, maka putuskan semua session yang telah diset.
            echo "  <script>
                        alert('Silahkan pilih kelasnya terlebih dahulu untuk melanjutkan pemesanan hotel')
                        window.location.href = '.';
                    </script>"; // Munculkan pesan dan arahkan page ke . alias index.php
            break;
    }
    $class->PenanggungJawab();
}

// Menjalankan method penanggungjawab()
if (isset($_GET['setujufasilitas'])) { // Jika sudah tombol button bernama setujufasilitas diklik, maka jalankan statement berikut
    if ($_GET['jumlahanggota'] == 0) { // Jika data jumlahanggota yang dikirim melalui method GET di URL == (sama dengan) 0, maka pindahkan ke index.php
        header('Location:   .');
    } else if ($_GET['jumlahanggota'] == 1) { // Dan apabila jika data jumlahanggota yang dikirim melalui method GET di URL == (sama dengan) 1, maka jalankan statement berikut
        Hotel::setJumlahanggota(1); // Set value dari variable super global session array berasosiatifkan jumlahanggota = 1
        header('Location: .?selesai=1'); // Pindahkan ke index.php dan beri data "selesai" = 1 melalui method GET
    } else {
        Hotel::setJumlahanggota($_GET['jumlahanggota']); // Selain dari if di atas maka set value dari variable super global session array berasosiatifkan jumlahanggota = jumlahanggota yang didapatkan dari URI melalui method GET
    }
}

if (isset($_GET['tidaksetuju'])) { // Jika sudah tombol button bernama tidaksetuju diklik, maka jalankan statement berikut
    Hotel::logout();
}

if (isset($_POST['submitdata'])) { // Jika sudah tombol button bernama submitdata di klik, maka jalankan statement berikut
    Hotel::PenghuniKamar();
}

if (isset($_GET['end'])) { // Jika sudah tombol button bernama end di klik, maka jalankan statement berikut
    Hotel::logout();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Hotel</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="image/images.jpg">
    <script src="js/bootstrap.min.js"></script>
    <style>
        label {
            font-weight: 500;
        }
    </style>
</head>

<!-- MENU PALING AWAL -->
<?php if (!isset($_SESSION['fasilitas'])) : ?>

    <body style="background-color: #f1f1f1"><br>
        <div class="col-md-6 mx-auto" style="background-color: white; box-shadow: 0px 2px 5px #999; padding: 25px; border-radius: 8px;">
            <h1 style="text-align: center;">Selamat Datang di Hotel Alberto </h1>
            <center><img style="border-radius: 50%; max-width: 125px; margin-top: 5px; margin-bottom: -20px;" src="image/images.jpg" alt=""></center>
            <form action="" method="post" autocomplete="off">
                <div class="form-group mt-5">
                    <label for="namalengkap">Nama Lengkap (*)</label>
                    <input class="form-control" type="text" id="namalengkap" name="namalengkap" required>
                </div>
                <div class="form-group">
                    <label for="email">Email (*)</label>
                    <input class="form-control" type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="nik">Nomor KTP/NIK (*)</label>
                    <input class="form-control" type="number" id="nik" name="nik" required>
                </div>
                <div class="form-group">
                    <label for="nohp">Nomor Ponsel (*)</label>
                    <input class="form-control" type="number" id="nohp" name="nohp" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Pilihlah Kelas yang Diinginkan (*)</label>
                    <select class="form-control" name="kelas" id="kelas" required>
                        <option hidden disabled selected value>Select an Option</option>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="President Suite">President Suite</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hari">Hari (*)</label>
                    <input class="form-control" type="number" id="hari" name="hari" required>
                </div>
                <p style="font-size: 11px; font-weight: 500; margin-top: -15px">Silahkan isi data-data berikut dengan lengkap dan benar</p>
                <p style="font-size: 11px; font-weight: 500; color: red; margin-top: -15px">(*) Wajib Diisi</p>
                <button class="btn btn-primary" type="submit" name="submitawal">Submit</button>
            </form>
        </div><br>
    </body>
<?php endif; ?>

<!-- MENU KEDUA ALIAS MUNCUL BERAPA ORANG ANGGOTA DAN FASILITAS YANG ADA  -->
<?php if (isset($_SESSION['fasilitas']) && !isset($_SESSION['informasi']['jumlahanggota'])) : ?>

    <body style="background-color: #f1f1f1"><br>
        <div class="col-md-8 mx-auto" style="background-color: white; box-shadow: 0px 2px 5px #999; padding: 25px; border-radius: 8px;">
            <h3 style="text-align: center;">Fasilitas yang anda dapatkan nantinya</h3><br>
            <table class="table table-sm table-borderless">
                <tr>
                    <td style="font-weight: 500;">Kelas</td>
                    <td><?= Hotel::getNamakelas(); ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Luas</td>
                    <td><?= Hotel::getLuas(); ?> m<sup>2</sup></td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Kasur</td>
                    <td><?= Hotel::getKasur(); ?> buah</td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">TV</td>
                    <td><?= Hotel::getTv(); ?> buah</td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Harga</td>
                    <td><?= Hotel::getHarga(); ?>/Malam</td>
                </tr>
            </table>
            <form action="" method="get">
                <div class="form-group">
                    <label for="jumlahanggota">Jumlah Penghuni Kamar Hotel</label>
                    <input class="form-control" type="number" id="jumlahanggota" name="jumlahanggota" required>
                </div>
                <button class="btn btn-primary" type="submit" name="setujufasilitas">Setuju</button>
                <button class="btn btn-danger" type="submit" name="tidaksetuju">Batal</button>
            </form>
        </div><br>
    </body>
<?php endif; ?>

<!-- MENU INPUT PENGHUNI -->
<?php if (isset($_SESSION['informasi']['jumlahanggota']) && !isset($_GET['selesai'])) : ?>

    <body style="background-color: #f1f1f1"><br>
        <form action="" method="post">
            <div class="col-md-6 mx-auto" style="background-color: white; box-shadow: 0px 2px 10px #999; padding: 25px; border-radius: 8px;">
                <?php for ($i = 1; $i < Hotel::getJumlahanggota(); $i++) : ?>
                    <?php $j = $i + 1; ?>
                    <div style="box-shadow: 0px 1px 5px blue; border-radius: 6px; padding: 25px; border: 1px solid #f2f2f2;">
                        <h4 style="text-align: center;">Penghuni <?= $j ?></h4>
                        <div class="form-group">
                            <label for="namalengkap<?= $j ?>">Nama Lengkap</label>
                            <input class="form-control" type="text" id="namalengkap<?= $j ?>" name="namalengkap<?= $j ?>">
                        </div>
                        <div class="form-group">
                            <label for="nik<?= $j ?>">Nomor KTP/NIK</label>
                            <input class="form-control" type="number" id="nik<?= $j ?>" name="nik<?= $j ?>">
                        </div>
                        <div class="form-group">
                            <label for="nohp<?= $j ?>">Nomor Ponsel</label>
                            <input class="form-control" type="number" id="nohp<?= $j ?>" name="nohp<?= $j ?>">
                        </div>
                    </div><br>
                <?php endfor; ?>
                <button class="btn btn-primary" type="submit" name="submitdata">Submit</button>
            </div>
        </form><br>
    </body>
<?php endif; ?>

<!-- MENU TERAKHIR -->
<?php if (isset($_GET['selesai'])) : ?>

    <body style="background-color: #f2f2f2;">
        <div class="jumbotron bg-dark">
            <img style="border-radius: 50%; width: 150px; height: auto; display: inline-block; float: left; margin-right: 20px;" src="image/images.jpg" alt="">
            <h1 style="margin-top: 15px; margin-left: 30px; color: white;">Hotel Alberto</h1>
            <p style="color: white;">Hotel terbaik sepanjang sejarah Indonesia</p>
        </div>
        <div class="container" style="background-color: white; margin-top: -32px; box-shadow: 0px 2px 10px #999">
            <?php
            $jumlah = count($_SESSION['username']); // HITUNG JUMLAH PANJANG ARRAY di variable super global $_SESSION yang berindex assosiatif "username" 
            ?>
            <?php for ($a = 0; $a < $jumlah; $a++) : // PERULANGAN FOR DENGAN KONDISI $A = 0, APABILA $A LEBIH KECIL DARI $JUMLAH MAKA LAKUKAN STATEMENT DAN LAKUKAN INCREMENT 
            ?>
                <?php $b = $a + 1; ?>
                <?php if ($a == 0) : // JIKA A = 0 ALIAS SI PENANGGUNG JAWAB, MAKA LAKUKAN STATEMENT BERIKUT 
                ?>
                    <div class="col"><br>
                        <h3 style="text-align: center;">Penanggung Jawab Kamar</h3><br>
                        <center>
                            <div class="col-md-10">
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="font-weight: 500;">Nama Lengkap</td>
                                        <td><?= Hotel::getNamaPenanggung(); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;">Email</td>
                                        <td><?= Hotel::getEmailPenanggung();; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;">Nomor NIK/KTP</td>
                                        <td><?= Hotel::getNikPenanggung();; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;">Nomor Ponsel</td>
                                        <td><?= Hotel::getNohpPenanggung(); ?></td>
                                    </tr>
                                </table>
                            </div>
                    </div><br>
                    <hr>
                <?php else : // SELAIN ITU BERARTI PENGHUNI KAMAR SAJA
                ?>
                    <div class="col">
                        <h3 style="text-align: center;">Penghuni <?= $b ?></h3><br>
                        <center>
                            <div class="col-md-10">
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="font-weight: 500;">Nama Lengkap</td>
                                        <td><?= Hotel::getNamaPenghuni($a); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;">Nomor NIK/KTP</td>
                                        <td><?= Hotel::getNikPenghuni($a); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 500;">Nomor Ponsel</td>
                                        <td><?= Hotel::getNohpPenghuni($a); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                    </div><br>
                    <hr>
                <?php endif; ?>
            <?php endfor; ?>
            <div class="col">
                <h3 style="text-align: center;">Fasilitas</h3><br>
                <center>
                    <div class="col-md-10">
                        <table class="table table-borderless">
                            <tr>
                                <td style="font-weight: 500;">Kelas</td>
                                <td><?= Hotel::getNamakelas(); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;">Luas</td>
                                <td><?= Hotel::getLuas(); ?> m<sup>2</sup></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;">Kasur</td>
                                <td><?= Hotel::getKasur(); ?> buah</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;">TV</td>
                                <td><?= Hotel::getTv(); ?> buah</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;">Harga</td>
                                <td><?= Hotel::getHarga(); ?>/Malam</td>
                            </tr>
                        </table>
                    </div>
                </center>
            </div><br>
            <hr>
            <div class="col">
                <h3 style="text-align: center;">Informasi Kamar</h3><br>
                <center>
                    <div class="col-md-10">
                        <table class="table table-borderless">
                            <tr>
                                <td style="font-weight: 500;">Floor</td>
                                <td><?= Hotel::getLantai(); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;">Nomor Kamar</td>
                                <td><?= Hotel::getKamar() ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;">Hari</td>
                                <td><?= Hotel::getHari() ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;">Biaya</td>
                                <td><?= Hotel::getTotalharga() ?></td>
                            </tr>
                        </table>
                    </div>
                </center>
            </div><br><br>
            <form action="" method="get">
                <button style="width: 100%" class="btn btn-primary mx-auto" type="submit" name="end">Selesai</button><br><br>
            </form>
        </div>
    </body>
<?php endif; ?>

</html>