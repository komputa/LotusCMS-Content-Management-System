<?php

class Table{
	
	protected $cols;
	
	protected $name;
	
	protected $up;
	
	protected $finished;
	
	protected $rows;
	
	protected $head;
	
	protected $id;
	
	/**
	 *
	 */
	public function Table(){
		$this->rows = null;
		$this->head = false;
	}
	
	/**
	 *
	 */
	public function createTable($name){
		
		//Set the name of the table
		$this->name = $name;
		
		//Set the true
		$this->up = true;
	}	
	
	public function setHead($bool){
		$this->head = $bool;	
	}
	
	/**
	 *
	 */
	public function addRow($data){
		$this->rows[] = $data;
	}
	
	//Sets ID to table
	public function addID($data){
		$this->id = $data;
	}
	
	public function runTable(){
		$style = "";
		
		if(!empty($this->id)){
			$style = " id='".$this->id."'";	
		}
		
		$final = "<table".$style." width='100%'>";
		
		for($i = 0; $i < count($this->rows); $i++)
		{
			if($i==0&&$this->head){
				$final .= "<thead>";
				$final .= "<tr>";
			}else if($i==1&&$this->head){
				$final .= "<tbody><tr>";
			}else{
				$final .= "<tr>";	
			}
				
				for($y = 0;$y < count($this->rows[$i]);$y++)
				{
					if($i==0&&$this->head){
						$final .= "<th>";
						
							$final .= $this->rows[$i][$y];
							
						$final .= "</th>";
					}else{
						$final .= "<td class='col".$y."'>";
						
							$final .= $this->rows[$i][$y];
							
						$final .= "</td>";
					}
				}
				
			if($i==0&&$this->head){
				$final .= "</tr>";
				$final .= "</thead>";
			}else{
				$final .= "</tr>";	
			}
		}
		
		if($this->head){
			$final .= "</tbody>";	
		}
		
		$final .= "</table>";
		
		//Set the final variable
		$this->finished = $final;
	}
	
	public function getTable(){
		return $this->finished;	
	}
}

?>