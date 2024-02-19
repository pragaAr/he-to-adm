<tr class="text-center row-cart">
  <td class="text-uppercase noorder">
    <?= $this->input->post('noorder') ?>
    <input type="hidden" name="noorder_hidden[]" value="<?= $this->input->post('noorder') ?>">
  </td>

  <?= $this->input->post('sopir') ?>
  <input type="hidden" name="sopir_hidden[]" value="<?= $this->input->post('sopir') ?>">

  <?= $this->input->post('jmlpersen') ?>
  <input type="hidden" name="jmlpersen_hidden[]" value="<?= $this->input->post('jmlpersen') ?>">

  <?= $this->input->post('jmlsangu') ?>
  <input type="hidden" name="jmlsangu_hidden[]" value="<?= $this->input->post('jmlsangu') ?>">

  <td class="text-uppercase nominalterima">
    <?= $this->input->post('nominalterima') ?>
    <input type="hidden" name="nominalterima_hidden[]" value="<?= $this->input->post('nominalterima') ?>">
  </td>

  <td class="action">
    <button type="button" class="btn btn-danger btn-sm" id="tombol-hapus" data-toggle="tooltip" title="Hapus Order" data-noorder="<?= $this->input->post('noorder') ?>">
      <i class="fas fa-times"></i>
    </button>
  </td>
</tr>