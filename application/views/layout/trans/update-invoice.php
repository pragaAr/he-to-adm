<div class="content-wrapper">
  <div class="inserted" data-flashdata="<?= $this->session->flashdata('inserted'); ?>"></div>
  <div class="updated" data-flashdata="<?= $this->session->flashdata('updated'); ?>"></div>
  <div class="deleted" data-flashdata="<?= $this->session->flashdata('deleted'); ?>"></div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('invoice') ?>" class="btn btn-dark">
              <i class=" fas fa-arrow-left"></i>
              Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form action="<?= base_url('invoice/prosesUpdate') ?>" method="post">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="editkd">No Inv</label>
                    <input type="text" name="editkd" class="form-control text-uppercase" value="<?= $kd->kd_inv ?>" required readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="edittanggal">Tanggal</label>
                    <input type="text" name="edittanggal" class="form-control text-capitalize" value="<?= date('d-F-Y') ?>" required readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="editnamacust">Nama Customer</label>
                    <select name="editnamacust" id="editnamacust" class="form-control select2" style="width:100%" required>
                      <option value="<?= $kd->nama_cust ?>" selected><?= strtoupper($kd->nama_cust) ?></option>
                      <option value="" disabled>-Pilih Customer-</option>
                      <?php foreach ($cust as $cust) : ?>
                        <option value="<?= $cust->pengirim ?>"><?= strtoupper($cust->pengirim) ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="editorderno">No Resi</label>
                    <select name="editorderno" id="editorderno" class="form-control select2 editorderno" style="width:100%" required>
                      <option value="" selected disabled>-Pilih Resi -</option>
                      <?php foreach ($resi as $resi) : ?>
                        <option value="<?= $resi->no_order ?>"><?= $resi->no_order ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="editplatno">Plat No</label>
                    <input type="text" name="editplatno" id="editplatno" class="form-control text-uppercase editplatno" placeholder="Plat No.." readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="editnosj">No Surat Jalan</label>
                    <input type="text" name="editnosj" id="editnosj" class="form-control text-uppercase editnosj" placeholder="No Surat Jalan.." readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="editkotatujuan">Kota Tujuan</label>
                    <input type="text" name="editkotatujuan" id="editkotatujuan" class="form-control text-capitalize editkotatujuan" placeholder="Kota Tujuan.." readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="editkotaasal">Kota Asal</label>
                    <input type="text" name="editkotaasal" id="editkotaasal" class="form-control text-capitalize editkotaasal" placeholder="Kota Asal.." readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="editberat">Berat</label>
                    <input type="text" name="editberat" id="editberat" class="form-control text-capitalize editberat" placeholder="Berat.." readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="edithargakg">Ongkos</label>
                    <input type="text" name="edithargakg" id="edithargakg" class="form-control text-capitalize edithargakg" placeholder="Ongkos.." readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="edittagihanorder">Tagihan</label>
                    <input type="text" name="edittagihanorder" id="edittagihanorder" class="form-control text-capitalize edittagihanorder" placeholder="Tagihan.." readonly>
                  </div>
                  <div class="form-group col-md-6" style="margin-bottom: 1rem!important; margin-top: 1.9rem!important;">
                    <button class="btn btn-dark btn-block pt-2 pb-2" style="height: calc(2.5rem + 2px);" type="button" id="tambah-invoice-update" disabled>
                      <i class="fas fa-plus"></i>
                      Tambah Resi
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-item-center justify-content-between">
                  <h5>List Resi</h5>

                  <button type="submit" class="btn btn-warning pt-0 pb-0 text-light inv-update" data-toggle="tooltip" title="Update Data Invoice">
                    <i class="fas fa-pencil-alt"></i>
                    Update Data
                  </button>
                </div>
                <hr>
                <div class="table-responsive">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead align="center">
                      <tr>
                        <td width="25%">
                          <strong>No Resi</strong>
                        </td>
                        <td width="25%">
                          <strong>No SJ</strong>
                        </td>
                        <td width="30%">
                          <strong>Nominal</strong>
                        </td>
                        <td>
                          <strong>Actions</strong>
                        </td>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <?php foreach ($detail as $detail) : ?>
                        <input type="hidden" name="oldresi_hidden[]" value="<?= $detail->no_order ?>" readonly>
                        <tr class="text-center tbdetail">
                          <td class="text-uppercase editorderno">
                            <?= $detail->no_order ?>
                            <input type="hidden" name="editorderno_hidden[]" value="<?= $detail->no_order ?>">
                          </td>
                          <td class="text-uppercase editnosj">
                            <?= $detail->surat_jalan ?>
                            <input type="hidden" name="editnosj_hidden[]" value="<?= $detail->surat_jalan ?>">
                          </td>
                          <td class="text-uppercase edittagihanorder">
                            <?= number_format($detail->total_harga) ?>
                            <input type="hidden" name="edittagihanorder_hidden[]" value="<?= $detail->total_harga ?>">
                          </td>
                          <td class="action">
                            <button type="button" class="btn btn-danger btn-sm" id="btn-hapus-noorder" title="Hapus Resi" data-order="<?= $detail->no_order ?>">
                              <i class="fas fa-times"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                    <tfoot id="tfoot" align="center">
                      <tr>
                        <td colspan="4">
                          <h4 class="font-weight-bold" id="edittotal">
                            <?= number_format($kd->jml_nominal) ?>
                          </h4>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>
  </section>
</div>

<!-- Main Footer -->
<footer class="main-footer">
  <strong>Copyright &copy; 2022
    <a href="https://hira-express.com" class="text-light">Hira Express</a>
  </strong>
  Made With 💖
  <div class="float-right d-none d-sm-inline-block">
    <b>ver</b> 0.1.0
  </div>
</footer>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/') ?>dist/js/adminlte.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- PAGE PLUGINS -->
<script src="<?= base_url('assets/') ?>plugins/select2/js/select2.full.min.js"></script>

<!-- jQuery Mapael -->
<script src="<?= base_url('assets/') ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= base_url('assets/') ?>plugins/raphael/raphael.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<!-- <script src="<?= base_url('assets/') ?>plugins/chart.js/Chart.min.js"></script> -->

<!-- <script src="<?= base_url('assets/') ?>dist/js/pages/dashboard2.js"></script> -->
<script src="<?= base_url('assets/') ?>dist/js/pages/clock.js"></script>
<script src="<?= base_url('assets/') ?>dist/js/pages/number-format.js"></script>
<script src="<?= base_url('assets/') ?>dist/js/pages/update-invoice.js"></script>

<script>
  $(function() {
    $('.select2').select2()
  });
</script>
</body>

</html>