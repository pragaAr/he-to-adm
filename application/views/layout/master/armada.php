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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addArmada">
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
                    <th>Plat No</th>
                    <th>Merk</th>
                    <th>Tanggal Keur</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($armada as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= strtoupper($data->platno) ?></td>
                      <td><?= strtoupper($data->merk) ?></td>
                      <td><?= date('d-m-Y', strtotime($data->dateKeur)) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-armada" title="Edit" data-id="<?= $data->id_armada ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('armada/delete/') . $data->id_armada ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addArmada -->
<form action="<?= base_url('armada') ?>" method="POST">
  <div class="modal fade" id="addArmada" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Armada</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="platno">
              Plat No
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="platno" placeholder="Plat No.." required oninvalid="this.setCustomValidity('Plat No wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="merk">
              Merk
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase" name="merk" placeholder="Merk.." required oninvalid="this.setCustomValidity('Merk wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="keur">
              Tanggal Keur
              <span class="text-white">*</span>
            </label>
            <input type="date" class="form-control text-uppercase" name="keur" placeholder="Tanggal Keur.." required>
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

<!-- editArmada -->
<form action="<?= base_url('armada/update') ?>" method="POST">
  <div class="modal fade" id="editArmada" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Armada</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="platno">
              Plat No
              <span class="text-white">*</span>
            </label>
            <input type="hidden" class="form-control idarmada" name="idarmada" readonly>
            <input type="text" class="form-control text-uppercase platno" name="platno" placeholder="Plat No.." required oninvalid="this.setCustomValidity('Plat No wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="merk">
              Merk
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-uppercase merk" name="merk" placeholder="Merk.." required oninvalid="this.setCustomValidity('Merk wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="keur">
              Tanggal Keur
              <span class="text-white">*</span>
            </label>
            <input type="date" class="form-control keur" name="keur" required>
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