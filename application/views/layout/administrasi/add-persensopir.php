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
            <a href="<?= base_url('persensopir') ?>" class="btn btn-dark">
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
      <form action="<?= base_url('persensopir/prosesAdd') ?>" method="post">
        <div class="row">
          <div class="col-lg col-md">
            <div class="card">
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="kdpersen">Kd Persen</label>
                    <input type="text" name="kdpersen" class="form-control text-uppercase" value="<?= $kdpersen ?>" required readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="user">Admin</label>
                    <input type="text" name="user" class="form-control text-capitalize" value="<?= $this->session->userdata('namauser') ?>" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="tanggal">Tanggal</label>
                    <input type="text" name="tanggal" class="form-control text-capitalize" value="<?= date('d-F-Y') ?>" readonly>
                  </div>
                </div>
                <h6 class="font-weight-bold">Data Order</h6>
                <hr class="bg-secondary">
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="sopir">Nama Sopir</label>
                    <select name="sopir" id="sopir" class="form-control select2" style="width:100%;" required>
                      <option value="" selected disabled>-Pilih Sopir-</option>
                      <?php foreach ($sopir as $data) : ?>
                        <option value="<?= $data->id_sopir ?>"><?= ucwords($data->nama_sopir) ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="noorder">No Order</label>
                    <select name="noorder" id="noorder" class="form-control select2" style="width:100%;">
                      <option value="" selected disabled>-Pilih No Order-</option>

                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="pengirim">Pengirim</label>
                    <input type="text" name="pengirim" class="form-control text-capitalize pengirim" readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="asaltujuan">Asal - Tujuan</label>
                    <input type="text" name="asaltujuan" class="form-control text-capitalize asaltujuan" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="muatan">Muatan</label>
                    <input type="text" name="muatan" class="form-control text-capitalize muatan" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="totalharga">Total Harga</label>
                    <input type="text" name="totalharga" class="form-control text-capitalize totalharga" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="jumlahpersen">Jumlah Persen</label>
                    <input type="text" name="jumlahpersen" class="form-control text-capitalize jumlahpersen" readonly>
                  </div>
                </div>
                <h6 class="font-weight-bold">Data Sangu</h6>
                <hr class="bg-secondary">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="sangu">Kas Bon Sangu</label>
                    <input type="text" name="sangu" class="form-control text-capitalize sangu" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="tambahan">Tambahan</label>
                    <input type="text" name="tambahan" class="form-control text-capitalize tambahan" readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="jumlahsangu">Jumlah Sangu</label>
                    <input type="text" name="jumlahsangu" class="form-control text-capitalize jumlahsangu" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md">
                    <label for="jumlahterima">Jumlah Diterima</label>
                    <input type="text" name="jumlahterima" class="form-control text-capitalize jumlahterima" readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md">
                    <button type="button" class="btn btn-primary btn-block" id="btn-persen" disabled>Tambah</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg">
            <div class="card card-danger">
              <div class="card-body">
                <h5>List Persen Sopir</h5>
                <div class="table-responsive mt-4">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead align="center">
                      <tr>
                        <td width="40%">
                          <strong>No Order</strong>
                        </td>
                        <td width="40%">
                          <strong>Nominal Diterima</strong>
                        </td>
                        <td>
                          <strong>Actions</strong>
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot id="tfoot" align="center">
                      <tr>
                        <td colspan="2">
                          <h4 class="font-weight-bold" id="total"></h4>
                        </td>
                        <td>
                          <input type="text" name="total_hidden" value="">
                          <button type="submit" class="btn btn-dark btn-sm" data-toggle="tooltip" title="Simpan">
                            <i class="fas fa-save"></i>
                            Simpan
                          </button>
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
  <strong>Copyright &copy; 2022 <a href="https://hira-express.com">Hira Express</a></strong>
  Made With 💖
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 0.1.0
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
<script src="<?= base_url('assets/') ?>dist/js/pages/persensopir.js"></script>

<script>
  $(function() {
    $('.select2').select2()
  });
</script>
</body>

</html>