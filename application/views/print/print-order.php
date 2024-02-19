<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    body {
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
      margin-top: 25px;
      margin-left: 50px;
      margin-right: 50px;
    }

    .fw-bold {
      font-weight: bold;
    }

    .f-upper {
      text-transform: uppercase;
    }

    .img-logo {
      position: absolute;
      width: 82px;
      height: 50px;
    }

    .company-name {
      margin-left: 120px;
    }

    .company-name h4 {
      font-size: 20px;
      margin-top: -3px;
    }

    .company-name p {
      margin-top: -25px;
      font-size: 12px;
    }

    .intro {
      margin-top: 25px;
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
      width: 350px;
      font-size: 14px;
      font-weight: bold;
    }

    .cust-data {
      font-size: 14px;
      width: 350px;
      word-wrap: break-word;
    }

    .body-order p {
      font-size: 14px;
    }

    footer {
      float: right;
      margin-top: 40px;
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
      <h4 class="f-upper"> pt. hira adya naranata</h4>
      <p>
        Komplek Pangkalan Truk Genuk Blok AA No.35<br>
        Jl. Raya Kaligawe Km. 5,6 Semarang Telp./Fax. (024) 6582208
      </p>
    </div>
  </div>
  <hr>
  <section class="intro">
    <div class="order-detail order-number">
      <p class="f-upper">d.o : no. <?= $detail->no_order ?></p>
    </div>
    <div class="order-detail cust-data">
      <p>Semarang, <?= date('d-F-Y', strtotime($detail->dateAdd)) ?></p>
      <p>Kepada Yth :</p>
      <p class="f-upper"><?= $detail->nama_cust ?></p>
      <p>Di, <?= ucwords($detail->alamat_asal) ?></p>
    </div>
  </section>

  <section class="body-order">
    <p>Dengan hormat,</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bersama ini, truk kami dengan nomor polisi :
      <span class="fw-bold f-upper"> <?= $detail->platno ?></span>
    </p>
    <p>Nama Pengemudi dan Kernet :
      <span class="fw-bold"> <?= ucwords($detail->nama_sopir) ?></span> dan -
    </p>
    <p>Mohon diberi muatan berupa :
      <span class="fw-bold"><?= ucwords($detail->jenis_muatan) ?></span>
    </p>
    <p>Dengan tujuan ke :
      <span class="fw-bold"><?= ucwords($detail->alamat_tujuan) ?></span>
    </p>
  </section>

  <footer>
    <div class="ttd">
      <p>Hormat kami,</p>
      <h4 class="f-upper"> pt. hira adya naranata</h4>
    </div>
  </footer>

</body>

</html>