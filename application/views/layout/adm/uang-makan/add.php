<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('uangmakan') ?>" class="btn btn-dark border border-light">
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
      <form action="<?= base_url('uangmakan/prosesAdd') ?>" method="post">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="card">

              <div class="card-body">
                <div class="form-group">
                  <label for="kd">Kode</label>
                  <input type="text" name="kd" id="kd" class="form-control text-uppercase" value="<?= $kd ?>" required readonly>
                </div>
                <div class="form-group">
                  <label for="user">Admin</label>
                  <input type="text" name="user" id="user" class="form-control text-capitalize" value="<?= $this->session->userdata('nama') ?>" required readonly>
                </div>
                <div class="form-group">
                  <label for="tgl">Tanggal</label>
                  <input type="text" name="tgl" id="tgl" class="form-control" value="<?= date('d-m-Y') ?>" required readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <label for="nominal">Nominal</label>
                  <input type="text" name="nominal" id="nominal" class="form-control text-capitalize" placeholder="Nominal.." autofocus autocomplete="off" required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
                </div>
                <div class="form-group">
                  <label for="kryid">Karyawan</label>
                  <select name="kryid" id="kryid" class="form-control select-karyawan" style="width:100%;">
                    <option value=""></option>
                  </select>
                  <input type="hidden" class="form-control" name="namakry" id="namakry" readonly>
                </div>
                <div class="form-group mt-5" style="margin-bottom: 1rem!important;">
                  <button class="btn btn-primary border border-light btn-block" style="height: calc(2.25rem + 2px);" type="button" id="tambah" disabled>
                    <i class="fas fa-plus"></i>
                    Tambah
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg">
            <div class="card card-danger">
              <div class="card-body">
                <h5 class="mb-3">List Penerima Uang Makan</h5>
                <div class="table-responsive">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead align="center">
                      <tr>
                        <td width="40%">
                          <strong>Penerima</strong>
                        </td>
                        <td width="40%">
                          <strong>Nominal</strong>
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
                          <h4 class="font-weight-bold">Total</h4>
                        </td>
                        <td class="align-middle">
                          <h4 class="font-weight-bold text-right pr-2" id="total"></h4>
                        </td>
                        <td class="align-middle text-center">
                          <input type="hidden" name="total_hidden" id="total_hidden" value="">
                          <button type="submit" class="btn btn-dark border border-light btn-sm">
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