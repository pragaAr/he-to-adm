<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    html {
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      margin-top: 50px;
      margin-left: 50px;
      margin-right: 50px;
    }

    .img-logo {
      position: absolute;
      width: 92px;
      height: 60px;
    }

    .company-name {
      margin-left: 110px;
    }

    .company-name h4 {
      font-size: 24px;
      margin-top: -3px;
    }

    .company-name p {
      margin-top: -25px;
      font-size: 12px;
    }

    .intro {
      margin-top: 30px;
    }

    .intro:after {
      content: "";
      display: table;
      clear: both;
    }

    .order-detail {
      float: left;
      width: 50%;
    }

    .order-number {
      width: 450px;
      font-size: 14px;
      font-weight: bold;
    }

    .cust-data {
      font-size: 14px;
      width: 250px;
      word-wrap: break-word;
    }

    .body-order p {
      font-size: 14px;
    }

    footer {
      float: right;
      margin-top: 20px;
    }

    footer .ttd {
      text-align: center;
    }

    footer .ttd p {
      font-size: 14px;
    }

    footer .ttd h4 {
      font-size: 16px;
    }
  </style>

</head>

<body>
  <div>
    <img src="<?= base_url('assets/dist/img/logo-red.png') ?>" class="img-logo">
    <div class="company-name">
      <h4> PT. HIRA ADYA NARANATA</h4>
      <p>
        Komplek Pangkalan Truk Genuk Blok AA No.35<br>
        Jl. Raya Kaligawe Km. 5,6 Semarang Telp./Fax. (024) 6582208
      </p>
    </div>
  </div>
  <hr>
  <section class="intro">
    <div class="order-detail order-number">
      <p>D.O : No. <?= strtoupper($detail->no_order) ?></p>
    </div>
    <div class="order-detail cust-data">
      <p>Semarang, <?= date('d-F-Y', strtotime($detail->dateAdd)) ?></p>
      <p>Kepada Yth :</p>
      <p><?= strtoupper($detail->nama_cust) ?></p>
      <p>Di, <?= ucwords($detail->alamat_asal) ?></p>
    </div>
  </section>

  <section class="body-order">
    <p>Dengan hormat,</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bersama ini, truk kami dengan nomor polisi : <?= strtoupper($detail->platno) ?></p>
    <p>Nama Pengemudi dan Kernet : <?= strtoupper($detail->supir) ?> dan - </p>
    <p>Mohon diberi muatan berupa : <?= strtoupper($detail->jenis_muatan) ?></p>
    <p>Dengan tujuan ke : <?= ucwords($detail->alamat_tujuan) ?></p>
  </section>

  <footer>
    <div class="ttd">
      <p>Hormat kami,</p>
      <h4> PT. HIRA ADYA NARANATA</h4>
    </div>
  </footer>

</body>

</html>