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
            <button type="button" class="btn btn-dark border border-light" id="btn_tambah">
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
                <table id="sjTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th class="align-middle">No.</th>
                      <th class="align-middle">No Surat</th>
                      <th class="align-middle">Customer</th>
                      <th class="align-middle">Jumlah Reccu</th>
                      <th class="align-middle">Jumlah SJ</th>
                      <th class="align-middle">Tanggal</th>
                      <th class="align-middle">Aksi</th>
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
        <h4 class="modal-title">Tambah Data Surat Jalan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 1rem 2rem !important;">
        <form id="form_add">
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="pengirim">Pengirim</label>
              <select name="pengirim" id="pengirim" class="form-control select-pengirim" style="width:100%" required>
                <option value=""></option>

              </select>
              <input type="hidden" name="selectedCust" id="selectedCust" class="form-control" required readonly>
              <input type="hidden" name="selectedKodeCust" id="selectedKodeCust" class="form-control" required readonly>
            </div>

            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="reccu">Reccu</label>
              <select name="reccu" id="reccu" class="form-control select-reccu" style="width:100%">
                <option value=""></option>

              </select>
              <input type="hidden" name="selectedReccu" id="selectedReccu" class="form-control" readonly>
              <input type="hidden" name="selectedOrder" id="selectedOrder" class="form-control" readonly>
            </div>

            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="penerima">Penerima</label>
              <input type="text" name="penerima" id="penerima" class="form-control text-uppercase" placeholder="Penerima.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="jenis">Jenis</label>
              <input type="text" name="jenis" id="jenis" class="form-control text-uppercase" placeholder="Jenis.." readonly>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="berat">Berat(Kg)</label>
              <input type="text" name="berat" id="berat" class="form-control text-uppercase" placeholder="Berat(Kg).." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="hrgkg">Harga/Kg</label>
              <input type="text" name="hrgkg" id="hrgkg" class="form-control text-uppercase" placeholder="Harga/Kg.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="hrgbrg">Harga Borong</label>
              <input type="text" name="hrgbrg" id="hrgbrg" class="form-control text-uppercase" placeholder="Harga Borong.." readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="tothrg">Total Harga</label>
              <input type="text" name="tothrg" id="tothrg" class="form-control text-uppercase" placeholder="Total.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md">
              <label for="ket">Keterangan</label>
              <input type="text" name="ket" id="ket" class="form-control text-uppercase" placeholder="Keterangan.." autocomplete="off">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="suratjalan">Surat Jalan</label>
              <input type="text" name="suratjalan" id="suratjalan" class="form-control text-uppercase" placeholder="Surat Jalan.." autocomplete="off">
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="beratsj">Berat/SJ(Kg)</label>
              <input type="text" name="beratsj" id="beratsj" class="form-control text-uppercase" placeholder="Berat/SJ(Kg).." autocomplete="off">
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="retur">Retur</label>
              <input type="text" name="retur" id="retur" class="form-control text-uppercase" placeholder="Retur.." autocomplete="off">
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12 d-flex align-items-end">
              <button type="button" class="btn btn-primary border border-light btn-block mt-4" id="tambah" style="height:calc(1.5em + 0.75rem + 2px);" disabled>
                <i class="fa fa-plus"></i>
                Tambah
              </button>
            </div>
          </div>

          <hr style="border: 1px solid #6c757d;">

          <h5 class="mb-3">List Surat Jalan</h5>
          <div class="table-responsive">
            <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
              <thead class="text-center">
                <tr>
                  <td>
                    <strong>Reccu</strong>
                  </td>
                  <td>
                    <strong>Surat Jalan</strong>
                  </td>
                  <td>
                    <strong>Berat</strong>
                  </td>
                  <td>
                    <strong>Retur</strong>
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
                  <td class="align-middle text-center" colspan="5">
                    <button type="submit" class="btn btn-dark border border-light btn-sm btn-block">
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
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
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
            <p class="text-uppercase font-weight-bold mb-0 nosurat"></p>
            <p class="text-uppercase font-weight-bold mb-0 customer"></p>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
              <th class="align-middle" width="5%" style="border-color: rgb(145, 143, 143) !important;">No.</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Tanggal</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">No Polisi</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Surat Jalan</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Asal-Tujuan</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Berat</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Ongkir</th>
              <th class="align-middle" style="border-color: rgb(145, 143, 143) !important;">Tagihan</th>
            </thead>
            <tbody class="text-center" id="tbodyDetail" style="border:1.5px solid rgb(145, 143, 143) !important;">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modalTandaTerimaInvoice -->
<!-- <div class="modal fade" id="modalTandaTerimaInvoice" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tanda Terima Surat Jalan & Invoice</h4>
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
          <div class="form-group mb-0">
            <legend class="col-form-label font-weight-bold">Jenis Dokumen</legend>
          </div>
          <div class="form-row">
            <div class="form-group col-auto">
              <div class="form-check">
                <input type="radio" name="jenis" id="tandaterima" class="form-check-input form-check-jenis" value="tanda-terima-surat-jalan">
                <label for="tandaterima" class="form-check-label">
                  Tanda Terima
                </label>
              </div>
            </div>
            <div class="form-group col-auto">
              <div class="form-check">
                <input type="radio" name="jenis" id="invoice" class="form-check-input form-check-jenis" value="invoice">
                <label for="invoice" class="form-check-label">
                  Invoice
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" name="dpp" id="dpp" class="form-check-input">
              <label for="dpp" class="form-check-label">
                PPN
              </label>
            </div>
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
</div> -->