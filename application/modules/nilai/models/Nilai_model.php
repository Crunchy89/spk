<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai_model extends CI_Model
{
    public function __construct()
    {
        $this->table = 'nilai';
        $this->id = 'id_nilai';
    }
    public function getData()
    {
        $alternatif = $this->db->get('alternatif')->result();
        $kriteria = $this->db->get('kriteria')->result();
        $data = [];
        foreach ($alternatif as $row2) {
            $tes = [[$row2->id_alternatif, $row2->alternatif]];
            foreach ($kriteria as $row) {
                $nilai = $this->db->get_where($this->table, ['id_alternatif' => $row2->id_alternatif, 'id_kriteria' => $row->id_kriteria])->row();
                array_push($tes, [$row->id_kriteria, $nilai ? $nilai->nilai : 0]);
            }
            array_push($data, $tes);
        }
        return $data;
    }
    public function tambah()
    {
        $id_alternatif = htmlspecialchars($this->input->post('alternatif'));
        $kriteria = $this->db->get('kriteria')->result();
        foreach ($kriteria as $row) {
            $cek = $this->db->get_where($this->table, ['id_alternatif' => $id_alternatif, 'id_kriteria' => $row->id_kriteria])->row();
            if (!$cek) {
                $data['id_alternatif'] = $id_alternatif;
                $data['id_kriteria'] = $row->id_kriteria;
                $data['nilai'] = htmlspecialchars($this->input->post("$row->id_kriteria"));
                $this->db->insert($this->table, $data);
            } else {
                $data['id_alternatif'] = $id_alternatif;
                $data['id_kriteria'] = $row->id_kriteria;
                $data['nilai'] = htmlspecialchars($this->input->post("$row->id_kriteria"));
                $this->db->where($this->id, $cek->id_nilai);
                $this->db->update($this->table, $data);
            }
        }
        $result = [
            'status' => true,
            'pesan' => 'Data berhasil disimpan'
        ];
        return $result;
    }
}
