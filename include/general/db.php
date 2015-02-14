<?php
//  
//    cIFrex Tool for Static Code Analysis
//    Copyright (C) 2015 cIFrex Team
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see http://www.gnu.org/licenses/.
//

class dbEngine {

	private $linkDb = "";
	private $numOfRows = 0;
	private $arrayResults = 0;
	public $lastInsert = -1;
	
	function __construct($db_config) {
		$this->linkDb = new mysqli($db_config['host'], $db_config['login'], $db_config['password'], $db_config['database']);

		if ($this->linkDb->connect_error) {
    		die('DataBase Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
		}
		
		if (!$this->linkDb->select_db($db_config['database'])) {
    		die('DataBase Select Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
		}
		
	}

   function __destruct() {
	   mysqli_close ( $this->linkDb );
   }
   
   public function sql_execute($sql){
		if (!($execLink = $this->linkDb->query($sql))) {
   			echo "SQL Error: ".$sql;
   		};
	}  

   public function sql_close(){
		$execLink->close();
	}  
	
   public function insertSql($sql){
		if (($execLink = $this->linkDb->query($sql))) {
  			$this->lastInsert = $this->linkDb->insert_id;
   		} else {
   			echo "SQL Error: ".$sql;
 
   		}
	}  
    
    public function updateSql($sql){
		if (!($execLink = $this->linkDb->query($sql))) {
  			echo "SQL Error: ".$sql;
   		}
	}  
    
    public function deleteSql($sql){
		if (!($execLink = $this->linkDb->query($sql))) {
  			echo "SQL Error: ".$sql;
   		}
	}  
		
   public function sql($sql){

		if (($execLink = $this->linkDb->query($sql))) {

			$out=array();
			$this->numOfRows = $execLink->num_rows;
			for($index=0; $index<$this->numOfRows; $index++){
				$out[$index] = $execLink->fetch_array(MYSQLI_ASSOC);
			}
			$this->arrayResults = $out;
			
			$execLink->close();
		} else {
   			echo "SQL Error: ".$sql;
   		}
   		return $this->arrayResults;
	}  
	
	
	
	public function numOfRows(){
		return $this->numOfRows;
	}

	public function getResults(){
		return $this->arrayResults;
	}

}

?>