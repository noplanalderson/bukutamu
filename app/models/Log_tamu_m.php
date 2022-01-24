<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_tamu_m extends CI_Model {

	public function getLogTamu($start, $end)
	{
		$this->db->select("visitor_hash, time_in, time_out, nama_tamu, nomor_telepon, organisasi, keperluan");
		$this->db->where("time_in BETWEEN '$start' AND '$end'");
		$this->db->order_by('log_id', 'desc');
		return $this->db->get('tb_log_tamu')->result();
	}

	public function getTamuByHash($hash)
	{
		$this->db->where('visitor_hash', $hash);
		return $this->db->get('tb_log_tamu')->row_array();
	}
}

/* End of file log_tamu_m.php */
/* Location: ./application/models/log_tamu_m.php */