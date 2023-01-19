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
      margin-top: 20px;
      margin-bottom: 20px;
      margin-left: 15px;
      margin-right: 15px;
    }

    .kop {
      display: inline;
    }

    .img-logo {
      position: absolute;
      width: 82px;
      height: 50px;
    }

    .company-name h4 {
      font-size: 20px;
      margin-top: -3px;
    }

    .company-name p {
      margin-top: -25px;
      font-size: 12px;
    }

    .text-center {
      text-align: center;
    }

    .intro p {
      font-size: 14px;
    }

    .data-section {
      margin-top: 15px;
      margin-bottom: 20px;
    }

    .tabledata {
      width: 100%;
      text-align: center;
    }

    .tabledata,
    .thdata,
    .tddata {
      font-size: 12px;
      border: 0.8px solid black;
      border-collapse: collapse;
    }

    .thdata,
    .tddata {
      padding: 5px;
    }
  </style>

</head>

<body>
  <div class="kop text-center">
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
    <div>
      <?php
      $dayUm = date('D', strtotime($dataum->dateAdd));
      if ($dayUm == 'Sun') {  ?>
        <p>Daftar Penerima Uang Makan <?= 'Hari Minggu, ' . date('d F Y', strtotime($dataum->dateAdd)) ?></p>
      <?php } elseif ($dayUm == 'Mon') { ?>
        <p>Daftar Penerima Uang Makan <?= 'Hari Senin, ' . date('d F Y', strtotime($dataum->dateAdd)) ?></p>
      <?php } elseif ($dayUm == 'Tue') { ?>
        <p>Daftar Penerima Uang Makan <?= 'Hari Selasa, ' . date('d F Y', strtotime($dataum->dateAdd)) ?></p>
      <?php } elseif ($dayUm == 'Wed') { ?>
        <p>Daftar Penerima Uang Makan <?= 'Hari Rabu, ' . date('d F Y', strtotime($dataum->dateAdd)) ?></p>
      <?php } elseif ($dayUm == 'Thu') { ?>
        <p>Daftar Penerima Uang Makan <?= 'Hari Kamis, ' . date('d F Y', strtotime($dataum->dateAdd)) ?></p>
      <?php } elseif ($dayUm == 'Fri') { ?>
        <p>Daftar Penerima Uang Makan <?= 'Hari Jumat, ' . date('d F Y', strtotime($dataum->dateAdd)) ?></p>
      <?php } elseif ($dayUm == 'Sat') { ?>
        <p>Daftar Penerima Uang Makan <?= 'Hari Sabtu, ' . date('d F Y', strtotime($dataum->dateAdd)) ?></p>
      <?php } ?>
    </div>
  </section>

  <section class="data-section">
    <table class="tabledata">
      <thead>
        <tr>
          <th class="thdata">NO.</th>
          <th class="thdata">Nama</th>
          <th class="thdata">Bagian</th>
          <th class="thdata">Nominal</th>
          <th class="thdata">Tanda Tangan</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($detailum as $detail) : ?>
          <tr>
            <td class="tddata"><?= $no ?>.</td>
            <td class="tddata"><?= strtoupper($detail->nama) ?></td>
            <td class="tddata"><?= strtoupper($detail->status) ?></td>
            <td class="tddata"></td>
            <td class="tddata"></td>
          </tr>
          <?php $no++ ?>
        <?php endforeach ?>
      </tbody>
    </table>
  </section>

</body>

</html>