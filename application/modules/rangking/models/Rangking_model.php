<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rangking_model extends CI_Model
{
    public function __construct()
    {
        $this->table = 'ahp';
        $this->id = 'id_ahp';
    }
    public function getData()
    {
        $hitung = $this->hitung();
        $alternatif = $this->db->get('alternatif')->result();
        $tes = [];
        for ($i = 0; $i < count($hitung); $i++) {
            $a = round(array_sum($hitung[$i]), 3);
            array_push($hitung[$i], $a);
            array_push($tes, $hitung[$i]);
        }
        $i = 0;
        foreach ($alternatif as $row) {
            array_unshift($tes[$i], $row->alternatif);
            $i++;
        }
        return $tes;
    }
    public function rank()
    {
        $hitung = $this->hitung();
        $alternatif = $this->db->get('alternatif')->result();
        $tes = [];
        for ($i = 0; $i < count($hitung); $i++) {
            $a = round(array_sum($hitung[$i]), 3);
            array_push($tes, [$a]);
        }
        $i = 0;
        foreach ($alternatif as $row) {
            array_unshift($tes[$i], $row->alternatif);
            $i++;
        }
        return $tes;
    }
    private function hitung()
    {
        $data = [];
        $prioritas = $this->prior();
        $tes = [];
        for ($i = 0; $i < count($prioritas); $i++) {
            array_push($tes, round(($prioritas[$i] * 100), 3));
        }
        $prioritas = $tes;
        $kriteria = $this->db->get('kriteria')->result();
        $alternatif = $this->db->get('alternatif')->result();
        $nilai = [];
        foreach ($alternatif as $row) {
            $tes2 = [];
            foreach ($kriteria as $row2) {
                $cek = $this->db->get_where('nilai', ['id_alternatif' => $row->id_alternatif, 'id_kriteria' => $row2->id_kriteria])->row();
                if ($cek) {
                    array_push($tes2, $cek->nilai);
                } else {
                    array_push($tes2, 0);
                }
            }
            array_push($nilai, $tes2);
        }

        for ($i = 0; $i < count($nilai); $i++) {
            $tes3 = [];
            for ($j = 0; $j < count($nilai[$i]); $j++) {
                array_push($tes3, round(($nilai[$i][$j] * $prioritas[$j]) / 100, 3));
            }
            array_push($data, $tes3);
        }

        return $data;
    }
    private function data()
    {
        $kriteria = $this->db->get('kriteria')->result();
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
        $kriteria = $this->db->get('kriteria')->result();
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
}
