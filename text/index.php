<?php
	$page = (isset($_GET['page'])) ? intval($_GET['page']) : 0;
	$arr = explode("\n", file_get_contents("../docs/DOCLIST"));
	$titles = array(); //
	$url = array();

	
	for ($i = 0; $i < count($arr); $i++) {
		$p = explode("::", $arr[$i]);
		$titles[] = $p[1];
		$url[] = $p[0];
	}
	
	$pagecontent = file_get_contents("../docs/".$url[$page]);
	$pc = explode("\n", $pagecontent);
	$depth = 0;
	for ($i = 0; $i < count($pc); $i++) {
		if ($pc[$i][0] == "@") {
			if ($depth == 0) {
				$pc[$i] = "<ul><li>".substr($pc[$i],1)."</li>";
				$depth = 1;
			} else {
				$pc[$i] = "<li>".substr($pc[$i], 1)."</li>";
			}
		} else {
			if ($depth == 1) {
				$depth = 0;
				$pc[$i] = "</ul>".$pc[$i];
			}
		}
	}
	$pagecontent = implode("<br>", $pc);
	$pagecontent = str_replace("</li><br><li>", "</li><li>", $pagecontent);
	$pagecontent = str_replace("<br><ul>", "<ul>", $pagecontent);
	$pagecontent = str_replace("<br></ul>", "</ul>", $pagecontent);
	$pagecontent = preg_replace("/##[^#]+##/", "//<b>$0</b>//", $pagecontent);
	$pagecontent = str_replace("##", "", $pagecontent);
	$pagecontent = preg_replace("/#[^#]+#/", "/<i><b>$0</b></i>/", $pagecontent);
	$pagecontent = str_replace("#", "", $pagecontent);
	
	for ($i = 0; $i < count($arr); $i++) {
		echo '<a href="index.php?page='.$i.'">'.$titles[$i].'</a><br>';
	}
	
	echo $pagecontent;
?>
