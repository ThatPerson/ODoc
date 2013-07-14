<?php
	$page = (isset($_GET['q'])) ? $_GET['q'] : "index.md";
	$page = str_replace("/", "", $page);
	$page = str_replace("..", "", $page);
	if (!file_exists("docs/".$page)) {
		echo "Not found";
		exit(0);
	}
	$pagecontent = file_get_contents("docs/".$page);
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
	$pagecontent = " ".implode("<br>", $pc);
	$pagecontent = str_replace("</li><br><li>", "</li><li>", $pagecontent);
	$pagecontent = str_replace("<br><ul>", "<ul>", $pagecontent);
	$pagecontent = str_replace("<br></ul>", "</ul>", $pagecontent);
	$pagecontent = preg_replace("/##[^#]+##/", "//<h2>$0</h2>//", $pagecontent);
	$pagecontent = str_replace("##", "", $pagecontent);
	$pagecontent = preg_replace("/#[^#]+#/", "/<i><h3>$0</h3></i>/", $pagecontent);

	$pagecontent = preg_replace("/[^<]\//", "", $pagecontent);

	$pagecontent = str_replace("\\", "", $pagecontent);
	$pagecontent = str_replace("#", "", $pagecontent);
	$pagecontent = str_replace("<br><br>", "<br>", $pagecontent);
	
	echo $pagecontent;
?>
