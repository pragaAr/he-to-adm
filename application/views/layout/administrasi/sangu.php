<div class="content-wrapper">
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
              <table id="dtable" class="table table-bordered table-striped">
                <thead class="text-center">
                  <tr>
                    <th width="5%">No.</th>
                    <th>No Order</th>
                    <th>Truck</th>
                    <th>Driver</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($sangu as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->no_order) ?></td>
                      <td><?= strtoupper($data->platno) ?></td>
                      <td><?= strtoupper($data->nama_sopir) ?></td>
                      <td><?= strtoupper($data->kota_asal) ?></td>
                      <td><?= strtoupper($data->kota_tujuan) ?></td>
                      <td>Rp. <?= number_format($data->nominal) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateAdd)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-sangu" title="Edit" data-id="<?= $data->no_order ?>">
                            <i class="fas fa-pencil-alt"></i>
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

<!-- editSangu -->
<form action="<?= base_url('sangu/update') ?>" method="POST">
  <div class="modal fade" id="editSangu" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Sangu</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="noorder">
                No Order
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase noorder" name="noorder" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="platno">
                Truck
                <span class="text-white">*</span>
              </label>
              <select name="platno" id="platno" class="form-control select2 platno" style="width: 100%;" required oninvalid="this.setCustomValidity('Truck wajib di isi!')" oninput="setCustomValidity('')">
                <option value="">-Pilih Truck-</option>
                <?php foreach ($truck as $data) : ?>
                  <option value="<?= $data->platno ?>"><?= strtoupper($data->platno) ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="asal">
                Kota Asal
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase asal" name="asal" placeholder="Kota Asal.." required oninvalid="this.setCustomValidity('Kota Asal wajib di isi!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group col-md-6">
              <label for="tujuan">
                Kota Tujuan
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase tujuan" name="tujuan" placeholder="Kota Tujuan.." required oninvalid="this.setCustomValidity('Kota Tujuan wajib di isi!')" oninput="setCustomValidity('')">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="sopir">
                Driver
                <span class="text-white">*</span>
              </label>
              <select name="sopir" class="form-control text-uppercase select2 sopir" style="width: 100%;" required oninvalid="this.setCustomValidity('Sopir wajib di isi!')" oninput="setCustomValidity('')">
                <option value="" selected disabled>-Pilih Sopir-</option>
                <?php foreach ($sopir as $sopir) : ?>
                  <option value="<?= $sopir->id_sopir ?>"><?= strtoupper($sopir->nama_sopir) ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="nominal">
                Nominal
                <span class="text-white">*</span>
              </label>
              <input type="text" class="form-control text-uppercase nominal" name="nominal" id="nominal" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
            </div>
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