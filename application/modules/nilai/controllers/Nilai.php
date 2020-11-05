<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai extends MY_Controller
{

	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("nilai");
		parent::__construct();
		$this->load->model('nilai_model', 'model');
	}
	public function index()
	{
		$data = [
			'judul' => 'Nilai Alternatif',
			'alternatif' => $this->db->get('alternatif')->result(),
			'kriteria' => $this->db->get('kriteria')->result()
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
		$data = $this->model->tambah();
		echo json_encode($data);
	}
}
