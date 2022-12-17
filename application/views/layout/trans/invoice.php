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
                          <!-- <div class="btn-group" role="group">
                          <a href="<?= base_url('invoice/update/') . $data->kd_inv ?>" class="btn btn-sm btn-warning text-white" title=" Edit">
                            <i class="fas fa-pencil-alt"></i>
                          </a> -->
                          <a href="" class="btn btn-sm btn-info text-white btn-detail-inv" title="Detail" data-id="<?= $data->kd_inv ?>" data-tgl="<?= date('d-m-Y', strtotime(($data->dateAdd))) ?>">
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
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Update Invoice</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="editkd">No Inv</label>
                      <input type="text" name="editkd" class="form-control text-uppercase editkd" required readonly>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="edittanggal">Tanggal</label>
                      <input type="text" name="edittanggal" class="form-control text-capitalize edittanggal" required readonly>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="editnamacust">Nama Customer</label>
                      <select name="editnamacust" id="editnamacust" class="form-control select2 editnamacust" style="width:100%" required>
                        <option value="" disabled>-Pilih Customer-</option>
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
        </div>
      </div>
    </div>
  </div>
</form>