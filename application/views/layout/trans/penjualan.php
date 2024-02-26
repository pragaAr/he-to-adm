<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <button type="button" class="btn btn-dark border border-light" id="addPenjualan">
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
                <table id="salesTables" class="table table-bordered table-striped" style="width:100%" cellspacing="0">
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
                  <tbody class="text-center" style="font-size:12px;">

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

<!-- modalAddPenjualan -->
<div class="modal fade" id="modalAddPenjualan" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Penjualan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:1rem 2rem;">
        <form id="form_add">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="noorder">
                No Order
              </label>
              <select name="noorder" id="noorder" class="form-control select-noorder" style="width:100%" required>
                <option value=""></option>

              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="tglorder">
                Tanggal Order
              </label>
              <input type="text" class="form-control text-uppercase" name="tglorder" id="tglorder" placeholder="Tanggal Order.." readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="pengirim">
                Customer Order
              </label>
              <input type="text" class="form-control text-uppercase" name="pengirim" id="pengirim" placeholder="Nama Pengirim.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="asal">
                Asal
              </label>
              <input type="text" class="form-control text-uppercase" name="asal" id="asal" placeholder="Asal.." readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="tujuan">
                Tujuan
              </label>
              <input type="text" class="form-control text-uppercase" name="tujuan" id="tujuan" placeholder="Tujuan.." readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="muatan">
                Muatan
              </label>
              <input type="text" class="form-control text-uppercase" name="muatan" id="muatan" placeholder="Muatan.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="alamatasal">
                Alamat Asal
              </label>
              <input type="text" class="form-control text-uppercase" name="alamatasal" id="alamatasal" placeholder="Alamat Asal.." required autocomplete="off">
            </div>
            <div class="form-group col-lg-6">
              <label for="alamattujuan">
                Alamat Tujuan
              </label>
              <input type="text" class="form-control text-uppercase" name="alamattujuan" id="alamattujuan" placeholder="Alamat Tujuan.." required autocomplete="off">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="nosj">
                No Surat Jalan
              </label>
              <input type="text" class="form-control text-uppercase" name="nosj" id="nosj" placeholder="No Surat Jalan.." required autocomplete="off">
            </div>
            <div class="form-group col-md-4">
              <label for="penerima">
                Penerima
              </label>
              <input name="penerima" id="penerima" class="form-control text-uppercase" placeholder="Nama Penerima.." required autocomplete="off" oninvalid="this.setCustomValidity('Nama Penerima wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-4">
              <label for="jenis">
                Jenis Penjualan
              </label>
              <select name="jenis" id="jenis" class="form-control text-uppercase select-jenis" style="width:100%" required>
                <option value=""></option>
                <option value="borong">Borongan</option>
                <option value="tonase">Tonase</option>
              </select>
            </div>
          </div>
          <div class="form-row" id="berat-tonase">
            <div class="form-group col-md-6">
              <label for="berat">
                Berat
              </label>
              <input type="text" class="form-control text-uppercase" name="berat" id="berat" placeholder="Berat dalam Kilo.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="tonase">
                Harga Tonase
              </label>
              <input name="tonase" id="tonase" class="form-control text-uppercase" placeholder="Harga Tonase.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4" id="harga-borong">
              <label for="borong">
                Harga Borong
              </label>
              <input name="borong" id="borong" class="form-control text-uppercase" placeholder="Harga Borong.." readonly>
            </div>
            <div class="form-group col-md-4" id="total-harga">
              <label for="biaya">
                Total Harga
              </label>
              <input name="biaya" id="biaya" class="form-control text-uppercase" placeholder="Total Harga.." readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="pembayaran">
                Pembayaran
              </label>
              <select name="pembayaran" id="pembayaran" class="form-control text-uppercase select-pembayaran" style="width:100%" required>
                <option value=""></option>
                <option value="lunas">Lunas</option>
                <option value="tempo">Tempo</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-dark border border-light float-right">
              Simpan
              <i class="fas fa-save-right ml-1"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

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
              </label>
              <input type="text" name="editnoorder" class="form-control text-uppercase editnoorder" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="edittglorder">
                Tanggal Order
              </label>
              <input type="text" class="form-control text-uppercase edittglorder" name="edittglorder" placeholder="Tanggal Order.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editpengirim">
                Pengirim
              </label>
              <input type="text" class="form-control text-uppercase editpengirim" name="editpengirim" placeholder="Nama Pengirim.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="editpenerima">
                Penerima
              </label>
              <input name="editpenerima" class="form-control text-uppercase editpenerima" placeholder="Nama Penerima.." required oninvalid="this.setCustomValidity('Nama Penerima wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="editkotaasal">
                Kota Asal
              </label>
              <input type="text" class="form-control text-uppercase editkotaasal" name="editkotaasal" placeholder="Kota Asal..">
            </div>
            <div class="form-group col-md-4">
              <label for="editkotatujuan">
                Kota Tujuan
              </label>
              <input type="text" class="form-control text-uppercase editkotatujuan" name="editkotatujuan" placeholder="Kota Tujuan..">
              <input type="hidden" class="form-control text-uppercase editalamatpengirim" name="editalamatpengirim" readonly>
              <input type="hidden" class="form-control text-uppercase editalamattujuan" name="editalamattujuan" readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="editnosj">
                No Surat Jalan
              </label>
              <input type="text" class="form-control text-uppercase editnosj" name="editnosj" placeholder="No Surat Jalan..">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editmuatan">
                Muatan
              </label>
              <input type="text" class="form-control text-uppercase editmuatan" name="editmuatan" placeholder="Muatan.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="editjenispenjualan">
                Jenis Penjualan
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
              </label>
              <input type="text" class="form-control text-uppercase editberat" name="editberat" placeholder="Berat dalam Kilo.." readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="edittonase">
                Harga Tonase
              </label>
              <input name="edittonase" id="edittonase" class="form-control text-uppercase edittonase" placeholder="Harga Tonase.." readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4" id="edit-harga-borong">
              <label for="editborongan">
                Harga Borong
              </label>
              <input name="editborongan" id="editborongan" class="form-control text-uppercase editborongan" placeholder="Harga Borong.." readonly>
            </div>
            <div class="form-group col-md-4" id="edit-total-harga">
              <label for="edittotalbiaya">
                Total Harga
              </label>
              <input name="edittotalbiaya" id="edittotalbiaya" class="form-control text-uppercase edittotalbiaya" placeholder="Total Harga.." readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="editpembayaran">
                Pembayaran
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