<?php
mysql_connect('localhost','root','');
mysql_select_db('sashas_sashas');
mysql_set_charset('utf8');
$sql="select id, tag FROm articles";

$res=mysql_query($sql);

while ($row=mysql_fetch_assoc($res)) {
	 
	// fore each article
	$id=$row['id'];
	$tags=array();
	$tags=explode(', ', $row['tag']);
	 foreach ($tags as $tag) {
	 	$t_sql="select id from tags WHERE tag='".$tag."'";
	 	$t_res=mysql_query($t_sql);
	 	while ($t_row=mysql_fetch_assoc($t_res)) {
	 	 
	 		$r_sql="INSERT INTO tag_relation (article_id,tag_id) VALUES ('".$id."','".$t_row['id']."')";
	 		mysql_query($r_sql);
	 	}
	 }
	
}