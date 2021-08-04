<?php

$api	=	key($_GET);
$key	=	$_REQUEST[$api];


function callAPI($url, $inputs ){
    $curl = curl_init();

    $url = sprintf("%s?%s", $url, http_build_query($inputs));

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
function formatTitle($title){
	if( strlen($title) > 40){
		return trim(mb_substr($title, 0, 35, "utf-8")).'...';
	}
	return trim($title);
}

//$inputs		=	array('apikey'=>'92087764','s'=>$q);
$inputs		=	array('apikey'=>'80b8c7af',$api=>$key);
$apiUrl		=	'http://www.omdbapi.com/';
$result		=	callAPI($apiUrl,$inputs);
$response	=	json_decode($result);

if(!empty($response) && $response->Response == 'True'){
	if( strtolower($api) == 's' ){
		$Search		=	$response->Search;
		$searchList		=	"";
		foreach($Search as $index => $row){
			$imdbID		=	$row->imdbID."".$index;
			$poster		=	"assets/images/no-poster.jpg";
			if( strtolower($row->Poster) != '' && strtolower($row->Poster) != 'na' && strtolower($row->Poster) != 'n/a'){
				$poster		=	$row->Poster;
			}
			$searchList		.=	'<div class="tooltip">';
					$searchList		.=	'<a target="_blank" href="'.($poster).'" class="poster" onmouseover="getMovieInfo(`'.$imdbID.'`,`'.$row->imdbID.'`);" onfocusin="getMovieInfo(`'.$imdbID.'`,`'.$row->imdbID.'`);">';
				$searchList		.=	'<div class="gallery" >';
						$searchList		.=	'<img src="'.($poster).'" alt="'.($row->Title).'" width="600" height="400">';
					$searchList		.=	'<div class="title">'.formatTitle($row->Title).'</div>';
					$searchList		.=	'<div class="movie-type">'.ucwords($row->Type).'</div>';
				$searchList		.=	'</div>';
				
				$searchList		.=	'<span class="tooltiptext" id="'.$imdbID.'">';
					
				$searchList		.=	'</span>';
					$searchList		.=	'</a>';
			$searchList		.=	'</div>';
		}
		echo $searchList;
	}else if(strtolower($api) == 'i'){
		$info	=	'';
		$info	.=	'<label class="info">'.$response->Title.'</label>';
		$info	.=	'<label class="info">Year : '.$response->Year.'</label>';
		$info	.=	'<label class="info">Director : '.$response->Director.'</label>';
		$info	.=	'<label class="info">Rating : '.$response->imdbRating.'</label>';
		
		echo $info;
	}
}else{
	echo "<center>".$response->Error."</center>";
}


?>