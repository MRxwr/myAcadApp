<?php
//database connections
function deleteDB($table, $where){
    GLOBAL $dbconnect;
    $check = [';', '"'];
    $where = str_replace($check, "", $where);
    $sql = "DELETE FROM `" . $table . "` WHERE " . $where;
    if ($stmt = $dbconnect->prepare($sql)) {
        if ($stmt->execute()) {
            return 1;
        } else {
            $error = array("msg" => "delete table error");
            return outputError($error);
        }
        $stmt->close();
    } else {
        $error = array("msg" => "prepare statement error");
        return outputError($error);
    }
}

function selectDBNew($table, $placeHolders, $where, $order){
    GLOBAL $dbconnect;
    $check = [';', '"'];
    $where = str_replace($check, "", $where);
    $sql = "SELECT * FROM `{$table}`";
    if(!empty($where)) {
        $sql .= " WHERE {$where}";
    }
    if(!empty($order)) {
        $sql .= " ORDER BY {$order}";
    }
    if( $table == "employees" && strstr($where,"email") ){
        $array = array(
            "userId" => 0,
            "username" => 0,
            "module" => "Login",
            "action" => "Select",
            "sqlQuery" => json_encode(array("table"=>$table,"data"=>$placeHolders,"where"=>$where)),
        );
        LogsHistory($array);
    }
    if($stmt = $dbconnect->prepare($sql)) {
        $types = str_repeat('s', count($placeHolders));
        $stmt->bind_param($types, ...$placeHolders);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
        if(isset($array) && is_array($array)) {
            return $array;
        }else{
            return 0;
        }
    }else{
        return 0;
    }
}

function selectDB($table, $where){
    GLOBAL $dbconnect;
    $check = [';', '"'];
    $where = str_replace($check, "", $where);
    $sql = "SELECT * FROM `{$table}`";
    if (!empty($where)) {
        $sql .= " WHERE {$where}";
    }
    if ($stmt = $dbconnect->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
        if (isset($array) && is_array($array)) {
            return $array;
        } else {
            return 0;
        }
    } else {
        $error = array("msg" => "select table error");
        return 0;
    }
}

function selectDB2($select, $table, $where){
    GLOBAL $dbconnect;
    $check = [';', '"'];
    $where = str_replace($check, "", $where);
    $sql = "SELECT {$select} FROM `{$table}`";
    if (!empty($where)) {
        $sql .= " WHERE {$where}";
    }
    if ($stmt = $dbconnect->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
        if (isset($array) && is_array($array)) {
            return $array;
        } else {
            return 0;
        }
    } else {
        $error = array("msg" => "select table error");
        return 0;
    }
}

function selectJoinDB($table, $joinData, $where){
    global $dbconnect;
    global $date;
    $check = [';', '"'];
    $where = str_replace($check,"",$where);
    $sql = "SELECT ";
    for($i = 0 ; $i < sizeof($joinData["select"]) ; $i++ ){
        $sql .= $joinData["select"][$i];
        if ( $i+1 != sizeof($joinData["select"]) ){
            $sql .= ", ";
        }
    }
    $sql .=" FROM `$table` as t ";
    for($i = 0 ; $i < sizeof($joinData["join"]) ; $i++ ){
        $counter = $i+1;
        $sql .= " JOIN `".$joinData["join"][$i]."` as t{$counter} ";
        if( isset($joinData["on"][$i]) && !empty($joinData["on"][$i]) ){
            $sql .= " ON ".$joinData["on"][$i]." ";
        }
    }
    if ( !empty($where) ){
        $sql .= " WHERE " . $where;
    }
    if($stmt = $dbconnect->prepare($sql)){
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc() ){
            $array[] = $row;
        }
        if ( isset($array) AND is_array($array) ){
            return $array;
        }else{
            return 0;
        }
    }else{
        $error = array("msg"=>"select table error");
        return outputError($error);
    }
}

function insertDB($table, $data){
    GLOBAL $dbconnect;
    $check = [';', '"'];
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $data[$key] = json_encode($value);
        }
    }
    //$data = escapeString($data);
    $keys = array_keys($data);
    $sql = "INSERT INTO `{$table}`(";
    $placeholders = "";
    foreach ($keys as $key) {
        $sql .= "`{$key}`,";
        $placeholders .= "?,";
    }
    $sql = rtrim($sql, ",");
    $placeholders = rtrim($placeholders, ",");
    echo $sql .= ") VALUES ({$placeholders})";
    $stmt = $dbconnect->prepare($sql);
    $types = str_repeat('s', count($data));
    $stmt->bind_param($types, ...array_values($data));
    if($stmt->execute()){
        return 1;
    }else{
        $error = array("msg"=>"insert table error");
        return outputError($error);
    }
}

function insertDB2($table, $data){
	GLOBAL $dbconnect;
	//$check = [';','"',"'"];
	//$data = str_replace($check,"",$data);
	$keys = array_keys($data);
	$sql = "INSERT INTO `".$table."`(";
	for($i = 0 ; $i < sizeof($keys) ; $i++ ){
		$sql .= "`".$keys[$i]."`";
		if ( isset($keys[$i+1]) ){
			$sql .= ", ";
		}
	}
	$sql .= ")VALUES(";
	for($i = 0 ; $i < sizeof($data) ; $i++ ){
		$sql .= "'".$data[$keys[$i]]."'";
		if ( isset($keys[$i+1]) ){
			$sql .= ", ";
		}
	}		
	$sql .= ")";
	if($dbconnect->query($sql)){
		return 1;
	}else{
		return 0;
	}
}

function updateDB($table, $data, $where) {
    GLOBAL $dbconnect;
    $check = [';', '"']; 
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $data[$key] = json_encode($value);
        }
    }
    //$data = escapeString($data);
    $where = str_replace($check, "", $where);
    $keys = array_keys($data);
    $sql = "UPDATE `" . $table . "` SET ";
    $params = "";
    for ($i = 0; $i < sizeof($data); $i++) {
        $sql .= "`" . $keys[$i] . "` = ?";
        if (isset($keys[$i + 1])) {
            $sql .= ", ";
        }
        $params .= "s";
    }
    $sql .= " WHERE " . $where;
    $stmt = $dbconnect->prepare($sql); 
    $values = array_values($data);
    $stmt->bind_param($params, ...$values);
    if ($stmt->execute()) {
        return 1;
    } else {
        $error = array("msg" => "update table error");
        return outputError($error);
    }
}

function escapeString($data){
	GLOBAL $dbconnect;
	$keys = array_keys($data);
	for($i = 0 ; $i < sizeof($keys) ; $i++ ){
		$output[$keys[$i]] = mysqli_real_escape_string($dbconnect,$data[$keys[$i]]);
	}
	return $output;
}

function escapeStringDirect($data){
	GLOBAL $dbconnect;
	$output = mysqli_real_escape_string($dbconnect,$data);
	return $output;
}


function insertLogDB($table,$data){
    GLOBAL $dbconnect;
    $check = [';', '"'];
    //$data = escapeString($data);
    $keys = array_keys($data);
    $sql = "INSERT INTO `{$table}`(";
    $placeholders = "";
    foreach ($keys as $key) {
        $sql .= "`{$key}`,";
        $placeholders .= "?,";
    }
    $sql = rtrim($sql, ",");
    $placeholders = rtrim($placeholders, ",");
    $sql .= ") VALUES ({$placeholders})";
    $stmt = $dbconnect->prepare($sql);
    $types = str_repeat('s', count($data));
    $stmt->bind_param($types, ...array_values($data));
    if($stmt->execute()){
        return 1;
    }else{
        $error = array("msg"=>"insert table error");
        return outputError($error);
    }
}

function LogsHistory($array){
    insertLogDB("logs",$array);
}

?>