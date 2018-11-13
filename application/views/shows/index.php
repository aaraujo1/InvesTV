<div class="row">
        <div class="col col-sm-3">
	</div>
	<div class="col col-sm-9">
            <div ng-view>

			</div> <!-- end panel -->
    	</div> <!-- end col-9 -->
   </div> <!-- end row -->	

	<?php
	
	//$vulns = $data->CVE_Items;
	
	/*if (file_exists($file)) {
    echo "The file $file exists";
	} else {
    echo "The file $file does not exist";
	}*/
	
	/*$show = new Show('Lost');
	
	echo $show->title . '<br />';
	echo $show->plot . '<br />';
	echo 'Rating: ' . $show->rating . '<br />';
	echo 'IMDB ID: ' . $show->imdbID . '<br />';
	echo 'Rating from Seasons: ' . $show->getShowRating() . '<br />';
	echo 'Seasons: ' . $show->totalSeasons . '<br />';
	echo '<img src="' . $show->poster . '"><br />';
	
	echo 'Current Season: ' . $show->seasons[0]->season . '/' . $show->seasons[0]->totalSeasons . '<br />';
	echo 'Number of episodes: ' . $show->seasons[0]->numberOfEpisodes . '<br />';
	echo 'Season Rating: ' . $show->seasons[0]->getSeasonRating() . '<br />' . '<br />';

	foreach($show->seasons[0]->episodes as $e){
		echo $e->title . '<br />';
		echo 'Rating: ' . $e->rating . '<br />';
		echo 'Released: ' . $e->released . '<br />';
		echo 'Episode: ' . $e->episode . '<br /><br />';
	}*/
	
//	foreach ($vulns as $vuln) {
//    $cveid = $vuln->cve->CVE_data_meta->ID;
//    echo $cveid; echo '<br>';
//	}
	?>
