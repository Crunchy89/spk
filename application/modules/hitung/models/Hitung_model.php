<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hitung_model extends CI_Model
{
    public function __construct()
    {
        $this->table = 'ahp';
        $this->id = 'id_ahp';
    }
    public function getData()
    {
        return $this->db->get('kriteria')->result();
    }
    public function ahp()
    {
        $kriteria = $this->getData();
        $data = [];
        foreach ($kriteria as $row) {
            $tes = [$row->label];
            foreach ($kriteria as $row2) {
                $id1 = $this->db->get_where($this->table, ['id_kriteria1' => $row->id_kriteria, 'id_kriteria2' => $row2->id_kriteria])->row();
                if ($id1) {
                    array_push($tes, $id1->nilai);
                } else {
                    array_push($tes, 0);
                }
            }
            array_push($data, $tes);
        }

        $jumlah = $this->data();

        $res = ["Jumlah"];
        for ($i = 0; $i < count($jumlah); $i++) {
            $tes = [];
            for ($j = 0; $j < count($jumlah[$i]); $j++) {
                array_push($tes, $jumlah[$j][$i]);
            }
            array_push($res, round(array_sum($tes), 3));
        }
        array_push($data, $res);
        return $data;
    }
    public function nilai_kriteria()
    {
        $kriteria = $this->getData();
        $data = [];
        $jumlah = $this->data();
        $res = [];
        for ($i = 0; $i < count($jumlah); $i++) {
            $tes = [];
            for ($j = 0; $j < count($jumlah[$i]); $j++) {
                array_push($tes, $jumlah[$j][$i]);
            }
            array_push($res, round(array_sum($tes), 3));
        }
        $i = 0;
        $hasil = ["Jumlah"];
        $nilai = [];
        $jumprior = [];
        $prior = [];
        foreach ($kriteria as $row) {
            $tes = [$row->label];
            $tes2 = [];
            for ($j = 0; $j < count($jumlah[$i]); $j++) {
                array_push($tes, round((round($jumlah[$i][$j], 3) / round($res[$j], 3)), 3));
                array_push($tes2, round((round($jumlah[$i][$j], 3) / round($res[$j], 3)), 3));
            }
            $jum = round(array_sum($tes), 3);
            array_push($tes, $jum);
            array_push($jumprior, $jum);
            array_push($tes, round(($jum / count($kriteria)), 3));
            array_push($prior, round(($jum / count($kriteria)), 3));
            array_push($data, $tes);
            array_push($nilai, $tes2);
            $i++;
        }
        for ($i = 0; $i < count($nilai); $i++) {
            $tes = [];
            for ($j = 0; $j < count($nilai[$i]); $j++) {
                array_push($tes, ($nilai[$j][$i]));
            }
            array_push($hasil, round(array_sum($tes), 3));
        }
        array_push($hasil, round(array_sum($jumprior), 3));
        array_push($hasil, round(array_sum($prior), 3));
        array_push($data, $hasil);
        return $data;
    }
    public function matrix_baris()
    {
        $prior = $this->prior();
        $jumlah = $this->data();
        $data = [];
        for ($i = 0; $i < count($jumlah); $i++) {
            $as = $i + 1;
            $jum = [];
            $tes = ["C$as"];
            for ($j = 0; $j < count($jumlah[$i]); $j++) {
                array_push($tes, (round($jumlah[$i][$j] * $prior[$j], 3)));
                array_push($jum, (round($jumlah[$i][$j] * $prior[$j], 3)));
            }
            array_push($tes, round(array_sum($jum), 3));
            array_push($data, $tes);
        }
        return $data;
    }
    public function rasio()
    {
        $prior = $this->prior();
        $konsis = $this->konsis();
        $data = [];
        for ($i = 0; $i < count($prior); $i++) {
            $tes = $i + 1;
            $as = ["C$tes", $konsis[$i], $prior[$i], round($konsis[$i] + $prior[$i], 3)];
            array_push($data, $as);
        }
        return $data;
    }
    public function ir()
    {
        $n = count($this->getData());
        $prior = $this->prior();
        $konsis = $this->konsis();
        $total = 0;
        for ($i = 0; $i < count($prior); $i++) {
            $total += ($konsis[$i] / $prior[$i]);
        }
        $total = round($total * (1 / $n), 3);
        $ci = round((($total - $n) / ($n - 1)), 3);
        $indexRasio = 0;

        $ri = [0.00, 0.00, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59];
        for ($i = 0; $i < count($ri); $i++) {
            if ($n == ($i + 1)) {
                $indexRasio = round($ri[$i], 3);
            }
        }
        $cr = round(($ci / $indexRasio), 3);
        $data = [
            'total' => round($total, 3),
            'ci' => $ci,
            'ir' => $indexRasio,
            'cr' => $cr,
            'konsistensi' => $cr <= 0.1 ? "Konsiten" : "Tidak Konsisten"
        ];
        return $data;
    }
    public function tambah()
    {
        $id1 = $this->input->post('id_kriteria1');
        $id2 = $this->input->post('id_kriteria2');
        $nilai = $this->input->post('nilai');
        $cek = $this->db->get_where($this->table, ['id_kriteria1' => $id1, 'id_kriteria2' => $id2])->row();
        if (!$cek) {
            if ($id1 != $id2) {
                $data = [
                    'id_kriteria1' => $id1,
                    'id_kriteria2' => $id2,
                    'nilai' => $nilai
                ];
                $this->db->insert($this->table, $data);
                $data = [
                    'id_kriteria1' => $id2,
                    'id_kriteria2' => $id1,
                    'nilai' => round(1 / $nilai, 3)
                ];
                $this->db->insert($this->table, $data);
            }
            $result = [
                'status' => true,
                'pesan' => 'Data berhasil disimpan'
            ];
            return $result;
        } else {
            if ($id2 != $id1) {
                $data = [
                    'nilai' => $nilai
                ];
                $this->db->where($this->id, $cek->id_ahp);
                $this->db->update($this->table, $data);
                $cek2 = $this->db->get_where($this->table, ['id_kriteria1' => $id2, 'id_kriteria2' => $id1])->row();
                $data = [
                    'nilai' => round(1 / $nilai, 3)
                ];
                $this->db->where($this->id, $cek2->id_ahp);
                $this->db->update($this->table, $data);
            }

            $result = [
                'status' => true,
                'pesan' => 'Data berhasil diubah'
            ];
            return $result;
        }
    }
    private function data()
    {
        $kriteria = $this->getData();
        $jumlah = [];
        foreach ($kriteria as $row) {
            $tes = [];
            foreach ($kriteria as $row2) {
                $id1 = $this->db->get_where($this->table, ['id_kriteria1' => $row->id_kriteria, 'id_kriteria2' => $row2->id_kriteria])->row();
                if ($id1) {
                    array_push($tes, $id1->nilai);
                } else {
                    array_push($tes, 0);
                }
            }
            array_push($jumlah, $tes);
        }
        return $jumlah;
    }
    private function prior()
    {
        $kriteria = $this->getData();
        $jumlah = $this->data();
        $res = [];
        for ($i = 0; $i < count($jumlah); $i++) {
            $tes = [];
            for ($j = 0; $j < count($jumlah[$i]); $j++) {
                array_push($tes, $jumlah[$j][$i]);
            }
            array_push($res, round(array_sum($tes), 3));
        }
        $i = 0;
        $prior = [];
        foreach ($kriteria as $row) {
            $tes = [$row->label];
            $tes2 = [];
            for ($j = 0; $j < count($jumlah[$i]); $j++) {
                array_push($tes, round((round($jumlah[$i][$j], 3) / round($res[$j], 3)), 3));
                array_push($tes2, round((round($jumlah[$i][$j], 3) / round($res[$j], 3)), 3));
            }
            $jum = round(array_sum($tes), 3);
            array_push($prior, round(($jum / count($kriteria)), 3));
            $i++;
        }
        return $prior;
    }
    private function konsis()
    {
        $prior = $this->prior();
        $jumlah = $this->data();
        $data = [];
        for ($i = 0; $i < count($jumlah); $i++) {
            $jum = [];
            for ($j = 0; $j < count($jumlah[$i]); $j++) {
                array_push($jum, (round($jumlah[$i][$j] * $prior[$j], 3)));
            }
            array_push($data, round(array_sum($jum), 3));
        }
        return $data;
    }
}
