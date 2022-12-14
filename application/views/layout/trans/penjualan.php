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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addPenjualan">
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
                    <th>Jenis</th>
                    <th>Pengirim</th>
                    <th>Penerima</th>
                    <th>Muatan</th>
                    <th>Pembayaran</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($sales as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->no_order) ?></td>
                      <td><?= strtoupper($data->jenis_penjualan) ?></td>
                      <td><?= strtoupper($data->pengirim) ?>-<?= strtoupper($data->kota_asal) ?></td>
                      <td><?= strtoupper($data->penerima) ?>-<?= strtoupper($data->kota_tujuan) ?></td>
                      <td><?= strtoupper($data->muatan) ?></td>
                      <td><?= strtoupper($data->pembayaran) ?></td>
                      <td>Rp. <?= number_format($data->total_harga) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateAdd)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-penjualan" title="Edit" data-id="<?= $data->no_order ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('penjualan/printPenjualan/') . $data->no_order ?>" target="_blank" class="btn btn-sm btn-info text-white" title="Cetak">
                            <i class="fas fa-print"></i>
                          </a>
                          <a href="<?= base_url('penjualan/delete/') . $data->no_order ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addPenjualan -->
<form action="<?= base_url('penjualan') ?>" method="POST">
  <div class="modal fade" id="addPenjualan" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Penjualan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="noorderpenjualan">
                No Order
                <span class="text-white">*</span>
              </label>
              <select name="noorderpenjualan" id="noorderpenjualan" class="form-control select2" style="width:100%" required>
                <option value="" selected disabled>-Pilih No Order-</option>
                <?php foreach ($order as $data) : ?>
                  <option value="<?= $data->no_order ?>"><?= strtoupper($data->no_order) ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="tglorder">
                Tanggal Order
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase tglorder" name="tglorder" placeholder="Tanggal Order.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="pengirim">
                Pengirim
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase pengirim" name="pengirim" placeholder="Nama Pengirim.." readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="kotaasal">
                Kota Asal
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase kotaasal" name="kotaasal" placeholder="Kota Asal..">
            </div>
            <div class="form-group col-md-5">
              <label for="alamatpengirim">
                Alamat Pengirim
                <span class="text-white">*</span>
              </label>
              <textarea name="alamatpengirim" class="form-control text-uppercase alamatpengirim" placeholder="Alamat Pengirim.." style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;" readonly></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="penerima">
                Penerima
                <span class="text-white">*</span>
              </label>
              <input name="penerima" class="form-control text-uppercase" placeholder="Nama Penerima.." required oninvalid="this.setCustomValidity('Nama Penerima wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-3">
              <label for="kotatujuan">
                Kota Tujuan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase kotatujuan" name="kotatujuan" placeholder="Kota Tujuan..">
            </div>
            <div class="form-group col-md-5">
              <label for="alamatpenerima">
                Alamat Penerima
                <span class="text-white">*</span>
              </label>
              <textarea name="alamatpenerima" class="form-control text-uppercase alamatpenerima" placeholder="Alamat Penerima.." required oninvalid="this.setCustomValidity('Alamat Penerima wajib di isi!')" oninput="setCustomValidity('')" style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;" readonly></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="muatan">
                Muatan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase muatan" name="muatan" placeholder="Muatan.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="jenispenjualan">
                Jenis Penjualan
                <span class="text-white">*</span>
              </label>
              <select name="jenispenjualan" id="jenispenjualan" class="form-control text-uppercase" required>
                <option value="" selected disabled>-Pilih Jenis Penjulan-</option>
                <option value="borong">Borongan</option>
                <option value="tonase">Tonase</option>
              </select>
            </div>
          </div>
          <div class="form-row" id="berat-tonase">
            <div class="form-group col-md-6">
              <label for="berat">
                Berat
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase" name="berat" placeholder="Berat dalam Kilo.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="tonase">
                Harga Tonase
                <span class="text-white">*</span>
              </label>
              <input name="tonase" id="tonase" class="form-control text-uppercase" placeholder="Harga Tonase.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4" id="harga-borong">
              <label for="borongan">
                Harga Borong
                <span class="text-white">*</span>
              </label>
              <input name="borongan" id="borongan" class="form-control text-uppercase" placeholder="Harga Borong.." readonly>
            </div>
            <div class="form-group col-md-4" id="total-harga">
              <label for="totalbiaya">
                Total Harga
                <span class="text-white">*</span>
              </label>
              <input name="totalbiaya" id="totalbiaya" class="form-control text-uppercase" placeholder="Total Harga.." readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="pembayaran">
                Pembayaran
                <span class="text-white">*</span>
              </label>
              <select name="pembayaran" class="form-control text-uppercase" required>
                <option value="" selected disabled>-Pilih Pembayaran-</option>
                <option value="lunas">Lunas</option>
                <option value="tempo">Tempo</option>
              </select>
            </div>
          </div>

          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
              <i class="fas fa-save-right ml-1"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- editPenjualan -->
<form action="<?= base_url('penjualan/update') ?>" method="POST">
  <div class="modal fade" id="editPenjualan" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Penjualan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 2rem !important;">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editnoorder">
                No Order
                <span class="text-white">*</span>
              </label>
              <input type="text" name="editnoorder" class="form-control text-uppercase editnoorder" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="edittglorder">
                Tanggal Order
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase edittglorder" name="edittglorder" placeholder="Tanggal Order.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="editpengirim">
                Pengirim
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase editpengirim" name="editpengirim" placeholder="Nama Pengirim.." readonly>
            </div>
            <div class="form-group col-md-3">
              <label for="editkotaasal">
                Kota Asal
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase editkotaasal" name="editkotaasal" placeholder="Kota Asal..">
            </div>
            <div class="form-group col-md-5">
              <label for="editalamatpengirim">
                Alamat Pengirim
                <span class="text-white">*</span>
              </label>
              <textarea name="editalamatpengirim" class="form-control text-uppercase editalamatpengirim" placeholder="Alamat Pengirim.." style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;" readonly></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="editpenerima">
                Penerima
                <span class="text-white">*</span>
              </label>
              <input name="editpenerima" class="form-control text-uppercase editpenerima" placeholder="Nama Penerima.." required oninvalid="this.setCustomValidity('Nama Penerima wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-3">
              <label for="editkotatujuan">
                Kota Tujuan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase editkotatujuan" name="editkotatujuan" placeholder="Kota Tujuan..">
            </div>
            <div class="form-group col-md-5">
              <label for="editalamatpenerima">
                Alamat Penerima
                <span class="text-white">*</span>
              </label>
              <textarea name="editalamatpenerima" class="form-control text-uppercase editalamatpenerima" placeholder="Alamat Penerima.." required oninvalid="this.setCustomValidity('Alamat Penerima wajib di isi!')" oninput="setCustomValidity('')" style="height: calc(2.25rem + 2px) !important; min-height: calc(2.25rem + 2px) !important;" readonly></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editmuatan">
                Muatan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase editmuatan" name="editmuatan" placeholder="Muatan.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="editjenispenjualan">
                Jenis Penjualan
                <span class="text-white">*</span>
              </label>
              <select name="editjenispenjualan" id="editjenispenjualan" class="form-control text-uppercase editjenispenjualan" required>
                <option value="" selected disabled>-Pilih Jenis Penjulan-</option>
                <option value="borong">Borongan</option>
                <option value="tonase">Tonase</option>
              </select>
            </div>
          </div>
          <div class="form-row" id="edit-berat-tonase">
            <div class="form-group col-md-6">
              <label for="editberat">
                Berat
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase editberat" name="editberat" placeholder="Berat dalam Kilo.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="edittonase">
                Harga Tonase
                <span class="text-white">*</span>
              </label>
              <input name="edittonase" id="edittonase" class="form-control text-uppercase edittonase" placeholder="Harga Tonase.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4" id="edit-harga-borong">
              <label for="editborongan">
                Harga Borong
                <span class="text-white">*</span>
              </label>
              <input name="editborongan" id="editborongan" class="form-control text-uppercase editborongan" placeholder="Harga Borong.." readonly>
            </div>
            <div class="form-group col-md-4" id="edit-total-harga">
              <label for="edittotalbiaya">
                Total Harga
                <span class="text-white">*</span>
              </label>
              <input name="edittotalbiaya" id="edittotalbiaya" class="form-control text-uppercase edittotalbiaya" placeholder="Total Harga.." readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="editpembayaran">
                Pembayaran
                <span class="text-white">*</span>
              </label>
              <select name="editpembayaran" class="form-control text-uppercase editpembayaran" required>
                <option value="" selected disabled>-Pilih Pembayaran-</option>
                <option value="lunas">Lunas</option>
                <option value="tempo">Tempo</option>
              </select>
            </div>
          </div>
          <div>
            <button type="submit" class="btn btn-dark float-right">
              Simpan
              <i class="fas fa-save-right ml-1"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>