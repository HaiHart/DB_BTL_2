<?php
	require "rest_api.php";
	$_POST = json_decode(file_get_contents('php://input'), true);
	class chi_nhanh extends rest_api{
		protected function getCN(){
			$connect=new mysqli("localhost","root","donQuiote2","CONGTY");			
			$sql="CALL ShowAllCn()";
			$result= $connect->query($sql);
			//$connect->close();
			if($result)
				{
					$test=array();
					while($row = mysqli_fetch_assoc($result))
    					$test[] = $row; 
					$this->response(200,$test);
					//echo json_encode($test);
				}
			else {
				//echo $connect->error;
				$this->response(404,$connect->error);
			}
		}
		protected function upCN(){

			$connect=new mysqli("localhost","root","donQuiote2","CONGTY");	
			$id=$this->params['id'];
			$sn=$this->params['so_nha'];		
			if(strlen($sn)<1){
				$this->response(404,"empty change");
				return;
			} elseif (strlen($id)<1){
				$this->response(404,"Empty id");
				return;
			}
			$sql="CALL up_cn('$id','$sn')";
			$result= $connect->query($sql);
			//$connect->close();
			if(!$result){
				$this->response(404,$connect->error);
				return;
			}
			$sql="CALL ShowAllCn()";
			$result= $connect->query($sql);
			if($result)
				{
					$test=array();
					while($row = mysqli_fetch_assoc($result))
    					$test[] = $row; 
					$this->response(200,$test);
					//echo json_encode($test);
				}
			else {
				//echo $connect->error;
				$this->response(404,$connect->error);
			}
		}
		protected function delCN(){
			$connect=new mysqli("localhost","root","donQuiote2","CONGTY");			
			$sql="CALL del_cn(".$this->params['id'].")";
			$result= $connect->query($sql);
			//$connect->close();
			if(!$result){
				$this->response(404,$connect->error);
				return;
			}
			$sql="CALL ShowAllCn()";
			$result= $connect->query($sql);
			if($result)
				{
					$test=array();
					while($row = mysqli_fetch_assoc($result))
    					$test[] = $row; 
					$this->response(200,$test);
					//echo json_encode($test);
				}
			else {
				//echo $connect->error;
				$this->response(404,$connect->error);
			}
		}
		protected function addCN(){
			$connect=new mysqli("localhost","root","donQuiote2","CONGTY");	
			$tinh=$this->params['tinh'];
			$sn=$this->params['so_nha'];		
			$sql="CALL add_cn('$tinh','$sn')";
			$result= $connect->query($sql);
			//$connect->close();
			if(!$result){
				$this->response(404,$connect->error);
				return;
			}
			$sql="CALL ShowAllCn()";
			$result= $connect->query($sql);
			if($result)
				{
					$test=array();
					while($row = mysqli_fetch_assoc($result))
    					$test[] = $row; 
					$this->response(200,$test);
					//echo json_encode($test);
				}
			else {
				//echo $connect->error;
				$this->response(404,$connect->error);
			}
		}
		protected function searchCN(){
			$connect=new mysqli("localhost","root","donQuiote2","CONGTY");	
			$tinh=$this->params['term'];		
			if(strlen($tinh)<1){
				$this->response(404,"Empty term");
				return;
			}
			$sql="CALL SearchCn('$tinh')";
			$result= $connect->query($sql);
			//$connect->close();
			if(!$result){
				$this->response(404,$connect->error);
				return;
			}
			if($result)
				{
					$test=array();
					while($row = mysqli_fetch_assoc($result))
    					$test[] = $row; 
					if(count($test)>0)$this->response(200,$test);
					else $this->response(404,"Empty");
					//echo json_encode($test);
				}
			else {
				//echo $connect->error;
				$this->response(404,$connect->error);
			}
		}
	}
	$cn_api=new chi_nhanh();