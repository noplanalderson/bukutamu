<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_headers {

	public $config = [];

	protected $_CI;

	public function __construct()
	{
		include APPPATH . 'config/securityheaders.php';

		$this->config = $config;

		$this->_CI =& get_instance();
	}

	public function permissionPolicy()
	{
		$rules = [];

		if(!empty($this->config['permissions_policy'])) {
			foreach ($this->config['permissions_policy'] as $key => $value) {
				
				if($value === '') {
					$rules[] = $key.'=()';
				}
				elseif($value === '*')
				{
					$rules[] = $key.'=*';
				}
				else
				{
					$rules[] = $key.'=('.$value.')';
				}
			}
		}

		return $rules;		
	}

	public function generate()
	{
		if($this->config['xss_protection_header'] !== false) {
			$this->_CI->output->set_header('X-XSS-Protection:'.$this->config['xss_protection_header']);
		}

		if($this->config['access_control_allow_origin'] !== false) {
			$this->_CI->output->set_header('Access-Control-Allow-Origin:'.$this->config['xss_protection_header']);
		}

		if($this->config['x_frame_options'] !== false) {
			$this->_CI->output->set_header('X-Frame-Options:'.$this->config['x_frame_options']);
		}

		if($this->config['expect_ct'] !== false) {
			$this->_CI->output->set_header('Expect-CT:'.$this->config['expect_ct']);
		}

		if($this->config['x_content_type_options'] !== false) {
			$this->_CI->output->set_header('X-Content-Type-Options:'.$this->config['x_content_type_options']);
		}

		if($this->config['nel'] !== false) {
			$this->_CI->output->set_header('NEL:'.$this->config['nel']);
		}

		if($this->config['cross_origin_embedder_policy'] !== false) {
			$this->_CI->output->set_header('Cross-Origin-Embedder-Policy:'.$this->config['cross_origin_embedder_policy']);
		}

		if($this->config['cross_origin_opener_policy'] !== false) {
			$this->_CI->output->set_header('Cross-Origin-Opener-Policy:'.$this->config['cross_origin_opener_policy']);
		}

		if($this->config['cross_origin_resource_policy'] !== false) {
			$this->_CI->output->set_header('Cross-Origin-Resource-Policy:'.$this->config['cross_origin_resource_policy']);
		}

		if($this->config['referrer_policy'] !== false) {
			$this->_CI->output->set_header('Referrer-Policy:'.$this->config['referrer_policy']);
		}

		if($this->config['strict_transport_security'] !== false) {
			$this->_CI->output->set_header('Strict-Transport-Security:'.$this->config['strict_transport_security']);
		}

		if(!empty($this->config['permissions_policy'])) {
			$this->_CI->output->set_header('Permissions-Policy:'.implode(',', $this->permissionPolicy()));
		}
	}
}