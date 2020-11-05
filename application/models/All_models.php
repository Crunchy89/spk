<?php
defined('BASEPATH') or exit('No direct script access allowed');

class All_models extends CI_Model
{
    public function is_authenticated($field)
    {
        if (!$this->session->userdata('role')) {
            redirect('auth');
        }
        if ($this->session->userdata('role')) {
            $this->db->select('*');
            $this->db->from('user_access');
            $this->db->join('user_submenu', 'user_access.id_menu=user_submenu.id_menu', 'inner');
            $this->db->where('user_access.id_role', $this->session->userdata('role'));
            $this->db->where('user_submenu.url', $field);
            $access = $this->db->get()->result();
            if (!$access) {
                redirect('page');
            }
        }
    }
}
