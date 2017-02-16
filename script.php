<?php
taxonomy_vocabulary_save((object) array(
  'name' => 'menu',
  'machine_name' => 'menu',
));
$vid = db_query("SELECT vid FROM {taxonomy_vocabulary} where machine_name = 'menu'")->fetchField();

$arr = variable_get('etsy');
rotation($vid,$arr);
function rotation($vid,$array){
	foreach ($array as $g_key => $g_value) {
		$gid = taxonomy_save($g_key,$vid);
		foreach ($g_value as $p_key => $p_value) {
			$pid = taxonomy_save($p_key,$vid,$gid);
			foreach ($p_value as $c_key => $c_value) {
				$tid = taxonomy_save($c_key,$vid,$pid);
			}
		}
	}
}

function taxonomy_save($name, $vid,$pid = NULL) {
  $term = new stdClass();
  $term->name = $name;
  $term->vid = $vid;
  if(!empty($pid)){
  	$term->parent = $pid;
  }
  taxonomy_term_save($term);
  return $term->tid;
}
?>
