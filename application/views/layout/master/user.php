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
            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#addUser">
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
                    <th>Nama User</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <?php $no = 1;
                  foreach ($user as $data) : ?>
                    <tr>
                      <td><?= $no ?>.</td>
                      <td><?= ucwords($data->namauser) ?></td>
                      <td><?= $data->username ?></td>
                      <td><?= ucwords($data->role) ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <a href="" class="btn btn-sm btn-warning text-white btn-edit-user" title="Edit" data-id="<?= $data->id_user ?>">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('user/delete/') . $data->id_user ?>" class="btn btn-sm btn-danger text-white btn-delete" title="Hapus">
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

<!-- addUser -->
<form action="<?= base_url('user') ?>" method="POST">
  <div class="modal fade" id="addUser" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="namauser">
              Nama User
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control text-capitalize" name="namauser" placeholder="Nama User.." required oninvalid="this.setCustomValidity('Nama User wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="username">
              Username
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control" name="username" placeholder="Username.." required oninvalid="this.setCustomValidity('Username wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="pass">
              Password
              <span class="text-white">*</span>
            </label>
            <input type="password" class="form-control" name="pass" placeholder="Password.." required oninvalid="this.setCustomValidity('Password wajib di isi!')" oninput="setCustomValidity('')">
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

<!-- editUser -->
<form action="<?= base_url('user/update') ?>" method="POST">
  <div class="modal fade" id="editUser" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="namauser">
              Nama User
              <span class="text-white">*</span>
            </label>
            <input type="hidden" class="form-control iduser" name="iduser" readonly>
            <input type="text" class="form-control text-capitalize namauser" name="namauser" placeholder="Nama User.." required oninvalid="this.setCustomValidity('Nama User wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="username">
              Username
              <span class="text-white">*</span>
            </label>
            <input type="text" class="form-control username" name="username" placeholder="Username.." required oninvalid="this.setCustomValidity('Username wajib di isi!')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="pass">
              Password
              <span class="text-white">*</span>
            </label>
            <input type="password" class="form-control" name="pass" placeholder="Password.." required oninvalid="this.setCustomValidity('Password wajib di isi!')" oninput="setCustomValidity('')">
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