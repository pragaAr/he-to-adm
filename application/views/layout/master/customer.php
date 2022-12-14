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
              <table id="example1" class="table table-bordered table-striped">
                <thead class="text-center">
                  <tr>
                    <th width="10%">No.</th>
                    <th>Asal Cust</th>
                    <th>Nama Cust</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($cust as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->nama_cab) ?></td>
                      <td><?= strtoupper($data->nama_customer) ?></td>
                      <td><?= strtoupper($data->alamat) ?></td>
                      <td><?= $data->notelp ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-customer" title="Edit" data-id="<?= $data->id_customer ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('customer/delete/') . $data->id_customer ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- editCustomer -->
<form action="<?= base_url('customer/update') ?>" method="POST">
  <div class="modal fade" id="editCustomer" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Customer</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">
              Nama Customer
              <span class="text-white">*</span>
            </label>
            <input type="hidden" class="form-control idcustomer" name="idcustomer">
            <input type="text" class="form-control text-uppercase nama" name="nama" placeholder="Nama Customer..">
          </div>
          <div class="form-group">
            <label for="notelp">
              No Telepon
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control notelp" name="notelp" placeholder="No Telepon..">
          </div>
          <div class="form-group">
            <label for="alamat">
              Alamat
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-capitalize alamat" name="alamat" placeholder="Alamat..">
          </div>
          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>