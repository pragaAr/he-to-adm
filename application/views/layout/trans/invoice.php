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
            <a href="<?= base_url('invoice/addInvoice') ?>" class="btn btn-dark">
              <i class=" fas fa-plus"></i>
              Buat Invoice
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
              <table id="dtable" class="table table-bordered table-striped">
                <thead class="text-center">
                  <tr>
                    <th>No.</th>
                    <th>No Inv</th>
                    <th>Cust</th>
                    <th>Jml Resi</th>
                    <th>Tagihan</th>
                    <th>Tanggal</th>
                    <th width="15%">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
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
                          <a href="" class="btn btn-sm btn-info text-white btn-detail-inv" title="Detail" data-id="<?= $data->kd_inv ?>">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="<?= base_url('invoice/delete/') . $data->kd_inv ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- detailInv -->
<form action="<?= base_url('invoice/print') ?>" method="POST">
  <div class="modal fade" id="detailInv">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Detail Invoice</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="font-weight-bold mb-3">
            <p class="text-uppercase kd_um"></p>
            <p class="text-uppercase tgl_um"></p>
          </div>
          <table class="table table-bordered" width="100%">
            <thead class="text-center" style="border:1.5px solid rgb(145, 143, 143) !important;">
              <th style="border-color: rgb(145, 143, 143) !important;">Penerima</th>
              <th style="border-color: rgb(145, 143, 143) !important;">Nominal</th>
            </thead>
            <tbody class="text-center tbody-detail-um" style="border:1.5px solid rgb(145, 143, 143) !important;">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- updateInvoice -->
<form action="<?= base_url('invoice/prosesUpdate') ?>" method="post">
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
</form>