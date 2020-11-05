<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends MY_Controller
{

	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("kriteria");
		parent::__construct();
		$this->load->model('kriteria_model', 'model');
	}
	public function index()
	{
		$data = [
			'judul' => 'Kriteria'
		];
		$this->load->view('index', $data);
	}
	public function getData()
	{
		$data = $this->model->getData();
		echo json_encode($data);
	}
	public function aksi()
	{
		$aksi = $this->input->post('aksi');
		$data = [];
		if ($aksi == 'tambah') {
			$data = $this->model->tambah();
		} elseif ($aksi == 'edit') {
			$data = $this->model->edit();
		} elseif ($aksi == 'hapus') {
			$data = $this->model->hapus();
		}
		echo json_encode($data);
	}
}
