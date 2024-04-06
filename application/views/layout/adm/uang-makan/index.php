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
            <button type="button" class="btn btn-dark border border-light" id="btn_tambahData">
              <i class=" fas fa-plus"></i>
              Tambah
            </button>
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
                <table id="umTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode</th>
                      <th>Penerima</th>
                      <th>Total</th>
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

<!-- modalAdd -->
<div class="modal fade" id="modalAdd" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Uang Makan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 1rem 2rem !important;">
        <form id="form_add">
          <div class="form-row">
            <div class="form-group col-lg-4 col-md-4 col-sm">
              <label for="kd">Kode</label>
              <input type="text" name="kd" id="kd" class="form-control text-uppercase" required readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm">
              <label for="user">Admin</label>
              <input type="text" name="user" id="user" class="form-control text-capitalize" value="<?= $this->session->userdata('nama') ?>" required readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm">
              <label for="tgl">Tanggal</label>
              <input type="text" name="tgl" id="tgl" class="form-control" value="<?= date('d-m-Y') ?>" required readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-4 col-md-4 col-sm">
              <label for="nominal">Nominal</label>
              <input type="text" name="nominal" id="nominal" class="form-control text-capitalize" placeholder="Nominal.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm">
              <label for="kryid">Karyawan</label>
              <select name="kryid" id="kryid" class="form-control select-karyawan" style="width:100%;">
                <option value=""></option>
              </select>
              <input type="hidden" class="form-control" name="namakry" id="namakry" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm d-flex align-items-end">
              <button type="button" class="btn btn-primary border border-light btn-block mt-4" id="tambah" style="height:calc(1.5em + 0.75rem + 2px);" disabled>
                <i class="fa fa-plus"></i>
                Tambah
              </button>
            </div>
          </div>

          <hr style="border: 1px solid #6c757d;">

          <h5 class="mb-3">List Penerima Uang Makan</h5>
          <div class="table-responsive">
            <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
              <thead class="text-center">
                <tr>
                  <td width="40%">
                    <strong>Penerima</strong>
                  </td>
                  <td width="40%">
                    <strong>Nominal</strong>
                  </td>
                  <td>
                    <strong>Aksi</strong>
                  </td>
                </tr>
              </thead>
              <tbody id="tbody">
              </tbody>
              <tfoot id="tfoot">
                <tr>
                  <td class="text-center">
                    <h4 class="font-weight-bold">Total</h4>
                  </td>
                  <td class="align-middle">
                    <h4 class="font-weight-bold text-right pr-2" id="total"></h4>
                  </td>
                  <td class="align-middle text-center">
                    <input type="hidden" name="total_hidden" id="total_hidden" value="">
                    <button type="submit" class="btn btn-dark border border-light btn-sm">
                      Simpan
                    </button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modalDetail -->
<div class="modal fade" id="modalDetail" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Uang Makan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 1rem 2rem !important;">
        <form action="<?= base_url('uangmakan/print') ?>" method="POST" target="_blank">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <div>
              <small class="text-uppercase mb-0 kdtgl"></small><br>
              <small class="text-uppercase font-weight-bold mb-0 total"></small>
            </div>
            <button type="submit" class="btn btn-primary border border-light">Print</button>
            <input type="hidden" name="kdum" id="kdum" class="form-control" readonly>
          </div>
          <table class="table table-bordered" width="100%">
            <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
              <th width="10%" style="border-color: rgb(145, 143, 143) !important;">No.</th>
              <th style="border-color: rgb(145, 143, 143) !important;">Penerima</th>
              <th style="border-color: rgb(145, 143, 143) !important;">Nominal</th>
            </thead>
            <tbody class="text-center" id="tbodyDetail" style="border:1.5px solid rgb(145, 143, 143) !important;">
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>