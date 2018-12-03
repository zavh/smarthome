<?php
class DbTables{
	public $con;
	public $table;

	function __construct($con, $table) {
        $this->con = $con;
				$this->table = $table;
    }

	public function idToField($id, $field){
		$sql = "SELECT $id, $field from ".$this->table;
		$dbresult = $this->getDbResult($sql);

		$result = array();
		$i=0;

		if($dbresult->num_rows > 0){
			while($row = $dbresult->fetch_assoc()){
				$result[$id][$i] 		= $row[$id];
				$result[$field][$i] 	= $row[$field];
				$i++;
			}
		}
		return $result;
	}

	public function idLookUp($field, $value, $id){
		$sql = "SELECT `$id` FROM `".$this->table."` WHERE `$field` = '$value'";
		$dbresult = $this->getDbResult($sql);
		$resultid = NULL;
		if($dbresult->num_rows > 0){
			$row = $dbresult->fetch_assoc();
			$resultid = $row[$id];
		}
		return $resultid;
	}

	public function valueLookUp($field, $value, $id){
		$columns = "`".implode("`, `",array_values($field))."`";
		$sql = "SELECT $columns FROM `".$this->table."` WHERE `$id` = '$value'";
		//echo $sql;
		$dbresult = $this->getDbResult($sql);
		$resultval = NULL;
		$i=0;
		if($dbresult->num_rows > 0){
			$row = $dbresult->fetch_assoc();
			$resultval[$i++] = $row;
		}
		return $resultval;
	}

	public function insertRecord($insData){
		$columns = "`".implode("`, `",array_keys($insData))."`";
		$escaped_values = array_map(array($this->con, 'real_escape_string'), array_values($insData));
		$values = '';
		//$values  = "'".implode("', '", $escaped_values)."'";
		for($i=0;$i<count($escaped_values);$i++){
			if($i>0) $values .=",";
			if($escaped_values[$i] !='NULL')
				$values .= "'".$escaped_values[$i]."'";
			else $values .= 'NULL';
		}
		$sql = "INSERT INTO `".$this->table."` ($columns) VALUES ($values)";
		//echo $sql;
		$this->con->query($sql);
		return $this->con->insert_id;
	}

	public function getSqlResult($sql){
		//echo $sql;
		$result = $this->getDbResult($sql);
		$queryresult = array();
		$i = 0;
		while($row = $result->fetch_assoc()){
			$queryresult[$i++] = $row;
		}
		return $queryresult;
	}
	public function updateRecord($field, $newvalue, $idfield, $idvalue){
		$sql = "UPDATE `".$this->table."` SET `".$field."` = '".$newvalue."' WHERE `".$this->table."`.`".$idfield."` = ".$idvalue." ";
		$result = $this->getDbResult($sql);
		//echo $sql;
		return $result;
	}

	public function updateRecords($newVals, $idfield, $idvalue){
		$setStmt = '';
		$count =0;
		foreach($newVals as $key=>$val){
			if($count > 0) $setStmt .= ", ";
			$count++;
			if($val == NULL)
			$setStmt .= " `$key` = NULL ";
			else $setStmt .= " `$key` = '$val' ";
		}
		$sql = "UPDATE `".$this->table."` SET $setStmt WHERE `".$this->table."`.`".$idfield."` = ".$idvalue." ";
		//echo $sql;
		$result = $this->getDbResult($sql);
		return $result;
	}

	public function setNull($field, $idfield, $idvalue){
		$sql = "UPDATE `".$this->table."` SET `".$field."` = NULL WHERE `".$this->table."`.`".$idfield."` = ".$idvalue." ";
		$result = $this->getDbResult($sql);
		//echo $sql;
		return $result;
	}

	public function deleteRecord($id, $value){
		$sql = "DELETE FROM ".$this->table." where `$id`='$value'";
		$result = $this->getDbResult($sql);
		return $result;
	}
	private function getDbResult($sql){
		$con = $this->con;
		$dbresult = $con->query($sql);

		return $dbresult;
	}

	public function __destruct() {
		;
    }
}
?>
