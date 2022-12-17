<tr class="text-center tbdetail">
  <td class="text-uppercase editorderno">
    <?= $this->input->post('editorderno') ?>
    <input type="hidden" name="editorderno_hidden[]" value="<?= $this->input->post('editorderno') ?>">
  </td>

  <td class="text-uppercase editnosj">
    <?= $this->input->post('editnosj') ?>
    <input type="hidden" name="editnosj_hidden[]" value="<?= $this->input->post('editnosj') ?>">
  </td>

  <td class="text-uppercase edittagihanorder">
    <?= $this->input->post('edittagihanorder') ?>
    <input type="hidden" name="edittagihanorder_hidden[]" value="<?= $this->input->post('edittagihanorder') ?>">
  </td>

  <td class="action">
    <button type="button" class="btn btn-danger btn-sm" id="btn-hapus-noorder" title="Hapus Resi" data-order="<?= $this->input->post('editorderno') ?>">
      <i class="fas fa-times"></i>
    </button>
  </td>
</tr>