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
      font-family: Arial, Helvetica, sans-serif;
      color: #1d1d1d;
    }

    .container {
      margin: 20px 15px;
    }

    .logo {
      width: 20%;
      float: left;
    }

    img {
      width: 95px;
      height: 67px;
    }

    .identity {
      text-align: center;
    }

    .cname {
      font-size: 12px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 1px;
    }

    .cdetail {
      margin-top: 0;
      font-size: 9px;
      color: #303030;
    }

    .hr-kop {
      margin-top: 8px;
    }

    .data {
      margin-top: 5px;
    }

    .table-data {
      width: 100%;
      border: none;
    }

    .table-data td {
      border-collapse: collapse;
      border: none;
    }

    .td-reccu {
      padding: 3px;
      line-height: 10px;
      font-size: 12px;
    }

    .td-reccu-lg {
      padding: 3px;
      font-size: 14px;
      font-weight: bold;
    }

    .w-sm {
      width: 25.5%;
    }

    .line {
      border-bottom: 0.8px solid gray;
      width: 100%;
      margin: auto;
      padding-top: 3px;
      opacity: 0.5;
    }

    .td-header {
      padding: 3px;
      line-height: 10px;
      font-size: 10px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .td-data {
      padding: 3px;
      line-height: 10px;
      font-size: 10px;
    }

    .addr {
      height: 30px;
      vertical-align: top;
    }

    .bold {
      font-weight: bold;
    }

    .right {
      text-align: right;
    }

    .mt-5 {
      margin-top: 5px;
    }

    .foot p {
      position: absolute;
      bottom: 20px;
      line-height: 2;
    }

    .text-sm {
      font-size: 9px;
    }

    .watermark {
      width: 100%;
      height: 100%;
      position: fixed;
      left: 0;
      z-index: -1000;
    }

    .watermark p {
      margin-top: 55%;
      text-align: center;
      font-weight: bold;
      font-size: 60px;
      color: red;
      opacity: 0.2;
      transform: rotate(-45deg);
    }
  </style>
</head>

<body>

  <div class="watermark">
    <p>
      <?= strtoupper($sales->pembayaran) ?>
    </p>
  </div>

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
      <p class="cdetail">Email : hira.express.transport@gmail.com</p>
      <p class="cdetail">Website : https://hira-express.com</p>
    </div>

    <div class="hr-kop">
      <hr>
    </div>

    <div class="data">
      <table class="table-data">
        <tr>
          <td class="td-reccu-lg w-sm">RECCU</td>
          <td style="width:3%">:</td>
          <td class="td-reccu-lg"><?= strtoupper($sales->reccu) ?></td>
        </tr>
        <tr>
          <td class="td-reccu-lg w-sm">NO ORDER</td>
          <td style="width:3%">:</td>
          <td class="td-reccu-lg"><?= strtoupper($sales->no_order) ?></td>
        </tr>
        <tr>
          <td colspan="4" class="td-reccu"></td>
        </tr>
      </table>

      <table class="table-data">
        <tr>
          <td colspan="3" class="td-header">
            DATA ORDER
            <div class="line"></div>
          </td>
        </tr>
        <tr>
          <td class="td-data w-sm">TANGGAL</td>
          <td style="width:3%">:</td>
          <td class="td-data"><?= date('d-m-Y', strtotime($sales->dateorder)) ?></td>
        </tr>
        <tr>
          <td class="td-data w-sm">PENGIRIM</td>
          <td style="width:3%">:</td>
          <td class="td-data"><?= strtoupper($sales->pengirim) ?></td>
        </tr>
        <tr>
          <td class="td-data w-sm addr">ALAMAT</td>
          <td class="addr" style="width:3%">:</td>
          <td class="td-data addr"><?= strtoupper($sales->kota_asal) ?>, <?= strtoupper($sales->alamat_asal) ?></td>
        </tr>
      </table>

      <table class="table-data">
        <tr>
          <td colspan="3" class="td-header">
            DATA PENERIMA
            <div class="line"></div>
          </td>
        </tr>
        <tr>
          <td class="td-data w-sm">PENERIMA</td>
          <td style="width:3%">:</td>
          <td class="td-data"> <?= strtoupper($sales->penerima) ?></td>
        </tr>
        <tr>
          <td class="td-data w-sm addr">ALAMAT</td>
          <td class="addr" style="width:3%">:</td>
          <td class="td-data addr"><?= strtoupper($sales->kota_tujuan) ?>, <?= strtoupper($sales->alamat_tujuan) ?></td>
        </tr>
      </table>

      <table class="table-data">
        <tr>
          <td colspan="3" class="td-header">
            DATA BARANG
            <div class="line"></div>
          </td>
        </tr>
        <tr>
          <td class="td-data w-sm">MUATAN</td>
          <td style="width:3%">:</td>
          <td class="td-data">
            <?= strtoupper($sales->muatan) ?>
          </td>
        </tr>
        <tr>
          <td class="td-data w-sm">BERAT</td>
          <td style="width:3%">:</td>
          <td class="td-data">
            <?= $sales->berat ?> Kg,
          </td>
        </tr>
      </table>

      <table class="table-data">
        <tr>
          <td colspan="3" class="td-header">
            DATA HARGA <span> (<?= ucwords($sales->jenis) ?>)</span>
            <div class="line"></div>
          </td>
        </tr>
        <tr>
          <td class="td-data w-sm">HARGA KG</td>
          <td style="width:3%">:</td>
          <td class="td-data right">Rp. <?= number_format($sales->hrg_kg) ?> </td>
        </tr>
        <tr>
          <td class="td-data bold w-sm">JUMLAH</td>
          <td style="width:3%">:</td>
          <td class="td-data bold right">Rp. <?= number_format($sales->total_hrg) ?></td>
        </tr>
      </table>

      <div class="mt-5">
        <hr>
      </div>

      <div class="text-sm foot">
        <p>
          Dicetak di Semarang, <?= date('d-m-Y H:i:s') ?>
        </p>
      </div>
    </div>

  </div>

</body>

</html>