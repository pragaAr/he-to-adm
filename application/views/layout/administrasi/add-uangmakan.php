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
            <a href="<?= base_url('uangmakan') ?>" class="btn btn-dark">
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
      <form action="<?= base_url('uangmakan/prosesAdd') ?>" method="post">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <label for="kdum">No UM</label>
                  <input type="text" name="kdum" class="form-control text-uppercase" value="<?= $kdum ?>" required readonly>
                </div>
                <div class="form-group">
                  <label for="user">Admin</label>
                  <input type="text" name="user" class="form-control text-capitalize" value="<?= $this->session->userdata('namauser') ?>" required readonly>
                </div>
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input type="text" name="tanggal" class="form-control text-capitalize" value="<?= date('d-F-Y') ?>" required readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <label for="nominal">Nominal</label>
                  <input type="text" name="nominal" id="nominal" class="form-control text-capitalize" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')" autofocus>
                </div>
                <div class="form-group">
                  <label for="karyawan">Nama Karyawan</label>
                  <select name="karyawan" id="karyawan" class="form-control select2" style="width:100%;" required>
                    <option value="" selected disabled>-Pilih Karyawan-</option>
                    <?php foreach ($karyawan as $data) : ?>
                      <option value="<?= $data->id_karyawan ?>"><?= strtoupper($data->nama) ?></option>
                    <?php endforeach ?>
                  </select>
                  <input type="hidden" name="namakaryawan" class="form-control" readonly>
                </div>
                <div class="form-group mt-5" style="margin-bottom: 1rem!important;">
                  <button class="btn btn-dark btn-block pt-2 pb-2" style="height: calc(2.25rem + 2px);" type="button" id="tambah" disabled>
                    <i class="fas fa-plus"></i>
                    Tambah
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg">
            <div class="card card-danger">
              <div class="card-body">
                <h5>List Penerima Uang Makan</h5>
                <hr>
                <div class="table-responsive">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead align="center">
                      <tr>
                        <td width="40%">
                          <strong>Penerima</strong>
                        </td>
                        <td width="40%">
                          <strong>Nominal</strong>
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
                          <input type="hidden" name="total_hidden" value="">
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
  Made With ????
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
<script src="<?= base_url('assets/') ?>dist/js/pages/uangmakan.js"></script>

<script>
  $(function() {
    $('.select2').select2()
  });
</script>
</body>

</html>