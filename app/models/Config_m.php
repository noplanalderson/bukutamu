<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_m extends CI_Model {

	public function getAppSetting()
	{
		return $this->db->get('tb_app_setting', 1)->row();
	}	

	public function getAdmin()
	{
		$this->db->where('type_id', 1);
		return $this->db->get('tb_user')->num_rows();
	}

	public function insertSetting($settings)
	{
		return $this->db->insert('tb_app_setting', [
			'app_title' => $settings['app_title'],
			'app_footer' => $settings['app_footer'],
			'app_logo'=> $settings['app_logo'],
			'app_logo_dashboard' => $settings['app_logo_dashboard']
		]) ? true : false;
	}

	public function tambahAdmin($admin)
	{
		return $this->db->insert('tb_user', $admin) ? $this->db->insert_id() : false;
	}
}

/* End of file config_m.php */
/* Location: ./application/models/config_m.php */