<tr class="text-center row-cart">
  <td class="text-uppercase nama">
    <?= $this->input->post('nama') ?>
    <input type="hidden" name="nama_hidden[]" value="<?= $this->input->post('nama') ?>">
  </td>

  <?= $this->input->post('idkaryawan') ?>
  <input type="hidden" name="idkaryawan_hidden[]" value="<?= $this->input->post('idkaryawan') ?>">

  <td class="text-uppercase nominal">
    <?= $this->input->post('nominal') ?>
    <input type="hidden" name="nominal_hidden[]" value="<?= $this->input->post('nominal') ?>">
  </td>

  <td class="action">
    <button type="button" class="btn btn-danger btn-sm" id="tombol-hapus" data-toggle="tooltip" title="Hapus Penerima" data-nama="<?= $this->input->post('nama') ?>">
      <i class="fas fa-times"></i>
    </button>
  </td>
</tr>