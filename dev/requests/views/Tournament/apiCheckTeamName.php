<?php 
if( $teams = selectDBNew("orders",[$_GET["tournamentId"],$_GET["teamName"]],"`status` = '1' AND `tournamentId` = ? AND `teamName` LIKE ?","") ){
    echo outputError(array("msg"=>"Team name already exists."));
}else{
    echo outputData(array("msg"=>"You can use this team name."));
}
?>