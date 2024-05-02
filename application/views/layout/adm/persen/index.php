<div class="content-wrapper">
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
                <p class="font-italic">#Untuk Searching tanggal, gunakan format Year-month-day</p>
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

<!-- modalDetail -->
<div class="modal fade" id="modalDetail" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
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
            <p class="text-uppercase kd-sopir"></p>
          </div>
        </div>
        <table class="table table-bordered" width="100%">
          <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
            <th class="align-middle" width="10%" style="border-color: rgb(145, 143, 143) !important;">No</th>
            <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">No Order</th>
            <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Platno</th>
            <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Persen 1</th>
            <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Persen 2</th>
            <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Biaya</th>
            <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Sangu</th>
            <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Total Diterima</th>
          </thead>
          <tbody class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;" id="tbodyDetail">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>