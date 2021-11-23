<?php
	//require '../database/config2.php';
	class rest_api{
	protected $method='';
	protected $params=array();
	protected $endpoint='';
	protected $file=NULL;
	public function __construct(){
		$this->_input();
		$this->_process_api();
	}
	protected function _input(){
		session_start();
		header('Access-Control-Allow-Origin: *  ');
		//header("Access-Control-Allow-Headers: Content-Type");
		header("Access-Control-Allow-Credentials: true");
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header("Access-Control-Request-Method: OPTIONS");
		header('Access-Control-Allow-Headers: AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2, Content-Disposition, Accept-Encoding, Content-Length');
header("connection:keep-alive");

		$this->method=$_SERVER['REQUEST_METHOD'];
		$this->params=explode('/',trim($_SERVER['PATH_INFO'],'/'));
		$this->endpoint=array_shift($this->params);
		switch ($this->method){
			case 'POST':
				$this->params=$_POST;
				break;
			case 'GET':
				$this->params=$_GET;
				break;
			case 'PUT':
				$this->file=file_get_contents("php://input");
				break;
			case 'DELETE':
				$this->params=explode('/',trim($_SERVER['PATH_INFO'],'/'));
				break;
			case 'OPTIONS':
				$this->response(200,"ok");
				die();
				break;
			default:
				$this->response(500,"invalid Method");
				die();
				break;
		}
	}
	protected function _process_api(){
		if(method_exists($this,$this->endpoint)){
			$this->{$this->endpoint}();
		}
		else $this->response(500,"Unknown endpoint");
	}
	protected function response($status_code, $data=NULL){
		header($this->_build_http_header_string($status_code));
		header("Content-Type: application/json");
		//echo json_encode($data,JSON_PRETTY_PRINT);
		echo json_encode($data,JSON_HEX_QUOT | JSON_HEX_TAG);
		//echo json_encode($this->endpoint);
	}	
	protected function _build_http_header_string($status_code){
		$status=array(
			200=>'OK',
			404=>'NOT FOUND',
			405=>'Method not allowed',
			500=>'Internal Server Error'
		);
		return "HTTP/1.1 ".$status_code." ".$status[$status_code];

	}

	

}