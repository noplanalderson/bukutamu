<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk_m extends CI_Model {

	public function verify($user_name)
	{
		$this->db->select('a.user_id, a.user_password, b.index_page, b.type_id');
		$this->db->join('tb_user_type b', 'a.type_id = b.type_id', 'inner');
		$this->db->where('a.user_status', 'enable');
		$this->db->group_start();
		$this->db->where('a.user_name', $user_name);
		$this->db->or_where('a.user_email', $user_name);
		$this->db->group_end();
		return $this->db->get('tb_user a');
	}

	public function update_login_data()
	{
		$this->db->where('user_id', $this->session->userdata('uid'));
		$this->db->update('tb_user', 
			array(
				'last_login' => $this->session->userdata('time'),
				'last_ip' => inet_pton(get_real_ip()),
			)
		);
	}

	public function getUserByToken($token)
	{
		$this->db->where('user_token', $token);
		return $this->db->get('tb_user')->num_rows();
	}
	
	public function doActivation($account, $token)
	{
		$this->db->where('user_token', $token);
		return $this->db->update('tb_user', $account) ? true : false;
	}
}

/* End of file Masuk_m.php */
/* Location: ./app/models/Masuk_m.php */