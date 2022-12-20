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
      margin: 0;
      padding: 0;
    }

    main {
      margin-top: 2rem;

    }

    .head-side {
      margin-bottom: 5px;
    }

    .img-logo {
      float: left;
    }

    .img-logo img {
      position: absolute;
      width: 65px;
      height: 43px;
    }

    .company-name {
      float: right;
    }

    .company-name h4 {
      font-size: 16px;
      margin-top: -3px;
    }

    .company-name p {
      margin-top: -25px;
      font-size: 12px;
    }

    table {
      width: 100%;
      margin-top: 15px;
    }

    table,
    th,
    td {
      border-collapse: collapse;
      border: 1px solid black;
    }

    th,
    td {
      text-align: center;
      padding: 10px;
    }

    th {
      background-color: #eaeaea;
      line-height: 5px;
      font-size: 12px;
      font-weight: bolder;
    }

    td {
      line-height: 15px;
      font-size: 14px;
    }

    .tanggal {
      text-align: left;
      width: 20%;
    }
  </style>
</head>

<body>
  <main>

  </main>
  <div class="head-side">
    <div class="img-logo">
      <img src="<?= base_url('assets/dist/img/logo-red.png') ?>">
    </div>

    <div class="company-name">
      <h4> PT. HIRA ADYA NARANATA</h4>
      <p>
        Komplek Pangkalan Truk Genuk Blok AA No.35<br>
        Jl. Raya Kaligawe Km. 5,6 Semarang Telp./Fax. (024) 6582208
      </p>
    </div>
  </div>

  <br>
  <br>
  <?php if ($penjualan->jenis_penjualan == "borong") { ?>
    <table>
      <tr>
        <th>No Pengiriman</th>
        <th>Jenis</th>
        <th>Asal</th>
        <th>Tujuan</th>
      </tr>
      <tr>
        <td>No.<?= $penjualan->no_order ?></td>
        <td><?= strtoupper($penjualan->jenis_penjualan) ?></td>
        <td><?= strtoupper($penjualan->kota_asal) ?></td>
        <td><?= strtoupper($penjualan->kota_tujuan) ?></td>
      </tr>
      <tr>
        <th colspan="2">Pengirim :</th>
        <th colspan="2">Penerima :</th>
      </tr>
      <tr>
        <td colspan="2">
          <br>
          <?= strtoupper($penjualan->pengirim) ?> <br><br>
          <?= strtoupper($penjualan->alamat_asal) ?>
          <br>
          <br>
        </td>
        <td colspan="2">
          <br>
          <?= strtoupper($penjualan->penerima) ?> <br><br>
          <?= strtoupper($penjualan->alamat_tujuan) ?>
          <br>
          <br>
        </td>
      </tr>
      <tr>
        <th>Petugas</th>
        <th>Muatan</th>
        <th>Penerima</th>
        <th>Jumlah Rp.</th>
      </tr>
      <tr>
        <td class="tanggal">
          <br><br><br><br>Tanggal :

        </td>
        <td>
          <?= strtoupper($penjualan->muatan) ?><br>
        </td>
        <td class="tanggal">
          <br><br><br><br>Tanggal :
        </td>
        <td>
          Rp. <?= number_format($penjualan->total_harga) ?><br>
        </td>
      </tr>
    </table>
  <?php } else { ?>
    <table>
      <tr>
        <th>No Pengiriman</th>
        <th>Jenis</th>
        <th>Berat</th>
        <th>Harga</th>
        <th>Asal</th>
        <th>Tujuan</th>
      </tr>
      <tr>
        <td>No.<?= $penjualan->no_order ?></td>
        <td><?= strtoupper($penjualan->jenis_penjualan) ?></td>
        <td><?= number_format($penjualan->berat) ?> Kg</td>
        <td>Rp. <?= number_format($penjualan->harga_kg) ?></td>
        <td><?= strtoupper($penjualan->kota_asal) ?></td>
        <td><?= strtoupper($penjualan->kota_tujuan) ?></td>
      </tr>
      <tr>
        <th colspan="3">Pengirim :</th>
        <th colspan="3">Penerima :</th>
      </tr>
      <tr>
        <td colspan="3">
          <br>
          <?= strtoupper($penjualan->pengirim) ?> <br><br>
          <?= strtoupper($platno->platno) ?>
          <br>
          <br>
        </td>
        <td colspan="3">
          <br>
          <?= strtoupper($penjualan->penerima) ?> <br><br>
          <?= strtoupper($penjualan->alamat_tujuan) ?>
          <br>
          <br>
        </td>
      </tr>
      <tr>
        <th>Petugas</th>
        <th colspan="2">Muatan</th>
        <th>Penerima</th>
        <th colspan="2">Jumlah Rp.</th>
      </tr>
      <tr>
        <td class="tanggal">
          <br><br><br><br>Tanggal : <?= date('d-m-Y', strtotime($penjualan->dateAdd)) ?>
        </td>
        <td colspan="2">
          <?= strtoupper($penjualan->muatan) ?><br>
        </td>
        <td width="20%" class="tanggal">
          <br><br><br><br>Tanggal :
        </td>
        <td colspan="2">
          Rp. <?= number_format($penjualan->total_harga) ?><br>
        </td>
      </tr>
    </table>
  <?php } ?>


</body>

</html>