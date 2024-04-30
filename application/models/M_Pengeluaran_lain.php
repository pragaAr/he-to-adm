<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Pengeluaran_lain extends CI_Model
{
  public function generateKode()
  {
    $this->db->select('RIGHT(pengeluaran_lain.kd,3) as kd', FALSE)
      ->order_by('kd', 'DESC')
      ->limit(1);

    $query = $this->db->get('pengeluaran_lain');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kd) + 1;
    } else {
      $kode = 1;
    }

    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "pl-" . $batas;

    return $kodetampil;
  }

  public function getData()
  {
    $this->datatables->select('a.id, a.kd, a.nominal, a.keterangan, a.dateAdd, b.nama')
      ->from('pengeluaran_lain a')
      ->join('karyawan b', 'b.id = a.karyawan_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="http://localhost/hira-to-adm/penjualan/print/$3" target="_blank" class="btn btn-sm btn-info text-white border border-light btn-print" data-toggle="tooltip" title="Cetak">
            <i class="fas fa-print fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-toggle="tooltip" title="Detail" data-kd="$3">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="$3" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="$3" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, kd, nominal, keterangan, nama, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function getId($id)
  {
    $this->db->select('pengeluaran_lain.id_lain, pengeluaran_lain.karyawan_id, pengeluaran_lain.nominal, pengeluaran_lain.keterangan, karyawan.id, karyawan.nama');
    $this->db->from('pengeluaran_lain');
    $this->db->join('karyawan', 'karyawan.id = pengeluaran_lain.karyawan_id');
    $this->db->where('pengeluaran_lain.id_lain', $id);
    $query = $this->db->get()->row();
    return $query;
  }

  public function addData($data, $detail)
  {
    $this->db->trans_start();

    $this->db->insert('pengeluaran_lain', $data);
    $this->db->insert_batch('detail_pl', $detail);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      // Transaksi gagal
      return false;
    } else {
      // Transaksi berhasil
      return true;
    }
  }

  public function editData($id)
  {
    $karyawan   = $this->input->post('karyawanedit');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominaledit'));
    $keterangan = $this->input->post('keteranganedit');
    $user       = $this->session->userdata('id_user');

    $data = array(
      'karyawan_id'   => strtolower($karyawan),
      'nominal'       => strtolower($nominal),
      'keterangan'    => strtolower($keterangan),
      'user_id'       => strtolower($user),
    );

    $where = array('id_lain' => $id);

    $this->db->update('pengeluaran_lain', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('pengeluaran_lain', ['id_lain' => $id]);
  }
}
