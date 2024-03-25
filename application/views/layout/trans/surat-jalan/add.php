<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="<?= base_url('traveldoc') ?>" class="btn btn-dark border border-light">
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
      <form action="<?= base_url('traveldoc/proses') ?>" method="post">
        <div class="row">
          <div class="col-lg">
            <div class="card">
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="reccu">Reccu</label>
                    <select name="reccu" id="reccu" class="form-control select-reccu" style="width:100%" required>
                      <option value=""></option>

                    </select>
                    <input type="hidden" name="selectedReccu" id="selectedReccu" class="form-control" required readonly>
                    <input type="hidden" name="selectedOrder" id="selectedOrder" class="form-control" required readonly>
                    <input type="hidden" name="selectedCust" id="selectedCust" class="form-control" required readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="pengirim">Pengirim</label>
                    <input type="text" name="pengirim" id="pengirim" class="form-control text-capitalize" placeholder="Pengirim.." required readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="penerima">Penerima</label>
                    <input type="text" name="penerima" id="penerima" class="form-control text-capitalize" placeholder="Penerima.." required readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="jenis">Jenis</label>
                    <input type="text" name="jenis" id="jenis" class="form-control text-capitalize" placeholder="Jenis.." required readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="berat">Berat(Kg)</label>
                    <input type="text" name="berat" id="berat" class="form-control" placeholder="Berat(Kg).." required readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="hrgkg">Harga/Kg</label>
                    <input type="text" name="hrgkg" id="hrgkg" class="form-control" placeholder="Harga/Kg.." required readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="hrgbrg">Harga Borong</label>
                    <input type="text" name="hrgbrg" id="hrgbrg" class="form-control" placeholder="Harga Borong.." required readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="tothrg">Total Harga</label>
                    <input type="text" name="tothrg" id="tothrg" class="form-control" placeholder="Total.." required readonly>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="suratjalan">Surat Jalan</label>
                    <input type="text" name="suratjalan" id="suratjalan" class="form-control" placeholder="Surat Jalan..">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="beratsj">Berat/SJ(Kg)</label>
                    <input type="text" name="beratsj" id="beratsj" class="form-control" placeholder="Berat/SJ(Kg)..">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="retur">Retur</label>
                    <input type="text" name="retur" id="retur" class="form-control" placeholder="Retur..">
                  </div>
                  <div class="form-group col-md-3 d-flex align-items-end">
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
                <h5 class="mb-3">List Surat Jalan</h5>
                <div class="table-responsive">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead align="center">
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
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>