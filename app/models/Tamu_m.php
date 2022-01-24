<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tamu_m extends CI_Model {

	public function tamuMasuk($post, $hash, $token)
	{
		return $this->db->insert('tb_log_tamu', [
			'visitor_hash' => $hash,
			'time_in' => time(),
			'nama_tamu' => $post['nama_tamu'],
			'nomor_telepon' => $post['nomor_telepon'],
			'organisasi' => $post['organisasi'],
			'keperluan' => $post['keperluan'],
			'foto' => $post['dataurl'],
			'token_tamu' => $token
		]) ? true : false;
	}	

	public function checkToken($token)
	{
		$this->db->select('visitor_hash, nama_tamu');
		$this->db->where('token_tamu', $token);
		return $this->db->get('tb_log_tamu');
	}

	public function tamuKeluar($hash)
	{
		$this->db->where('visitor_hash', $hash);
		$this->db->update('tb_log_tamu', ['time_out' => time(), 'token_tamu' => null]);

		return ($this->db->affected_rows() > 0) ? true : false;
	}

}

/* End of file Tamu_m.php */
/* Location: .//C/xampp/htdocs/bukutamu/app/models/Tamu_m.php */