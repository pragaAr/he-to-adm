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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addLain">
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
                    <th>Nama</th>
                    <th>Nominal</th>
                    <th>Keperluan</th>
                    <th>Tanggal</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($etc as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->nama) ?></td>
                      <td>Rp. <?= number_format($data->nominal) ?></td>
                      <td><?= strtoupper($data->keperluan) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateAdd)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-lain" title="Edit" data-id="<?= $data->id_lain ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('etc/delete/') . $data->id_lain ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addLain -->
<form action="<?= base_url('etc') ?>" method="POST">
  <div class="modal fade" id="addLain" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Pengeluaran Lain-lain</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="karyawan">
              Nama Karyawan
              <span class="text-white">*</span>
            </label>
            <select name="karyawan" id="karyawan" class="form-control select2" style="width:100%;" required oninvalid="this.setCustomValidity('Nama Karyawan wajib di isi!')" oninput="setCustomValidity('')">
              <option value="" selected disabled>-Pilih Karyawan-</option>
              <?php foreach ($karyawan as $data) : ?>
                <option value="<?= $data->id_karyawan ?>"><?= ucwords($data->nama) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nominal">
              Nominal
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="keperluan">
              Keperluan
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-capitalize" name="keperluan" placeholder="Keperluan.." required oninvalid="this.setCustomValidity('Keperluan wajib di isi!')" oninput="setCustomValidity('')">
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

<!-- editLain -->
<form action="<?= base_url('etc/update') ?>" method="POST">
  <div class="modal fade" id="editLain" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Pengeluaran Lain-lain</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="karyawanedit">
              Nama Karyawan
              <span class="text-white">*</span>
            </label>
            <select name="karyawanedit" class="form-control select2 karyawanedit" style="width:100%;" required oninvalid="this.setCustomValidity('Nama Karyawan wajib di isi!')" oninput="setCustomValidity('')">
              <option value="">-Pilih Karyawan-</option>
              <?php foreach ($karyawanedit as $data) : ?>
                <option value="<?= $data->id_karyawan ?>"><?= ucwords($data->nama) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nominaledit">
              Nominal
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control nominaledit" name="nominaledit" id="nominaledit" placeholder="Nominal.." required oninvalid="this.setCustomValidity('Nominal wajib di isi!')" oninput="setCustomValidity('')">
            <input type="hidden" class="form-control idlain" required readonly>
          </div>
          <div class="form-group">
            <label for="keperluanedit">
              Keperluan
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-capitalize keperluanedit" name="keperluanedit" placeholder="Keperluan.." required oninvalid="this.setCustomValidity('Keperluan wajib di isi!')" oninput="setCustomValidity('')">
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