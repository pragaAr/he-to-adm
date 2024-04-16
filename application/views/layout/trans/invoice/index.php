<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('invoice/addInvoice') ?>" class="btn btn-dark border border-light" id="btn_tambah">
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
                <table id="invTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead class="text-center">
                    <tr>
                      <th class="align-middle">No.</th>
                      <th class="align-middle">No. Inv</th>
                      <th class="align-middle">Customer</th>
                      <th class="align-middle">Jml Surat Jalan</th>
                      <th class="align-middle">Tagihan</th>
                      <th class="align-middle">Tanggal</th>
                      <th class="align-middle">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <!-- <?php $no = 1;
                          foreach ($invoice as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->kd_inv) ?></td>
                      <td><?= strtoupper($data->nama_cust) ?></td>
                      <td><?= $data->jml_resi ?></td>
                      <td>Rp. <?= number_format($data->jml_nominal) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateAdd)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white" id="btn-update-invoice" title=" Edit" data-id="<?= $data->kd_inv ?>" data-cust="<?= $data->nama_cust ?>" data-resi="<?= $data->jml_resi ?>" data-total="<?= $data->jml_nominal ?>" data-tgl="<?= $data->dateAdd ?>">
                            <i class=" fas fa-pencil-alt"></i>
                          </a>
                          <a href="" class="btn btn-sm btn-info text-white btn-detail-inv" title="Detail" data-id="<?= $data->kd_inv ?>" data-cust="<?= $data->nama_cust ?>">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="<?= base_url('invoice/delete/') . $data->kd_inv ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php $no++ ?>
                  <?php endforeach ?> -->
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
        <h4 class="modal-title">Buat Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 1rem 2rem !important;">
        <form id="form_add">
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="cust">Customer</label>
              <select name="cust" id="cust" class="form-control select-cust" style="width:100%" required>
                <option value=""></option>

              </select>
              <input type="hidden" name="selectedCust" id="selectedCust" class="form-control" required readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="reccu">Reccu</label>
              <select name="reccu" id="reccu" class="form-control select-reccu" style="width:100%" required>
                <option value=""></option>

              </select>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="penerima">Penerima</label>
              <input type="text" name="penerima" id="penerima" class="form-control text-capitalize" placeholder="Penerima.." required readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="jenis">Jenis</label>
              <input type="text" name="jenis" id="jenis" class="form-control text-capitalize" placeholder="Jenis.." required readonly>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="berat">Berat(Kg)</label>
              <input type="text" name="berat" id="berat" class="form-control" placeholder="Berat(Kg).." required readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="hrgkg">Harga/Kg</label>
              <input type="text" name="hrgkg" id="hrgkg" class="form-control" placeholder="Harga/Kg.." required readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="hrgbrg">Harga Borong</label>
              <input type="text" name="hrgbrg" id="hrgbrg" class="form-control" placeholder="Harga Borong.." required readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="tothrg">Total Harga</label>
              <input type="text" name="tothrg" id="tothrg" class="form-control" placeholder="Total.." required readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
              <label for="suratjalan">Surat Jalan</label>
              <select name="suratjalan" id="suratjalan" class="form-control select-suratjalan" style="width:100%" required>
                <option value=""></option>

              </select>
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
              <tbody>
              </tbody>
              <tfoot id="tfoot">
                <tr>
                  <td class="text-center">
                  </td>
                  <td class="align-middle">
                  </td>
                  <td class="align-middle">
                  </td>
                  <td class="align-middle text-center">
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

<!-- detailInv -->
<!-- <form action="<?= base_url('invoice/print') ?>" method="POST" target="_blank">
  <div class="modal fade" id="detailInv">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Invoice</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="font-weight-bold mb-3 d-flex justify-content-between align-items-center">
            <p class="text-uppercase custname"></p>
            <input type="hidden" class="form-control" name="kdinv" readonly>
            <button type="submit" class="btn btn-info" id="printinv" title="Print-invoice">
              <i class="fas fa-print"></i>
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" width="100%">
              <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
                <th style="border-color: rgb(145, 143, 143) !important;">No</th>
                <th style="border-color: rgb(145, 143, 143) !important;">Tgl</th>
                <th style="border-color: rgb(145, 143, 143) !important;">No SJ</th>
                <th style="border-color: rgb(145, 143, 143) !important;">Truck</th>
                <th style="border-color: rgb(145, 143, 143) !important;">No Resi</th>
                <th style="border-color: rgb(145, 143, 143) !important;">Asal - Tujuan</th>
                <th style="border-color: rgb(145, 143, 143) !important;">Berat</th>
                <th style="border-color: rgb(145, 143, 143) !important;">Ongkos</th>
                <th style="border-color: rgb(145, 143, 143) !important;">Tagihan</th>
              </thead>
              <tbody class="text-center tbody-detail-inv" style="border:1.5px solid rgb(145, 143, 143) !important;">
              </tbody>
              <tfoot align="center">
                <tr id="tfootdetailinv">
                  <td colspan="9" class="font-weight-bold" id="total">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</form> -->

<!-- updateInvoice -->
<!-- <form action="<?= base_url('invoice/prosesUpdate') ?>" method="post">
  <div class="modal fade" id="updateInvoice">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Invoice</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="row">
            <div class="col-lg-6">
              <div class="card" style="box-shadow: 0 0 1px rgb(0 0 0 / 40%), 0 1px 3px rgb(255 255 255 / 40%) !important;">
                <div class="card-body">
                  <div class="form-row">
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="editkd">No Inv</label>
                      <input type="text" name="editkd" class="form-control text-uppercase editkd" readonly>
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="edittanggal">Tanggal</label>
                      <input type="text" name="edittanggal" class="form-control text-capitalize edittanggal" readonly>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-lg-7 col-md-12">
                      <label for="editnamacust">Nama Customer</label>
                      <input type="text" name="editnamacust" class="form-control text-uppercase editnamacust" readonly>
                    </div>
                    <div class="form-group col-lg-5 col-md-12">
                      <label for="editorderno">No Resi</label>
                      <select name="editorderno" id="editorderno" class="form-control select2 editorderno" style="width:100%">
                        <option value="" selected disabled>-Pilih Resi -</option>
                        <?php foreach ($resi as $resi) : ?>
                          <option value="<?= $resi->no_order ?>"><?= $resi->no_order ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="editplatno">Plat No</label>
                      <input type="text" name="editplatno" id="editplatno" class="form-control text-uppercase editplatno" placeholder="Plat No.." readonly>
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="editnosj">No Surat Jalan</label>
                      <input type="text" name="editnosj" id="editnosj" class="form-control text-uppercase editnosj" placeholder="No Surat Jalan.." readonly>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="editkotatujuan">Kota Tujuan</label>
                      <input type="text" name="editkotatujuan" id="editkotatujuan" class="form-control text-capitalize editkotatujuan" placeholder="Kota Tujuan.." readonly>
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="editkotaasal">Kota Asal</label>
                      <input type="text" name="editkotaasal" id="editkotaasal" class="form-control text-capitalize editkotaasal" placeholder="Kota Asal.." readonly>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="editberat">Berat</label>
                      <input type="text" name="editberat" id="editberat" class="form-control text-capitalize editberat" placeholder="Berat.." readonly>
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="edithargakg">Ongkos</label>
                      <input type="text" name="edithargakg" id="edithargakg" class="form-control text-capitalize edithargakg" placeholder="Ongkos.." readonly>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-lg-6 col-md-12">
                      <label for="edittagihanorder">Tagihan</label>
                      <input type="text" name="edittagihanorder" id="edittagihanorder" class="form-control text-capitalize edittagihanorder" placeholder="Tagihan.." readonly>
                    </div>
                    <div class="form-group col-lg-6 col-md-12" style="margin-bottom: 1rem!important; margin-top: 1.9rem!important;">
                      <button class="btn btn-dark btn-block pt-2 pb-2" style="height: calc(2.5rem + 2px);" type="button" id="tambah-invoice-update" disabled>
                        <i class="fas fa-plus"></i>
                        Tambah Resi
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card" style="box-shadow: 0 0 1px rgb(0 0 0 / 40%), 0 1px 3px rgb(255 255 255 / 40%) !important;">
                <div class="card-body">
                  <div class="d-flex align-item-center justify-content-between">
                    <h5>List Resi</h5>
                    <input type="hidden" class="form-control" name="edittotal_hidden" value="">
                    <input type="hidden" class="form-control" name="editcust_hidden" value="">
                    <button type="submit" class="btn btn-warning pt-0 pb-0 text-light" id="btnupdate" data-toggle="tooltip" title="Update Data Invoice">
                      <i class="fas fa-pencil-alt"></i>
                      Update Data
                    </button>
                  </div>
                  <hr>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="cartinv" width="100%" cellspacing="0">
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
                      <tbody class="text-center tbody-cart-inv">

                      </tbody>
                      <tfoot align="center">
                        <tr id="tfootinv">
                          <td colspan="4" class="font-weight-bold" id="edittotal">
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form> -->