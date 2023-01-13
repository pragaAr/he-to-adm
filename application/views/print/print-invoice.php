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

    .text-left {
      text-align: left;
    }

    .text-right {
      text-align: right;
    }

    .inv-cust {
      font-size: 12px;
      font-weight: bold;
      text-transform: uppercase;
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

    tfoot {
      text-align: right;
      font-weight: bold;
    }

    .tablepajak {
      width: 100%;
      font-size: 12px;
    }

    .tablepajak,
    .tdpajak {
      border: none;
      border-collapse: collapse;
    }

    .totdpp {
      padding-right: 7px;
    }

    .emptytd {
      height: 20px;
    }

    .fw-bold {
      font-weight: bold;
    }

    .bankinfo {
      font-size: 12px;
      margin-top: 30px;
    }

    footer {
      float: right;
      margin-top: 40px;
    }

    .ttd {
      font-size: 12px;
    }

    .manager {
      margin-top: 65px;
    }

    .nama-manager {
      border-bottom: 1px solid black;
    }

    .jabatan {
      margin-top: -12px;
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

  <section>
    <div class="inv-cust text-center">
      <p>invoice <?= strtoupper($datacust->nama_cust) ?></p>
      <p> no: <?= strtoupper($datacust->kd_inv) ?></p>
    </div>
  </section>

  <section class="data-section">
    <table class="tabledata">
      <thead>
        <tr>
          <th class="thdata">NO.</th>
          <th class="thdata">TANGGAL</th>
          <th class="thdata">NO SJ</th>
          <th class="thdata">NO POL</th>
          <th class="thdata">NO RESI</th>
          <th class="thdata">ASAL-TUJUAN</th>
          <th class="thdata">BERAT</th>
          <th class="thdata">ONGKOS</th>
          <th class="thdata">TAGIHAN</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($detail as $detail) : ?>
          <tr>
            <td class="tddata"><?= $no ?>.</td>
            <td class="tddata"><?= date('d/m/y', strtotime($detail->dateAdd)) ?></td>
            <td class="tddata"><?= strtoupper($detail->surat_jalan) ?></td>
            <td class="tddata"><?= strtoupper($detail->platno) ?></td>
            <td class="tddata"><?= strtoupper($detail->no_order) ?></td>
            <td class="tddata"><?= strtoupper($detail->kota_asal) ?>-<?= strtoupper($detail->kota_tujuan) ?></td>
            <td class="tddata"><?= number_format($detail->berat) ?> Kg</td>
            <td class="tddata text-right">Rp. <?= number_format($detail->harga_kg) ?></td>
            <td class="tddata text-right">Rp. <?= number_format($detail->total_harga) ?></td>
          </tr>
          <?php $no++ ?>
        <?php endforeach ?>
      </tbody>
      <tfoot>
        <td class="tddata" colspan="9"> <?= number_format($datacust->jml_nominal) ?></td>
      </tfoot>
    </table>
  </section>

  <section>
    <table class="tablepajak">
      <?php
      $a = 100;
      $b = 101.1;
      $divide = $a / $b;
      $resultdpp = $datacust->jml_nominal * $divide;

      $ppn = 1.1 / 100;
      $resultppn = $ppn * round($resultdpp);

      $jmlpajak = round($resultppn) + round($resultdpp);
      ?>
      <tbody>
        <tr>
          <td class="tdpajak" width="5%"></td>
          <td class="tdpajak" width="20%"></td>
          <td class="tdpajak text-left" width="30%">DPP &nbsp;&nbsp; Rp. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= number_format($datacust->jml_nominal) ?></td>
          <td class="tdpajak text-center" style="padding-bottom:3px;" width="10%"><span style="border-bottom:1.5px solid black">&nbsp; x 100%&nbsp;</span> </td>
          <td class="tdpajak text-center" width="5%"> = </td>
          <td class="tdpajak text-right totdpp" width="20%"> <?= number_format(round($resultdpp)) ?></td>
        </tr>
        <tr>
          <td class="tdpajak" colspan="3"></td>
          <td class="tdpajak text-center" width="10%"> 101.1%</td>
          <td class="tdpajak" colspan="2"></td>
        </tr>
        <tr>
          <td class="tdpajak emptytd" colspan="6"></td>
        </tr>
        <tr>
          <td class="tdpajak" colspan="2"></td>
          <td class="tdpajak text-left" width="30%">PPN</td>
          <td class="tdpajak text-center" width="10%">1.1%</td>
          <td class="tdpajak text-center" width="5%"> = </td>
          <td class="tdpajak text-right totdpp" width="20%"> <?= number_format(round($resultppn)) ?></td>
        </tr>
        <tr>
          <td class="tdpajak emptytd" colspan="6"></td>
        </tr>
        <tr>
          <td class="tdpajak" colspan="2"></td>
          <td class="tdpajak text-center fw-bold" colspan="2">JUMLAH</td>
          <td class="tdpajak text-center" width="5%"> = </td>
          <td class="tdpajak text-right totdpp fw-bold" width="20%">Rp. <?= number_format(round($jmlpajak)) ?></td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="bankinfo">
    <p>Mohon tagihan dapat ditransfer ke rekening :</p>
    <table>
      <tbody>
        <tr>
          <td>BANK</td>
          <td>:</td>
          <td>BCA KCP Solo Veteran</td>
        </tr>
        <tr>
          <td>Atas Nama</td>
          <td>:</td>
          <td>PT. HIRA ADYA NARANATA</td>
        </tr>
        <tr>
          <td>No Acc</td>
          <td>:</td>
          <td>773 550 6161</td>
        </tr>
      </tbody>
    </table>
  </section>

  <footer>
    <div class="ttd">
      <div class="text-center">
        <p>Semarang, <?= date('d F Y') ?></p>
        <p>Hormat Kami<br>PT. HIRA ADYA NARANATA</p>
      </div>
      <div class="text-left manager">
        <p class="nama-manager">David Pratama Widiatmo.S.Ak</p>
        <p class="jabatan">Manager</p>
      </div>

    </div>
  </footer>

</body>

</html>