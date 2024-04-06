<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    * {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Times New Roman', Times, serif;
      color: #1d1d1d;
    }

    .container {
      margin: 0 10px;
    }

    .fw-bold {
      font-weight: bold;
    }

    .f-upper {
      text-transform: uppercase;
    }

    .logo {
      width: 20%;
      float: left;
    }

    img {
      width: 115px;
      height: 78px;
    }

    .identity {
      text-align: center;
      padding-right: 60px;

    }

    .cname {
      font-size: 20px;
      font-weight: bold;
      text-transform: uppercase;
      margin: 0;
      padding-bottom: 1px;
    }

    .cdetail {
      margin: 0;
      font-size: 12px;
      color: #303030;
    }

    .intro {
      margin-top: 20px;
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
      font-size: 16px;
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
      width: 100%;
      margin-top: 40px;
    }

    .w-60 {
      width: 60%;
    }

    .w-40 {
      width: 40%;
    }

    footer .ttd {
      float: right;
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
  <div class="container">
    <div class="logo">
      <img src="<?= base_url('assets/dist/img/logo-red.png') ?>">
    </div>

    <div class="identity">
      <p class="cname">
        pt. hira adya naranata
      </p>
      <p class="cdetail">Komplek Pangkalan Truk Genuk Blok AA No.35</p>
      <p class="cdetail">Jl. Raya Kaligawe Km 56, Semarang</p>
      <p class="cdetail">Telp : (024) 6582208; +628112940481</p>
      <p class="cdetail">Website : https://hira-express.com Email : hira.express.transport@gmail.com</p>
    </div>

    <hr>
    <section class="intro">
      <div class="order-detail order-number">
        <p class="f-upper">no order : <?= $detail->no_order ?></p>
      </div>
      <div class="order-detail cust-data">
        <p>Semarang, <?= date('d-m-Y', strtotime($detail->dateAdd)) ?></p>
        <p>Kepada Yth,</p>
        <p class="f-upper"><?= $detail->nama_customer ?></p>
        <p>Di <?= ucwords($detail->asal_order) ?>.</p>
      </div>
    </section>

    <section class="body-order">
      <p>Dengan hormat,</p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bersama ini, truk kami dengan Nomor Polisi
        <span class="fw-bold f-upper"> <?= $detail->platno ?></span>,
        Pengemudi <span class="fw-bold"> <?= ucwords($detail->nama_sopir) ?></span> dan Kernet <span class="fw-bold">-</span>.
      </p>
      <p>Mohon diberi muatan berupa
        <span class="fw-bold"><?= ucwords($detail->jenis_muatan) ?></span>,
        dengan tujuan ke
        <span class="fw-bold"><?= ucwords($detail->tujuan_order) ?></span>
      </p>
    </section>

    <footer>
      <div class="w-60"></div>
      <div class="ttd w-40">
        <p>Hormat kami,</p>
        <h4 class="f-upper"> pt. hira adya naranata</h4>
      </div>
    </footer>

  </div>

</body>

</html>