<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilitas_m extends CI_Model {

	public function getSysLog($start, $end)
	{
		$this->db->select('log_type, log_timestamp, log_message');
		$this->db->where("UNIX_TIMESTAMP(log_timestamp) BETWEEN '$start' AND '$end'");
		$this->db->order_by('log_timestamp', 'desc');
		return $this->db->get('tb_log_sistem')->result_array();
	}	

	public function insertLog($item)
	{
		$this->db->insert('tb_log_sistem', [
			'log_type' => $item->log_type,
			'log_timestamp' => $item->log_timestamp,
			'log_message' => $item->log_message
		]);
	}
}

/* End of file Utilitas_m.php */
/* Location: .//C/xampp/htdocs/bukutamu/app/models/Utilitas_m.php */