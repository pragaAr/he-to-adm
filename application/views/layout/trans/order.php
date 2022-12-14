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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addOrder">
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
                    <th>No.</th>
                    <th>No Order</th>
                    <th>Cust</th>
                    <th>Muatan</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($order as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->no_order) ?></td>
                      <td><?= strtoupper($data->nama_cust) ?></td>
                      <td><?= strtoupper($data->jenis_muatan) ?></td>
                      <td><?= strtoupper($data->alamat_asal) ?></td>
                      <td><?= strtoupper($data->alamat_tujuan) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateAdd)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-order" title="Edit" data-id="<?= $data->no_order ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="" class="btn btn-sm btn-info text-white btn-detail-order" title="Detail" data-id="<?= $data->no_order ?>">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="<?= base_url('order/delete/') . $data->no_order ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addOrder -->
<form action="<?= base_url('order') ?>" method="POST">
  <div class="modal fade" id="addOrder" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="noorder">
                No Order
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="noorder" value="<?= $kd ?>" required readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="namacust">
                Customer
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="namacust" placeholder="Nama Customer.." required oninvalid="this.setCustomValidity('Nama Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="notelp">
                No Telepon
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="notelp" placeholder="No Telepon.." required oninvalid="this.setCustomValidity('No Telepon Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-6">
              <label for="muatan">
                Jenis Muatan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="muatan" placeholder="Jenis Muatan.." required oninvalid="this.setCustomValidity('Jenis Muatan wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-group">
            <label for="alamatasal">
              Alamat Asal
              <span class="text-white">*</span>
            </label>
            <textarea name="alamatasal" class="form-control text-uppercase" placeholder="Alamat Asal.." required oninvalid="this.setCustomValidity('Alamat Asal wajib di isi!')" oninput="setCustomValidity('')" style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;"></textarea>
          </div>
          <div class="form-group">
            <label for="alamattujuan">
              Alamat Tujuan
              <span class="text-white">*</span>
            </label>
            <textarea name="alamattujuan" class="form-control text-uppercase" placeholder="Alamat Tujuan.." required oninvalid="this.setCustomValidity('Alamat Tujuan wajib di isi!')" oninput="setCustomValidity('')" style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;"></textarea>
          </div>
          <div>
            <button type="button" id="nextAddOrder" class="btn btn-dark float-right">
              Selanjutnya
              <i class="fas fa-arrow-right ml-1"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addSanguOrder" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Sangu</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="platno">
                Truck
                <span class="text-white">*</span>
              </label>
              <select name="platno" class="form-control text-uppercase select2" style="width: 100%;" required oninvalid="this.setCustomValidity('Plat Nomor wajib di isi!')" oninput="setCustomValidity('')">
                <option value="" selected disabled>-Pilih Truck-</option>
                <?php foreach ($truck as $truck) : ?>
                  <option value="<?= $truck->platno ?>"><?= strtoupper($truck->platno) ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="supir">
                Driver
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="supir" placeholder="Driver.." required oninvalid="this.setCustomValidity('Driver wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="kotaasal">
                Kota Asal
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="kotaasal" placeholder="Kota Asal.." required oninvalid="this.setCustomValidity('Kota Asal Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-6">
              <label for="kotatujuan">
                Kota Tujuan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="kotatujuan" placeholder="Kota Tujuan.." required oninvalid="this.setCustomValidity('Kota Tujuan Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-group">
            <label for="nominal">
              Nominal
              <span class="text-white">*</span>
            </label>
            <input type="text" name="nominal" id="nominal" class="form-control" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
            </button>
            <button type="button" id="backAddOrder" class="btn btn-dark float-right mr-2">
              <i class="fas fa-arrow-left mr-1"></i>
              Kembali
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- editOrder -->
<form action="<?= base_url('order/update') ?>" method="POST">
  <div class="modal fade" id="editOrder" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="noorder">
                No Order
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase noorder" name="noorder" required readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="namacust">
                Customer
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase namacust" name="namacust" placeholder="Nama Customer.." required oninvalid="this.setCustomValidity('Nama Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="notelp">
                No Telepon
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase notelp" name="notelp" placeholder="No Telepon.." required oninvalid="this.setCustomValidity('No Telepon Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-6">
              <label for="muatan">
                Jenis Muatan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase muatan" name="muatan" placeholder="Jenis Muatan.." required oninvalid="this.setCustomValidity('Jenis Muatan wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-group">
            <label for="alamatasal">
              Alamat Asal
              <span class="text-white">*</span>
            </label>
            <textarea name="alamatasal" class="form-control text-uppercase alamatasal" placeholder="Alamat Asal.." required oninvalid="this.setCustomValidity('Alamat Asal wajib di isi!')" oninput="setCustomValidity('')" style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;"></textarea>
          </div>
          <div class="form-group">
            <label for="alamattujuan">
              Alamat Tujuan
              <span class="text-white">*</span>
            </label>
            <textarea name="alamattujuan" class="form-control text-uppercase alamattujuan" placeholder="Alamat Tujuan.." required oninvalid="this.setCustomValidity('Alamat Tujuan wajib di isi!')" oninput="setCustomValidity('')" style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;"></textarea>
          </div>
          <div>
            <button type="button" id="nextUpdateOrder" class="btn btn-dark float-right">
              Selanjutnya
              <i class="fas fa-arrow-right ml-1"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editSanguOrder" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Sangu</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="platno">
                Truck
                <span class="text-white">*</span>
              </label>
              <select name="platno" class="form-control text-uppercase select2 platno" style="width: 100%;" required oninvalid="this.setCustomValidity('Plat Nomor wajib di isi!')" oninput="setCustomValidity('')">
                <option value="" selected disabled>-Pilih Truck-</option>
                <?php foreach ($truckedit as $truck) : ?>
                  <option value="<?= $truck->platno ?>"><?= strtoupper($truck->platno) ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="supir">
                Driver
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase supir" name="supir" placeholder="Driver.." required oninvalid="this.setCustomValidity('Driver wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="kotaasal">
                Kota Asal
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase kotaasal" name="kotaasal" placeholder="Kota Asal.." required oninvalid="this.setCustomValidity('Kota Asal Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-6">
              <label for="kotatujuan">
                Kota Tujuan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase kotatujuan" name="kotatujuan" placeholder="Kota Tujuan.." required oninvalid="this.setCustomValidity('Kota Tujuan Customer wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-group">
            <label for="nominal">
              Nominal
              <span class="text-white">*</span>
            </label>
            <input type="text" name="nominal" id="nominal-order" class="form-control nominal" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
            </button>
            <button type="button" id="backUpdateOrder" class="btn btn-dark float-right mr-2">
              <i class="fas fa-arrow-left mr-1"></i>
              Kembali
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- detailOrder -->
<form action="<?= base_url('order/printOrder') ?>" method="post">
  <div class="modal fade" id="detailOrder" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <h5>Data Order</h5>
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>No Order</th>
                    <th>Muatan</th>
                    <th>Customer</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-uppercase">
                    <td class="noorder"></td>
                    <td class="muatan"></td>
                    <td class="namacust"></td>
                    <td class="alamatasal"></td>
                    <td class="alamattujuan"></td>
                    <td class="tanggal"></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-lg-12 col-md-12">
              <h5>Data Sangu</h5>
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>No Order</th>
                    <th>Truck</th>
                    <th>Supir</th>
                    <th>Kota Asal</th>
                    <th>Kota Tujuan</th>
                    <th>Nominal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-uppercase">
                    <td class="noorder"></td>
                    <td class="truck"></td>
                    <td class="supir"></td>
                    <td class="kotaasal"></td>
                    <td class="kotatujuan"></td>
                    <td class="nominalsangu"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <input type="hidden" name="noorderprint" class="form-control noorderprint">

              <button type="submit" formtarget="_blank" class="btn btn-dark float-right">
                <i class="fas fa-print"></i>
                Cetak
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>