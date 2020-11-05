<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kelas_model extends CI_Model
{
    function __construct()
    {
        $this->table = 'kelas';
        $this->id = 'id_kelas';
        $this->column_order = array(null, 'kelas', null, null, null);
        $this->column_search = array('kelas');
        $this->order = array('id_jurusan' => 'asc');
    }

    public function getRows($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countFiltered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_datatables_query($postData)
    {

        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function tambah()
    {
        $kelas = htmlspecialchars($_POST['kelas']);
        $jurusan = htmlspecialchars($_POST['jurusan']);
        $data = [
            'kelas' => $kelas,
            'id_jurusan' => $jurusan
        ];
        $this->db->insert($this->table, $data);
        return "Data Berhasil Ditambah";
    }
    public function edit()
    {
        $id = htmlspecialchars($_POST['id']);
        $kelas = htmlspecialchars($_POST['kelas']);
        $jurusan = htmlspecialchars($_POST['jurusan']);
        $data = [
            'kelas' => $kelas,
            'id_jurusan' => $jurusan
        ];
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return "Data Berhasil diubah";
    }
    public function hapus()
    {
        $id = htmlspecialchars($_POST['id']);
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        return "Data Berhasil dihapus";
    }
}
