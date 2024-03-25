<div class="content-wrapper">
  <div class="inserted" data-flashdata="<?= $this->session->flashdata('inserted'); ?>"></div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <button type="button" class="btn btn-primary border border-light mr-1" id="btn_tandaTerima">
              <i class=" fas fa-print"></i>
              Tanda Terima
            </button>
            <a href="<?= base_url('traveldoc/add') ?>" class="btn btn-dark border border-light">
              <i class=" fas fa-plus"></i>
              Tambah
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <p class="font-italic">#Untuk Searching tanggal, gunakan format Year-month-day</p>
                <table id="sjTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Reccu</th>
                      <th>Jml SJ</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- modalDetail -->
<div class="modal fade" id="modalDetail" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Surat Jalan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 1rem 2rem !important;">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
          <div>
            <small class="text-uppercase mb-0 reccutgl"></small><br>
            <small class="text-uppercase font-weight-bold mb-0 jmlsj"></small>
          </div>
          <button type="submit" class="btn btn-primary border border-light">Print</button>
          <input type="hidden" name="reccu" id="reccu" class="form-control" readonly>
        </div>
        <table class="table table-bordered" width="100%">
          <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
            <th width="10%" style="border-color: rgb(145, 143, 143) !important;">No.</th>
            <th style="border-color: rgb(145, 143, 143) !important;">Reccu</th>
            <th style="border-color: rgb(145, 143, 143) !important;">Surat Jalan</th>
            <th style="border-color: rgb(145, 143, 143) !important;">Berat</th>
            <th style="border-color: rgb(145, 143, 143) !important;">Retur</th>
          </thead>
          <tbody class="text-center" id="tbodyDetail" style="border:1.5px solid rgb(145, 143, 143) !important;">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- modalTandaTerima -->
<div class="modal fade" id="modalTandaTerima" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tanda Terima Surat Jalan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 1rem 2rem !important;">
        <form action="<?= base_url('traveldoc/print') ?>" method="POST" target="_blank">
          <div class="form-group">
            <label for="ttcust">Customer</label>
            <select name="ttcust" id="ttcust" class="form-control select-ttcust" style="width:100%">
              <option value=""></option>

            </select>
            <input type="hidden" name="ttcustname" id="ttcustname" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="ttreccu">Reccu</label>
            <select name="ttreccu[]" id="ttreccu" class="form-control select-ttreccu" style="width:100%" multiple="multiple">
              <option value=""></option>

            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary border border-light btn-block" id="btn_check" disabled>
              <i class="fas fa-print"></i>
              Lihat
          </div>
        </form>
      </div>
    </div>
  </div>
</div>