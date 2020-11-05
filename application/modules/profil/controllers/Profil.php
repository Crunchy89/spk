<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{

	public function __construct()
	{
		$this->load->model('all_models', 'all');
		$this->all->is_authenticated("profil");
		parent::__construct();
		$this->load->model('profil_model', 'model');
	}
	public function index()
	{
		$data = [
			'judul' => 'Profil Sekolah'
		];
		$this->load->view('index', $data);
	}
	public function getProfile()
	{
		$data = $this->model->getProfile();
		echo json_encode($data);
	}
	public function getMedsos()
	{
		$data = $this->model->getMedsos();
		echo json_encode($data);
	}
	public function update()
	{
		$data = $this->model->update();
		echo json_encode($data);
	}
}
