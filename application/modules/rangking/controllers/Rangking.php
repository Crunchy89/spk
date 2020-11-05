<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rangking extends MY_Controller
{

	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("rangking");
		parent::__construct();
		$this->load->model('rangking_model', 'model');
	}
	public function index()
	{
		$data = [
			'judul' => 'Perangkingan',
			'kriteria' => $this->db->get('kriteria')->result()
		];
		$this->load->view('index', $data);
	}
	public function getData()
	{
		$data = $this->model->getData();
		echo json_encode($data);
	}
	public function rank()
	{
		$data = $this->model->rank();
		echo json_encode($data);
	}
}
