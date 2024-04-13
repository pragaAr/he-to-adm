<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    body {
      color: #1d1d1d;
    }

    p {
      font-size: 12px;
      margin: 0;
    }

    .container {
      margin: 0 10px;
    }

    .logo {
      width: 15%;
      float: left;
    }

    img {
      width: 100%;
    }

    .identity {
      padding-left: 250px;
      text-decoration: underline;
    }

    .title-name {
      padding-top: 20px;
      font-size: 22px;
    }

    .clear {
      clear: both;
    }

    hr {
      border: none;
      height: 1.5px;
      color: #000;
      background-color: #000;
      margin: 2px 0;
    }

    .text-capitalize {
      text-transform: capitalize;
    }

    .text-uppercase {
      text-transform: uppercase;
    }

    .underline {
      text-decoration: underline;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .end {
      margin-top: 25px;
      padding-right: 10px;
      text-align: right;
    }

    .font-bold {
      font-weight: bold;
    }

    .mt-1 {
      margin-top: 5px;
    }

    .mt-2 {
      margin-top: 10px;
    }

    .title-table {
      font-size: 12px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .table-head {
      width: 100%;
      border: none;
    }

    .th-head {
      font-size: 12px;
      padding: 3px;
    }

    .td-head {
      font-size: 12px;
      padding: 3px;
    }

    .table-order {
      width: 100%;
      border: 0.8px solid #000;
      border-collapse: collapse;
    }

    .th-order,
    .td-order {
      border: 0.8px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 10px 5px;
    }

    .table-sangu {
      width: 100%;
      border: 0.8px solid #000;
      border-collapse: collapse;
    }

    .th-sangu,
    .td-sangu {
      border: 0.8px solid #000;
      font-size: 12px;
      text-align: center;
      padding: 10px 5px;
    }

    .table-persen {
      width: 100%;
      border: none;
    }

    .td-persen {
      font-size: 12px;
      padding: 10px 5px;
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
      <h3 class="title-name">
        <?= strtoupper($title) ?>
      </h3>
    </div>

    <div class="clear"></div>

    <hr>

    <div class="mt-1">
      <table class="table-head">
        <tr>
          <td class="td-head" style="width:60%"></td>
          <td class="td-head font-bold" style="width:18%">Nama Sopir</td>
          <td class="td-head font-bold text-center" style="width:4%">:</td>
          <td class="td-head font-bold text-uppercase" style="width:18%"><?= $sopir->nama ?></td>
        </tr>
        <tr>
          <td class="td-head" style="width:60%"></td>
          <td class="td-head font-bold" style="width:18%">Plat Nomor</td>
          <td class="td-head font-bold text-center" style="width:4%">:</td>
          <td class="td-head font-bold" style="width:18%">H 1234 AA</td>
        </tr>
      </table>
    </div>

    <div class="mt-2">
      <p class="title-table">Order Penjualan</p>
      <table class="table-order">
        <thead>
          <tr>
            <th class="th-order" style="width:6%">No.</th>
            <th class="th-order" style="width:22%">Customer</th>
            <th class="th-order" style="width:20%">Tanggal</th>
            <th class="th-order" style="width:16%">Harga</th>
            <th class="th-order" style="width:10%">%</th>
            <th class="th-order" style="width:10%">%</th>
            <th class="th-order" style="width:16%">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($order as $order) : ?>

            <tr>
              <td class="td-order"><?= $no++; ?>.</td>
              <td class="td-order text-uppercase"><?= $order->nama ?></td>
              <td class="td-order"><?= date('d/m/y', strtotime($order->tglOrder)) ?></td>
              <td class="td-order text-right">Rp. <?= number_format($order->tot_biaya) ?></td>
              <td class="td-order"><?= $order->persen1 ?>%</td>
              <td class="td-order"><?= $order->persen2 ?>%</td>

              <?php
              $biaya = floatval($order->tot_biaya);
              $ps1 = floatval($order->persen1);
              $ps2 = floatval($order->persen2);
              $penyebut = floatval(100);

              $totBiayaOrder = 0;
              $jmlTotalBiayaOrder = 0;

              if ($ps1 == 0 && $ps2 == 0) {
                $totBiayaOrder = $biaya;
              } elseif ($ps1 != 0 && $ps2 != 0) {
                $totBiayaOrder = $biaya * (($ps1 / $penyebut) * ($ps2 / $penyebut));
              } elseif ($ps1 != 0 && $ps2 == 0) {
                $totBiayaOrder = $biaya * ($ps1 / $penyebut);
              } elseif ($ps1 == 0 && $ps2 != 0) {
                $totBiayaOrder = $biaya * ($ps2 / $penyebut);
              }

              $jmlTotalBiayaOrder += $totBiayaOrder;
              ?>

              <td class="td-order text-right">Rp. <?= number_format($totBiayaOrder) ?></td>
            </tr>

          <?php endforeach ?>

          <tr>
            <td class="td-order text-uppercase font-bold" colspan="6">jumlah</td>
            <td class="td-order text-right">Rp. <?= number_format($jmlTotalBiayaOrder) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-2">
      <p class="title-table">Sangu</p>
      <table class="table-sangu">
        <thead>
          <tr>
            <th class="th-sangu" style="width:6%">No.</th>
            <th class="th-sangu" style="width:22%">Terima Sangu</th>
            <th class="th-sangu" style="width:12%">Tanggal</th>
            <th class="th-sangu" style="width:16%">Nominal</th>
            <th class="th-sangu" style="width:12%">Tanggal</th>
            <th class="th-sangu" style="width:16%">Tambahan</th>
            <th class="th-sangu" style="width:16%">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($sangu as $sangu) : ?>
            <tr>
              <td class="td-sangu"><?= $no++ ?>.</td>
              <td class="td-sangu text-uppercase"><?= $sangu->nama ?></td>
              <td class="td-sangu"><?= date('d/m/y', strtotime($sangu->tglSangu)) ?></td>
              <td class="td-sangu text-right">Rp. <?= number_format($sangu->nominal_sangu) ?></td>
              <td class="td-sangu"><?= date('d/m/y', strtotime($sangu->tglSangu)) ?></td>
              <td class="td-sangu text-right">Rp. <?= number_format($sangu->tambahan) ?></td>

              <?php
              $a = floatval($sangu->nominal_sangu);
              $b = floatval($sangu->tambahan);

              $c = $a + $b;
              $jmlTotalSangu = 0;

              ?>

              <td class="td-sangu text-right">Rp. <?= number_format($c) ?></td>
            </tr>

            <?php
            $jmlTotalSangu += $c;
            ?>
          <?php endforeach ?>
          <tr>
            <td class="td-sangu text-uppercase font-bold" colspan="6">jumlah</td>
            <td class="td-sangu text-right">Rp. <?= number_format($jmlTotalSangu) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-2">
      <table class="table-persen">
        <tr>
          <td class="td-persen font-bold" style="width:60%">Persen (Total Order Penjualan - Total Sangu) </td>
          <td class="td-persen font-bold text-center" style="width:6%">:</td>

          <?php
          $totOrder = floatval($totBiayaOrder);
          $totSangu = floatval($jmlTotalSangu);

          $totPersen = $totOrder - $totSangu;
          ?>

          <td class="td-persen font-bold text-right">Rp. <?= number_format($totPersen) ?></td>
        </tr>
      </table>

    </div>
  </div>

</body>

</html>