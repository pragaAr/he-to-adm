<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tanda Terima Surat Jalan</title>

  <style>
    body {
      color: #1d1d1d;
    }

    .container {
      margin: 0 10px;
    }

    .logo {
      width: 17%;
      float: left;
    }

    img {
      width: 100%;
    }

    .identity {
      text-align: center;
      padding-right: 100px;
      margin-bottom: 1.5px;
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

    hr {
      border: none;
      height: 1.5px;
      color: #000;
      background-color: #000;
    }

    .data-title {
      text-align: center;
    }

    .data-title h4 {
      margin: 0;
      font-size: 16px;
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

    .th-content {
      text-transform: uppercase;
    }

    .td-content {
      text-transform: capitalize;
      height: 50px;
    }

    .td-content-numerik {
      border: 1px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 5px;
      vertical-align: middle;
      height: 50px;

    }

    .td-content-numerik {
      text-transform: capitalize;
    }

    .td-content-empty {
      border: 1px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 5px;
      vertical-align: middle;
      height: 50px;
    }

    .font-bold {
      font-weight: bold;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .danger {
      color: red;
    }

    .page-number-footer {
      text-align: right;
      font-style: italic;
      font-size: 11px;
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
      <p class="cdetail">Komplek Pangkalan Truk Genuk Blok AA No.35, Jl. Raya Kaligawe Km 56, Semarang</p>
      <p class="cdetail">Telp : (024) 6582208; +628112940481</p>
      <p class="cdetail">Website : https://hira-express.com Email : hira.express.transport@gmail.com</p>
    </div>

    <hr>

    <div class="data-title">
      <h4><?= strtoupper($title) ?></h4>
      <h4>No : <?= strtoupper($nomor) ?></h4>
    </div>

    <div class="data-content">
      <table class="table-content">
        <thead>
          <tr>
            <th class="th-content" style="width:5%">No.</th>
            <th class="th-content" style="width:10%">Tanggal</th>
            <th class="th-content" style="width:10%">Nomor Polisi</th>
            <th class="th-content" style="width:20%">Surat Jalan</th>
            <th class="th-content" style="width:20%">Asal-Tujuan</th>
            <th class="th-content" style="width:9%">Berat</th>
            <th class="th-content" style="width:9%">Ongkir</th>
            <th class="th-content" style="width:15%">Tagihan</th>
          </tr>
        </thead>
        <tbody>
          <?php $sumtotal = 0;
          $no = 1;
          foreach ($rc as $data) : ?>

            <tr>
              <td class="td-content"><?= $no++ ?>.</td>
              <td class="td-content"><?= date('d/m/Y', strtotime($data->dateAdd)) ?></td>
              <td class="td-content uppercase"><?= $data->platno ?></td>
              <td class="td-content">Total Surat Jalan <?= $data->jml_sj ?></td>
              <td class="td-content"><?= $data->kota_asal ?>-<?= $data->kota_tujuan ?></td>
              <td class="td-content-numerik"><?= $data->berat ?> Kg</td>
              <td class="td-content-numerik">Rp. <?= number_format($data->hrg_kg) ?></td>
              <td class="td-content-numerik">Rp. <?= number_format($data->total_hrg) ?></td>
            </tr>

            <?php foreach ($dt as $detail) : ?>
              <?php if ($detail->reccu == $data->reccu) { ?>
                <tr>
                  <td class="td-content"></td>
                  <td class="td-content"><?= $data->keterangan ?></td>
                  <td class="td-content"></td>
                  <td class="td-content"><?= $detail->surat_jalan ?></td>

                  <?php if ($detail->retur == 0) { ?>
                    <td class="td-content"> </td>
                  <?php } else { ?>
                    <td class="td-content danger">Retur <?= $detail->retur ?></td>
                  <?php } ?>

                  <td class="td-content"></td>
                  <td class="td-content"></td>
                  <td class="td-content"></td>
                </tr>
              <?php } ?>
            <?php endforeach ?>

            <tr>
              <td class="td-content-empty"></td>
              <td class="td-content-empty"></td>
              <td class="td-content-empty"></td>
              <td class="td-content-empty"></td>
              <td class="td-content-empty"></td>
              <td class="td-content-empty"></td>
              <td class="td-content-empty"></td>
              <td class="td-content-empty"></td>
            </tr>

            <?php
            $sumtotal += $data->total_hrg;
            ?>

          <?php endforeach ?>

          <tr>
            <td colspan="7" class="td-content font-bold uppercase">Jumlah</td>
            <td class="td-content-numerik font-bold">Rp. <?= number_format($sumtotal) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>