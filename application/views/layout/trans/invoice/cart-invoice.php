<tr class="text-center row-cart">
  <td class="text-uppercase noorder">
    <?= $this->input->post('noorder') ?>
    <input type="hidden" name="noorder_hidden[]" value="<?= $this->input->post('noorder') ?>">
  </td>

  <td class="text-uppercase nosj">
    <?= $this->input->post('nosj') ?>
    <input type="hidden" name="nosj_hidden[]" value="<?= $this->input->post('nosj') ?>">
  </td>

  <td class="text-uppercase tagihan">
    <?= $this->input->post('tagihan') ?>
    <input type="hidden" name="tagihan_hidden[]" value="<?= $this->input->post('tagihan') ?>">
  </td>

  <td class="action">
    <button type="button" class="btn btn-danger btn-sm" id="tombol-hapus" title="Hapus Resi" data-order="<?= $this->input->post('noorder') ?>">
      <i class="fas fa-times"></i>
    </button>
  </td>
</tr>