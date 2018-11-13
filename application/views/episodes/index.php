<?php
	
	//$vulns = $data->CVE_Items;
	
	/*if (file_exists($file)) {
    echo "The file $file exists";
	} else {
    echo "The file $file does not exist";
	}*/
	
	$episode = new Episode('3');
	
	echo $episode->showTitle . '<br />';
	echo 'Season: ' . $episode->season . '<br />';
/*foreach ($episode->episodes as $e){
	echo $e->Title;
}*/
	echo $episode->title . '<br />';
	echo 'Rating: ' . $episode->rating . '<br />';
	echo 'Released: ' . $episode->released . '<br />';
	echo 'Episode: ' . $episode->episode . '<br />';
	
	
	
	
	
//	foreach ($vulns as $vuln) {
//    $cveid = $vuln->cve->CVE_data_meta->ID;
//    echo $cveid; echo '<br>';
//	}
	?>
</body>
</html>