<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('persensopir') ?>" class="btn btn-dark border border-light">
              <i class=" fas fa-arrow-left"></i>
              Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form action="<?= base_url('persensopir/prosesAdd') ?>" method="post">
        <div class="row">
          <div class="col-lg col-md">
            <div class="card">
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="kd">Kd Persen</label>
                    <input type="text" name="kd" id="kd" class="form-control text-uppercase" value="<?= $kd ?>" required readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="tgl">Tanggal</label>
                    <input type="text" name="tgl" id="tgl" class="form-control text-capitalize" value="<?= date('d-F-Y') ?>" readonly>
                  </div>
                </div>
                <h6 class="font-weight-bold">Data Order Penjualan</h6>
                <hr class="bg-secondary">
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="sopirid">Nama Sopir</label>
                    <select name="sopirid" id="sopirid" class="form-control select-sopir" style="width:100%;" required>
                      <option value=""></option>
                    </select>
                    <input type="hidden" name="namasopir" id="namasopir" class="form-control text-capitalize" readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="noorder">No Order</label>
                    <select name="noorder" id="noorder" class="form-control select-noorder" style="width:100%;">
                      <option value=""></option>

                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="pengirim">Pengirim</label>
                    <input type="text" name="pengirim" id="pengirim" class="form-control text-capitalize" placeholder="Pengirim..." readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="penerima">Penerima</label>
                    <input type="text" name="penerima" id="penerima" class="form-control text-capitalize" placeholder="Penerima..." readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="asaltujuan">Asal-Tujuan</label>
                    <input type="text" name="asaltujuan" id="asaltujuan" class="form-control text-capitalize" placeholder="Asal-Tujuan..." readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="muatan">Muatan</label>
                    <input type="text" name="muatan" id="muatan" class="form-control text-capitalize" placeholder="Muatan..." readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="totalharga">Total Biaya</label>
                    <input type="text" name="totalharga" id="totalharga" class="form-control" placeholder="Total Biaya..." readonly>
                  </div>
                </div>
                <h6 class="font-weight-bold">Data Sangu</h6>
                <hr class="bg-secondary">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="sangu">Sangu</label>
                    <input type="text" name="sangu" id="sangu" class="form-control" placeholder="Sangu..." readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="tambahan">Tambahan</label>
                    <input type="text" name="tambahan" id="tambahan" class="form-control" placeholder="Tambahan..." readonly>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="jumlahsangu">Jumlah Sangu</label>
                    <input type="text" name="jumlahsangu" id="jumlahsangu" class="form-control" placeholder="Jumlah Sangu..." readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="jumlahpersen">Jumlah Persen</label>
                    <input type="text" name="jumlahpersen" id="jumlahpersen" class="form-control" placeholder="Jumlah Persen..." required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="jumlahterima">Jumlah Diterima</label>
                    <input type="text" name="jumlahterima" id="jumlahterima" class="form-control" placeholder="Jumlah Diterima..." readonly>
                  </div>
                  <div class="form-group col-md-4 d-flex align-items-end">
                    <button type="button" class="btn btn-primary border border-light btn-block mt-4" id="tambah" style="height:calc(1.5em + 0.75rem + 2px);" disabled>
                      <i class="fa fa-plus"></i>
                      Tambah
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg">
            <div class="card card-danger">
              <div class="card-body">
                <h5>List Persen Sopir</h5>
                <div class="table-responsive mt-4">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead align="center">
                      <tr>
                        <td width="40%">
                          <strong>No Order</strong>
                        </td>
                        <td width="40%">
                          <strong>Nominal Diterima</strong>
                        </td>
                        <td>
                          <strong>Aksi</strong>
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot id="tfoot" align="center">
                      <tr>
                        <td colspan="2">
                          <h4 class="font-weight-bold" id="total"></h4>
                        </td>
                        <td>
                          <input type="hidden" name="total_hidden" value="">
                          <button type="submit" class="btn btn-dark btn-sm border border-light" data-toggle="tooltip" title="Simpan">
                            <i class="fas fa-save"></i>
                            Simpan
                          </button>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>