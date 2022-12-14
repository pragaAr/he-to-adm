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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addKaryawan">
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
                    <th>Usia</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Status/Bagian</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($karyawan as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->nama) ?></td>
                      <td><?= strtoupper($data->usia) ?> Th</td>
                      <td><?= strtoupper($data->alamat) ?></td>
                      <td><?= strtoupper($data->notelp) ?></td>
                      <td><?= strtoupper($data->status) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-karyawan" title="Edit" data-id="<?= $data->id_karyawan ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('karyawan/delete/') . $data->id_karyawan ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addKaryawan -->
<form action="<?= base_url('karyawan') ?>" method="POST">
  <div class="modal fade" id="addKaryawan" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Karyawan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">
              Nama
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="nama" placeholder="Nama.." required oninvalid="this.setCustomValidity('Nama wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="usia">
              Usia
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="usia" placeholder="Usia.." required oninvalid="this.setCustomValidity('Usia wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamat">
              Alamat
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="alamat" placeholder="Alamat.." required oninvalid="this.setCustomValidity('Alamat wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelp">
              Kontak
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="notelp" placeholder="Kontak.." required oninvalid="this.setCustomValidity('Kontak wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="status">
              Status/Bagian
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="status" placeholder="Status.." required oninvalid="this.setCustomValidity('Status wajib di isi!')" oninput="setCustomValidity('')">
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

<!-- editKaryawan -->
<form action="<?= base_url('karyawan/update') ?>" method="POST">
  <div class="modal fade" id="editKaryawan" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Karyawan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">
              Nama
              <span class="text-white">*</span>
            </label>
            <input type="hidden" class="form-control idkaryawan" name="idkaryawan" readonly>
            <input type="text" class="form-control text-uppercase nama" name="nama" placeholder="Nama.." required oninvalid="this.setCustomValidity('Nama wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="usia">
              Usia
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase usia" name="usia" placeholder="Usia.." required oninvalid="this.setCustomValidity('Usia wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamat">
              Alamat
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase alamat" name="alamat" placeholder="Alamat.." required oninvalid="this.setCustomValidity('Alamat wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelp">
              Kontak
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase notelp" name="notelp" placeholder="Kontak.." required oninvalid="this.setCustomValidity('Kontak wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="status">
              Status/Bagian
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase status" name="status" placeholder="Status.." required oninvalid="this.setCustomValidity('Status wajib di isi!')" oninput="setCustomValidity('')">
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