<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alternatif_model extends CI_Model
{
    public function __construct()
    {
        $this->table = 'alternatif';
        $this->id = 'id_alternatif';
    }
    public function getData()
    {
        return $this->db->get('alternatif')->result();
    }
    public function tambah()
    {
        $data = [
            'alternatif' => htmlspecialchars($this->input->post('alternatif'))
        ];
        $this->db->insert($this->table, $data);
        $result = [
            'status' => true,
            'pesan' => 'Data berhasil disimpan'
        ];
        return $result;
    }
    public function edit()
    {
        $id = $this->input->post('id');
        $alternatif = htmlspecialchars($this->input->post('alternatif'));
        $data = [
            'alternatif' => $alternatif
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
