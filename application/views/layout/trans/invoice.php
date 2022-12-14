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
              <table id="dtable" class="table table-bordered table-striped">
                <thead class="text-center">
                  <tr>
                    <th width="10%">No.</th>
                    <th>No Invoice</th>
                    <th>Customer</th>
                    <th>Jml Resi</th>
                    <th>Jml Tagihan</th>
                    <th>Tanggal</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($invoice as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->kd_inv) ?></td>
                      <td><?= strtoupper($data->nama_customer) ?></td>
                      <td><?= $data->jml_resi ?></td>
                      <td>Rp. <?= number_format($data->jml_nominal) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateAdd)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="<?= base_url('uangmakan/update/') . $data->kd_um ?>" class="btn btn-sm btn-warning text-white btn-edit-um" title="Edit" data-id="<?= $data->kd_um ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="" class="btn btn-sm btn-info text-white btn-detail-um" title="Detail" data-id="<?= $data->kd_um ?>" data-tgl="<?= date('d-m-Y', strtotime(($data->dateAdd))) ?>">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="<?= base_url('uangmakan/delete/') . $data->kd_um ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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


<!-- detailUm -->
<form action="<?= base_url('uangmakan/print') ?>" method="POST">
  <div class="modal fade" id="detailUm">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Detail Uang Makan</h4>
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