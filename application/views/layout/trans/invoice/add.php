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
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">

              <form id="formSubmit" style="font-size:14px;">
                <div class="form-row">
                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="pengirim">Pengirim</label>
                    <select name="pengirim" id="pengirim" class="form-control select-pengirim" style="width:100%" required>
                      <option value=""></option>

                    </select>
                    <input type="hidden" name="selectedCust" id="selectedCust" class="form-control" required readonly>
                    <input type="hidden" name="selectedKodeCust" id="selectedKodeCust" class="form-control" required readonly>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="reccu">Reccu</label>
                    <select name="reccu" id="reccu" class="form-control select-reccu" style="width:100%">
                      <option value=""></option>

                    </select>
                    <input type="hidden" name="selectedReccu" id="selectedReccu" class="form-control" readonly>
                    <input type="hidden" name="selectedOrder" id="selectedOrder" class="form-control" readonly>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="penerima">Penerima</label>
                    <input type="text" name="penerima" id="penerima" class="form-control text-uppercase" placeholder="Penerima.." readonly>
                  </div>
                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="jenis">Jenis</label>
                    <input type="text" name="jenis" id="jenis" class="form-control text-uppercase" placeholder="Jenis.." readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="berat">Berat(Kg)</label>
                    <input type="text" name="berat" id="berat" class="form-control text-uppercase" placeholder="Berat(Kg).." readonly>
                  </div>
                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="hrgkg">Harga/Kg</label>
                    <input type="text" name="hrgkg" id="hrgkg" class="form-control text-uppercase" placeholder="Harga/Kg.." readonly>
                  </div>
                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="hrgbrg">Harga Borong</label>
                    <input type="text" name="hrgbrg" id="hrgbrg" class="form-control text-uppercase" placeholder="Harga Borong.." readonly>
                  </div>
                  <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="tothrg">Total Harga</label>
                    <input type="text" name="tothrg" id="tothrg" class="form-control text-uppercase" placeholder="Total.." readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="tgl">Tanggal</label>
                    <input type="date" name="tgl" id="tgl" class="form-control text-uppercase" value="<?= date('Y-m-d') ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="noinv">No Invoice</label>
                    <input type="text" name="noinv" id="noinv" class="form-control text-uppercase" required>
                  </div>
                </div>

                <hr style="border: 1px solid #6c757d;">

                <h5 class="mb-3">List Surat Jalan</h5>
                <div class="table-responsive">
                  <table class="table table-bordered" id="cart" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <td>
                          <strong>Reccu</strong>
                        </td>
                        <td>
                          <strong>Surat Jalan</strong>
                        </td>
                        <td>
                          <strong>Berat</strong>
                        </td>
                        <td>
                          <strong>Aksi</strong>
                        </td>
                      </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                    <tfoot id="tfoot">
                      <tr>
                        <td class="align-middle text-center" colspan="4">
                          <button type="submit" class="btn btn-dark border border-light btn-block">
                            Simpan
                          </button>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>