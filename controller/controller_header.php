<?php
	$server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
	mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
	mysqli_set_charset($server_bd,"utf8");
?>
<?php
  	global $user_ID,$current_user;
  	get_currentuserinfo();
	if (!$user_ID){
		
	}else{
		$id_user = get_current_user_id();
				
		$query_select = "SELECT ID_score,Amount_score FROM kk_score_users WHERE ID_user = $id_user";
		$res_query    = mysqli_query($server_bd, $query_select) or die(mysqli_error($server_bd));
		$row_query    = mysqli_fetch_row($res_query);
		$amount_score = (int)$row_query[1];
		$m_amount_score = $amount_score;
		if($amount_score>=1000){
			$m_amount_score = intval($amount_score/1000);
			$m_amount_score = $m_amount_score . 'К';
		}		

		$query_select = "SELECT ID_purse,Amount_purse FROM kk_purse_users WHERE ID_user = $id_user";
		$res_query    = mysqli_query($server_bd, $query_select) or die(mysqli_error($server_bd));
		$row_query    = mysqli_fetch_row($res_query);
		$amount_purse = (int)$row_query[1];
		$m_amount_purse = $amount_purse;
		if($amount_purse>=1000){
			$m_amount_purse = intval($amount_purse/1000);
			$m_amount_purse = $m_amount_purse . 'К';
		}	
	}
?>
<?php
	mysqli_close($server_bd);
?>