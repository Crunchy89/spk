<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rangking extends MY_Controller
{

	public function __construct()
	{
		if (!$this->session->userdata('role')) {
			redirect('auth');
		}
		if ($this->session->userdata('role')) {
			$this->db->select('*');
			$this->db->from('user_access');
			$this->db->join('user_submenu', 'user_access.id_menu=user_submenu.id_menu', 'inner');
			$this->db->where('user_access.id_role', $this->session->userdata('role'));
			$this->db->where('user_submenu.url', 'rangking');
			$access = $this->db->get()->result();
			if (!$access) {
				redirect('page');
			}
		}
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
