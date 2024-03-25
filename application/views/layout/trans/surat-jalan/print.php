<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tanda Terima Surat Jalan</title>

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

    .data-title h4 {
      text-transform: uppercase;
    }

    .data-content {
      margin-top: 10px;
    }

    .table-content {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #000;
    }

    .th-content,
    .td-content {
      border: 1px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 5px;
      vertical-align: middle;
    }

    .td-content {
      text-transform: uppercase;
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

    <div class="data-title">
      <h4><?= $title ?></h4>
      <h4><?= $nomor ?></h4>
    </div>

    <div class="data-content">
      <table class="table-content">
        <thead>
          <tr>
            <th class="th-content">No</th>
            <th class="th-content">Reccu</th>
            <th class="th-content">Tanggal</th>
            <th class="th-content">No Surat Jalan</th>
            <th class="th-content">Nopol</th>
            <th class="th-content">Asal-Tujuan</th>
            <th class="th-content">Berat</th>
            <th class="th-content">Ongkir</th>
            <th class="th-content">Tagihan</th>
          </tr>
        </thead>
        <tbody>

          <?php $sumtotal = 0;
          foreach ($content as $data) : ?>
            <tr>
              <td class="td-content"><?= $data['no'] ?></td>
              <td class="td-content"><?= $data['reccu']; ?></td>
              <td class="td-content"><?= $data['dateAdd']; ?></td>
              <td class="td-content"><?= $data['nosj']; ?></td>
              <td class="td-content"><?= $data['platno']; ?></td>
              <td class="td-content"><?= $data['kota']; ?></td>
              <td class="td-content"><?= $data['berat']; ?></td>
              <td class="td-content"><?= $data['hrg_kg']; ?></td>
              <td class="td-content"><?= number_format($data['total_hrg']); ?></td>
            </tr>

            <?php
            $sumtotal += $data['total_hrg'];
            ?>
          <?php endforeach ?>
          <tr>
            <td colspan="8" class="td-content">Jumlah</td>
            <td class="td-content"><?= number_format($sumtotal) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>