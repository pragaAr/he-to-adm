<div class="content-wrapper">
  <div class="storedPersen" data-flashdata="<?= $this->session->flashdata('storedPersen'); ?>"></div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('persensopir/add') ?>" class="btn btn-dark border border-light">
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
                <table id="persenTables" class="table table-bordered table-striped" style="width:100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kd</th>
                      <th>Sopir</th>
                      <th>Jml Order</th>
                      <th>Total Diterima</th>
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

<!-- detailPersenSopir -->
<form action="<?= base_url('persensopir/print') ?>" method="POST" target="_blank">
  <div class="modal fade" id="detailPersenSopir">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Persen Sopir</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
            <div class="font-weight-bold">
              <p class="text-uppercase kd_persen"></p>
              <p class="text-uppercase tgl_oersen"></p>
            </div>
            <button type="submit" class="btn btn-primary">Print</button>
            <input type="hidden" name="kd_persen" class="form-control kd_persen" readonly>
          </div>
          <table class="table table-bordered" width="100%">
            <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
              <th width="10%" style="border-color: rgb(145, 143, 143) !important;">No</th>
              <th style="border-color: rgb(145, 143, 143) !important;">Nama Sopir</th>
              <th style="border-color: rgb(145, 143, 143) !important;">Nominal</th>
            </thead>
            <tbody class="text-center tbody-detail-persen" style="border:1.5px solid rgb(145, 143, 143) !important;">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</form>