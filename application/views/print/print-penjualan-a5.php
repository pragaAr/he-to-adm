<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      padding-left: 5px;
      padding-right: 5px;
    }

    h4 {
      font-size: 13px;
    }

    p {
      font-size: 10px;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    hr {
      width: 95%;
      margin: auto;
      opacity: 0.5;
    }

    .text-uppercase {
      text-transform: uppercase;
    }

    .text-capitalize {
      text-transform: capitalize;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .text-left {
      text-align: left;
      padding-left: 10px;
    }

    .text-lg {
      font-size: 18px;
    }

    .text-sm {
      font-size: 12px;
    }

    .text-ssm {
      font-size: 9px;
    }

    .font-bold {
      font-weight: bold;
    }

    .sumline {
      float: right;
      padding-top: 15px;
      border-bottom: 1px solid black;
      width: 150px;
    }

    .f-right {
      float: right;
    }

    .header {
      margin-top: 15px;
    }

    .container {
      margin-right: 15px;
      margin-left: 15px;
    }

    .img-logo {
      float: left;
      width: 25%;
    }

    .img-logo img {
      position: absolute;
      width: 70px;
      height: 45px;
    }

    .company-name {
      float: right;
      width: 75%;
    }

    .mt-5 {
      margin-top: 5px;
    }

    .mt-15 {
      margin-top: 15px;
    }

    .mt-foot {
      margin-top: 35px;
    }

    .hr-kop {
      margin-top: 58px;
    }

    .line-space {
      border-bottom: 0.8px solid gray;
      width: 100%;
      margin: auto;
      padding-top: 3px;
      opacity: 0.5;
    }

    .table-data {
      margin-top: 10px;
    }

    /* .qrcode {
      float: right;
      margin-top: -5rem;
      padding-right: 5px;
    }

    .qrcode img {
      position: absolute;
      width: 85px;
    } */

    .data-resi {
      width: 100%;
      border: none;
    }

    .data-resi td {
      border-collapse: collapse;
      border: none;
    }

    .td-data-resi {
      padding: 3px;
      line-height: 10px;
      font-size: 12px;
    }

    .td-data-resi-lg {
      padding: 3px;
      font-size: 12px;
      font-weight: bold;
    }

    .data-pengirim {
      width: 100%;
      margin-bottom: 5px;
      border: none;
    }

    .data-pengirim td {
      border-collapse: collapse;
      border: none;
      font-size: 10px;
    }

    .w-sm {
      width: 25.5%;
    }

    .td-data-header {
      padding: 3px;
      line-height: 10px;
      font-size: 10px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .td-data-pengirim {
      padding: 3px;
      line-height: 10px;
      font-size: 10px;
    }

    .data-penerima {
      width: 100%;
      border: none;
    }

    .data-penerima td {
      border-collapse: collapse;
      border: none;
    }

    .td-data-penerima {
      padding: 3px;
      line-height: 10px;
      font-size: 10px;
    }

    .data-barang {
      width: 100%;
      margin-bottom: 5px;
      border: none;
    }

    .data-barang td {
      border-collapse: collapse;
      border: none;
    }

    .td-data-barang {
      padding: 3px;
      line-height: 10px;
      font-size: 10px;
    }

    .data-harga {
      width: 100%;
      margin-bottom: 5px;
      border: none;
    }

    .data-harga td {
      border-collapse: collapse;
      border: none;
    }

    .td-data-harga {
      padding: 3px;
      line-height: 10px;
      font-size: 10px;
    }

    .f-11 {
      font-size: 11px;
    }

    .watermark {
      position: absolute;
      display: block;
      margin-top: 50%;
      width: 96%;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding: 0 !important;
      font-weight: bold;
      font-size: 30px;
      font-weight: 900;
      text-align: center;
      text-transform: uppercase;
      color: red;
      opacity: 0.3;
      z-index: -1000;
      border: dotted;
    }

    .foot p {
      position: absolute;
      bottom: 15px;
      line-height: 2;
    }
  </style>
</head>

<body>
  <!-- watermark -->
  <div class="watermark">
    <?php if ($sales->pembayaran == 'lunas') { ?>
      <h1>
        lunas
      </h1>
    <?php } else if ($sales->pembayaran == 'tempo') { ?>
      <h1>
        tempo
      </h1>
    <?php } ?>
  </div>
  <!-- /watermark -->

  <div class="container header">
    <div class="img-logo">
      <img src="<?= base_url('assets/dist/img/logo-red.png') ?>">
    </div>

    <div class="company-name">
      <h4> PT. HIRA ADYA NARANATA</h4>
      <p>
        Komplek Pangkalan Truk Genuk Blok AA No.53 <br>
        Jl. Raya Kaligawe Km. 56 Semarang <br>
        Telp. (024)-6582208, +628112940481
      </p>
    </div>
  </div>
  <div class="hr-kop">
    <hr>
  </div>

  <div class="container">
    <div class="table-data">
      <!-- table data resi -->
      <table class="data-resi">
        <tr>
          <td class="td-data-resi-lg w-sm">RECCU</td>
          <td style="width:3%">:</td>
          <td class="td-data-resi-lg"><?= strtoupper($sales->reccu) ?></td>
        </tr>
        <tr>
          <td class="td-data-resi-lg w-sm">NO ORDER</td>
          <td style="width:3%">:</td>
          <td class="td-data-resi-lg"><?= strtoupper($sales->no_order) ?></td>
        </tr>

        <tr>
          <td colspan="4" class="td-data-resi"></td>
        </tr>
      </table>

      <!-- table data pengirim -->
      <table class="data-pengirim ">
        <tr>
          <td colspan="3" class="td-data-header">
            DATA ORDER
            <div class="line-space"></div>
          </td>
        </tr>
        <tr>
          <td class="td-data-pengirim w-sm">TANGGAL</td>
          <td style="width:3%">:</td>
          <td class="td-data-pengirim"><?= date('d-m-Y', strtotime($sales->dateorder)) ?></td>
        </tr>
        <tr>
          <td class="td-data-pengirim w-sm">PENGIRIM</td>
          <td style="width:3%">:</td>
          <td class="td-data-pengirim"><?= strtoupper($sales->pengirim) ?></td>
        </tr>
        <tr>
          <td class="td-data-pengirim w-sm">ALAMAT</td>
          <td style="width:3%">:</td>
          <td class="td-data-pengirim" style="line-height:1.3"><?= strtoupper($sales->kota_asal) ?>, <?= strtoupper($sales->alamat_asal) ?></td>
        </tr>
      </table>

      <!-- table data penerima -->
      <table class="data-penerima">
        <tr>
          <td colspan="3" class="td-data-header">
            DATA PENERIMA
            <div class="line-space"></div>
          </td>
        </tr>
        <tr>
          <td class="td-data-penerima w-sm">PENERIMA</td>
          <td style="width:3%">:</td>
          <td class="td-data-penerima"> <?= strtoupper($sales->penerima) ?></td>
        </tr>
        <tr>
          <td class="td-data-penerima w-sm">ALAMAT</td>
          <td style="width:3%">:</td>
          <td class="td-data-penerima" style="line-height:1.3"><?= strtoupper($sales->kota_tujuan) ?>, <?= strtoupper($sales->alamat_tujuan) ?></td>
        </tr>
      </table>

      <!-- table data barang -->
      <table class="data-barang">
        <tr>
          <td colspan="3" class="td-data-header">
            DATA BARANG
            <div class="line-space"></div>
          </td>
        </tr>
        <tr>
          <td class="td-data-barang w-sm">MUATAN</td>
          <td style="width:3%">:</td>
          <td class="td-data-barang">
            <?= strtoupper($sales->muatan) ?>
          </td>
        </tr>
        <tr>
          <td class="td-data-barang w-sm">BERAT</td>
          <td style="width:3%">:</td>
          <td class="td-data-barang">
            <?= $sales->berat ?> Kg,
          </td>
        </tr>
      </table>

      <!-- table data harga -->
      <table class="data-harga">
        <tr>
          <td colspan="3" class="td-data-header">
            DATA HARGA <span> (<?= ucwords($sales->jenis) ?>)</span>
            <div class="line-space"></div>
          </td>
        </tr>

        <!-- tonase -->
        <tr>
          <td class="td-data-harga w-sm">HARGA KG</td>
          <td style="width:3%">:</td>
          <td class="td-data-harga text-right">Rp. <?= number_format($sales->hrg_kg) ?> </td>
        </tr>
        <!-- tonase -->

        <tr>
          <td class="td-data-harga font-bold w-sm f-11">JUMLAH</td>
          <td style="width:3%">:</td>
          <td class="td-data-harga font-bold text-right f-11">Rp. <?= number_format($sales->total_hrg) ?></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="mt-5">
    <hr>
  </div>

  <div class="container">
    <div class="text-ssm foot">
      <p>
        Dicetak di Semarang, <?= date('d-m-Y H:i:s') ?>
      </p>
    </div>
  </div>
</body>

</html>