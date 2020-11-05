<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hitung extends MY_Controller
{

	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("hitung");
		parent::__construct();
		$this->load->model('hitung_model', 'model');
	}
	public function index()
	{
		$data = [
			'judul' => 'Perhitungan AHP',
			'kriteria' => $this->db->get('kriteria')->result()
		];
		$this->load->view('index', $data);
	}
	public function getData()
	{
		$data = $this->model->getData();
		echo json_encode($data);
	}
	public function ahp()
	{
		$data = $this->model->ahp();
		echo json_encode($data);
	}
	public function nilai_kriteria()
	{
		$data = $this->model->nilai_kriteria();
		echo json_encode($data);
	}
	public function tambah()
	{
		$data = $this->model->tambah();
		echo json_encode($data);
	}
	public function matrix_baris()
	{
		$data = $this->model->matrix_baris();
		echo json_encode($data);
	}
	public function rasio()
	{
		$data = $this->model->rasio();
		echo json_encode($data);
	}
	public function ir()
	{
		$data = $this->model->ir();
		echo json_encode($data);
	}
}
