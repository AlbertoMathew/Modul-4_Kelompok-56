<?php
class Hotel
{
    // Constructor
    public function  __construct($namakelas, $luas, $kasur, $tv, $harga)
    {
        $this->setNamakelas($namakelas);
        $this->setLuas($luas);
        $this->setKasur($kasur);
        $this->setTv($tv);
        $this->setHarga($harga, 1);
    }

    // Setter and Getter Fasilitas
    public function setNamakelas($data)
    {
        $_SESSION['fasilitas']['namakelas'] = $data;
    }

    public function getNamakelas()
    {
        return $_SESSION['fasilitas']['namakelas'];
    }

    public function setLuas($data)
    {
        $_SESSION['fasilitas']['luas'] = $data;
    }

    public function getLuas()
    {
        return $_SESSION['fasilitas']['luas'];
    }

    public function setKasur($data)
    {
        $_SESSION['fasilitas']['kasur'] = $data;
    }

    public function getKasur()
    {
        return $_SESSION['fasilitas']['kasur'];
    }

    public function setTv($data)
    {
        $_SESSION['fasilitas']['tv'] = $data;
    }

    public function getTv()
    {
        return $_SESSION['fasilitas']['tv'];
    }

    // Setter and Getter Penanggung Jawab
    public function setNamaPenanggung($data)
    {
        $_SESSION['username'][0]['namalengkap'] = $data;
    }

    public function getNamaPenanggung()
    {
        return $_SESSION['username'][0]['namalengkap'];
    }

    public function setEmailPenanggung($data)
    {
        $_SESSION['username'][0]['email'] = $data;
    }

    public function getEmailPenanggung()
    {
        return $_SESSION['username'][0]['email'];
    }

    public function setNikPenanggung($data)
    {
        $_SESSION['username'][0]['nik'] = $data;
    }

    public function getNikPenanggung()
    {
        return $_SESSION['username'][0]['nik'];
    }

    public function setNohpPenanggung($data)
    {
        $_SESSION['username'][0]['nohp'] = $data;
    }

    public function getNohpPenanggung()
    {
        return $_SESSION['username'][0]['nohp'];
    }

    // Setter and Getter Informasi Kamar
    public function setHari($data)
    {
        $_SESSION['informasi']['hari'] = $data;
    }

    public function getHari()
    {
        return $_SESSION['informasi']['hari'];
    }

    public function setHarga($data, $data2)
    {
        if ($data2 == 1) {
            $_SESSION['fasilitas']['harga'] = $data;
        } else if ($data2 == 2) {
            $_SESSION['fasilitas']['harga'] = $this->rupiah($data);
        }
    }

    public function getHarga()
    {
        return $_SESSION['fasilitas']['harga'];
    }

    public function setTotalharga($data)
    {
        $_SESSION['informasi']['totalharga'] = $this->rupiah($data);
    }

    public function getTotalharga()
    {
        return $_SESSION['informasi']['totalharga'];
    }

    public function setKamar($data)
    {
        $_SESSION['informasi']['kamar'] = $data;
    }

    public function getKamar()
    {
        return $_SESSION['informasi']['kamar'];
    }

    public function setLantai($data)
    {
        $_SESSION['informasi']['lantai'] = substr($data, 0, 1);
    }

    public function getLantai()
    {
        return $_SESSION['informasi']['lantai'];
    }

    public function setJumlahanggota($data)
    {
        $_SESSION['informasi']['jumlahanggota'] = $data;
    }

    public function getJumlahanggota()
    {
        return $_SESSION['informasi']['jumlahanggota'];
    }

    // Setter and Getter Penghuni
    public function setNamaPenghuni($data, $i)
    {
        $_SESSION['username'][$i]['namalengkap'] = $data;
    }

    public function getNamaPenghuni($i)
    {
        return $_SESSION['username'][$i]['namalengkap'];
    }

    public function setNikPenghuni($data, $i)
    {
        $_SESSION['username'][$i]['nik'] = $data;
    }

    public function getNikPenghuni($i)
    {
        return $_SESSION['username'][$i]['nik'];
    }

    public function setNohpPenghuni($data, $i)
    {
        $_SESSION['username'][$i]['nohp'] = $data;
    }

    public function getNohpPenghuni($i)
    {
        return $_SESSION['username'][$i]['nohp'];
    }

    // Function and Method
    public function PenanggungJawab()
    {
        $this->setNamaPenanggung($_POST['namalengkap']);
        $this->setEmailPenanggung($_POST['email']);
        $this->setNikPenanggung($_POST['nik']);
        $this->setNohpPenanggung($_POST['nohp']);
        $this->setEmailPenanggung($_POST['email']);
        $this->setHari($_POST['hari']);
        $this->setTotalharga($this->hargaTotal());
        $this->setHarga($this->getHarga(), 2);
        $this->setKamar(rand(101, 300));
        $this->setLantai($this->getKamar());
    }

    public function PenghuniKamar()
    {
        $i = 1;
        $jumlahanggota = Hotel::getJumlahanggota();
        while ($i < $jumlahanggota) { // Perulangan for dengan kondisi variable i = 1, jika variable i lebih kecil daripada variable jumlahanggotas, maka jalankan statement, setelah itu incrementlah variable i
            $j = $i + 1; // Variable j berisikan nilai i yang telah ditambah dengan 1
            Hotel::setNamaPenghuni($_POST["namalengkap" . $j], $i);
            Hotel::setNikPenghuni($_POST["nik" . $j], $i);
            Hotel::setNohpPenghuni($_POST["nohp" . $j], $i);
            $i++;
        }
        header('Location: .?selesai=1'); // Pindahkan ke index.php dan beri data "selesai" = 1 melalui method GET
    }

    public function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }

    public function hargaTotal()
    {
        return $this->getHarga() * $this->getHari();
    }

    public function logout()
    {
        session_unset(); // Lepas semua data SESSION
        session_destroy(); // Hancurkan seluruh isi SESSION
        header('Location: .'); // Arahkan page ke halaman index.php
        session_unset(); // Diulangin kembali agar menghindari kesalahan sistem atau bug sistem
        session_destroy();
        header('Location: .');
    }
}
