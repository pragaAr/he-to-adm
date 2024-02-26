<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Penjualan extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, no_order, no_sj, jenis, muatan, berat, hrg_borong, hrg_kg, pengirim, kota_asal, alamat_asal, penerima, kota_tujuan, alamat_tujuan, total_hrg, pembayaran, dateAdd')
      ->from('penjualan')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
         <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="$2" data-toggle="tooltip" title="Detail">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="$2" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
        </div>',
        'id, no_order, no_sj, jenis, muatan, berat, hrg_borong, hrg_kg, pengirim, kota_asal, alamat_asal, penerima, kota_tujuan, alamat_tujuan, total_hrg, pembayaran, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function countData()
  {
    return $this->db->get('penjualan')->num_rows();
  }

  public function getNoOrder($no)
  {
    return $this->db->get_where('penjualan', ['no_order' => $no])->row();
  }

  public function getNoOrderPenjualan($no)
  {
    return $this->db->get_where('penjualan', ['no_order' => $no])->row();
  }

  public function getPlatPenjualan($no)
  {
    $this->db->select('platno');
    $this->db->from('sangu_order');
    $this->db->where('no_order', $no);
    $query = $this->db->get()->row();
    return $query;
  }

  public function getDataCust()
  {
    $this->db->select('DiSTINCT(pengirim)');
    $this->db->from('penjualan');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getOrderCust($post)
  {
    $this->db->select('no_order');
    $this->db->from('penjualan');
    $this->db->where('penjualan.invAdd =', null);
    $this->db->where('pengirim', $post);
    $this->db->where('pembayaran=', "tempo");

    $query = $this->db->get()->result();
    return $query;
  }

  public function getOrderSopir($noorder)
  {
    $this->db->select('penjualan.no_order, penjualan.jenis_penjualan, penjualan.muatan, penjualan.pengirim, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.total_harga, order_masuk.no_order, sangu_order.no_order, sangu_order.sopir_id, sangu_order.nominal, sangu_order.tambahan');
    $this->db->from('penjualan');
    $this->db->where('penjualan.no_order', $noorder);
    $this->db->join('order_masuk', 'order_masuk.no_order = penjualan.no_order');
    $this->db->join('sangu_order', 'sangu_order.no_order = penjualan.no_order');

    $query = $this->db->get()->row();
    return $query;
  }

  public function getDataOrderCust($no)
  {
    $this->db->select('penjualan.no_order, penjualan.surat_jalan, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.berat, penjualan.harga_kg, penjualan.total_harga, penjualan.dateAdd, penjualan.invAdd, sangu_order.no_order, sangu_order.platno');
    $this->db->from('penjualan');
    $this->db->where('penjualan.no_order', $no);
    $this->db->join('sangu_order', 'sangu_order.no_order = penjualan.no_order');
    $query = $this->db->get()->row();
    return $query;
  }


  public function addData($data, $dataorder, $where)
  {
    $this->db->update('order_masuk', $dataorder, $where);
    $this->db->insert('penjualan', $data);
  }

  public function editData($no)
  {
    $userid           = $this->session->userdata('id_user');
    $nosj             = trim($this->input->post('editnosj'));
    $jenisnota        = $this->input->post('editjenispenjualan');
    $jenisbarng       = $this->input->post('editmuatan');
    $beratbrg         = $this->input->post('editberat');
    $hrgborong        = preg_replace("/[^0-9\.]/", "", $this->input->post('editborongan'));
    $hrgton           = preg_replace("/[^0-9\.]/", "", $this->input->post('edittonase'));
    $kotaasal         = trim($this->input->post('editkotaasal'));
    $penerima         = trim($this->input->post('editpenerima'));
    $kotatujuan       = trim($this->input->post('editkotatujuan'));
    $totalbiaya       = preg_replace("/[^0-9\.]/", "", $this->input->post('edittotalbiaya'));
    $pembayaran       = $this->input->post('editpembayaran');

    $data = array(
      'surat_jalan'         => strtolower($nosj),
      'jenis_penjualan'     => strtolower($jenisnota),
      'muatan'              => strtolower($jenisbarng),
      'berat'               => strtolower($beratbrg),
      'harga_borong'        => $hrgborong,
      'harga_kg'            => $hrgton,
      'kota_asal'           => strtolower($kotaasal),
      'penerima'            => strtolower($penerima),
      'kota_tujuan'         => strtolower($kotatujuan),
      'total_harga'         => $totalbiaya,
      'pembayaran'          => strtolower($pembayaran),
      'user_id'             => $userid,
    );

    $where = array(
      'no_order'    => $no
    );

    $this->db->update('penjualan', $data, $where);
  }

  public function deleteData($no)
  {
    $dataorder = array(
      'penjualanAdd'    => null,
    );

    $where = array(
      'no_order'    => $no
    );

    $this->db->delete('penjualan', ['no_order' => $no]);
    $this->db->update('order_masuk', $dataorder, $where);
  }
}
