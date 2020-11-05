<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria_model extends CI_Model
{
    public function __construct()
    {
        $this->table = 'kriteria';
        $this->id = 'id_kriteria';
    }
    public function getData()
    {
        return $this->db->get('kriteria')->result();
    }
    public function tambah()
    {
        $label = count($this->db->get('kriteria')->result());
        $data = [
            'label' => "C" . ($label + 1),
            'kriteria' => htmlspecialchars($this->input->post('kriteria'))
        ];
        $this->db->insert($this->table, $data);
        $id = $this->db->insert_id();
        $ahp = [
            'id_kriteria1' => $id,
            'id_kriteria2' => $id,
            'nilai' => 1
        ];
        $this->db->insert('ahp', $ahp);
        $result = [
            'status' => true,
            'pesan' => 'Data berhasil disimpan'
        ];
        return $result;
    }
    public function edit()
    {
        $id = $this->input->post('id');
        $kriteria = htmlspecialchars($this->input->post('kriteria'));
        $data = [
            'kriteria' => $kriteria
        ];
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        $result = [
            'status' => true,
            'pesan' => 'Data berhasil diubah'
        ];
        return $result;
    }
    public function hapus()
    {
        $id = $this->input->post('id');
        $this->db->where($this->id, $id)->delete($this->table);
        $result = [
            'status' => true,
            'pesan' => 'Data berhasil dihapus'
        ];
        return $result;
    }
}
