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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addSopir">
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
                    <th>Nama Sopir</th>
                    <th>ALamat</th>
                    <th>No Telp</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($sopir as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= ucwords($data->nama_sopir) ?></td>
                      <td><?= ucwords($data->alamat_sopir) ?></td>
                      <td><?= ucwords($data->notelp_sopir) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-sopir" title="Edit" data-id="<?= $data->id_sopir ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('sopir/delete/') . $data->id_sopir ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addSopir -->
<form action="<?= base_url('sopir') ?>" method="POST">
  <div class="modal fade" id="addSopir" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Sopir</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="namasopir">
              Nama Sopir
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="namasopir" placeholder="Nama Sopir.." required oninvalid="this.setCustomValidity('Nama Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamatsopir">
              Alamat Sopir
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="alamatsopir" placeholder="Alamat Sopir.." required oninvalid="this.setCustomValidity('Alamat Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelpsopir">
              No Telepon
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="notelpsopir" placeholder="No Telepon.." required oninvalid="this.setCustomValidity('No Telepon Sopir wajib di isi!')" oninput="setCustomValidity('')">
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

<!-- editSopir -->
<form action="<?= base_url('sopir/update') ?>" method="POST">
  <div class="modal fade" id="editSopir" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Sopir</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="namasopir">
              Nama Sopir
              <span class="text-white">*</span>
            </label>
            <input type="hidden" class="form-control idsopir" name="idsopir" readonly>
            <input type="text" class="form-control text-uppercase namasopir" name="namasopir" placeholder="Nama Sopir.." required oninvalid="this.setCustomValidity('Nama Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="alamatsopir">
              Alamat Sopir
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase alamatsopir" name="alamatsopir" placeholder="Alamat Sopir.." required oninvalid="this.setCustomValidity('Alamat Sopir wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="notelpsopir">
              No Telepon
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control notelpsopir" name="notelpsopir" placeholder="No Telepon Sopir.." required oninvalid="this.setCustomValidity('No Telepon Sopir wajib di isi!')" oninput="setCustomValidity('')">
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