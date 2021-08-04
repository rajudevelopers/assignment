<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/style.css"></link>
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script>
			searchMovie = (search) => {
				
				if (search.length < 3) {
					document.getElementById("movies").innerHTML = "";
					return;
				} else {
					$("#loading").show();
					let xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("movies").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET", "controllers/api.php?s=" + search, true);
					xmlhttp.send();
					$("#loading").hide();
				}
				
			}
			getMovieInfo = (id,imdbID) => {
				$(".poster").focusout();
				if(document.getElementById(id).innerHTML == ''){
					let xmlHttp = new XMLHttpRequest();
					xmlHttp.open( "GET", "controllers/api.php?i=" + imdbID, false ); 
					xmlHttp.send( null );
					console.log( xmlHttp.responseText);
					document.getElementById(id).innerHTML = xmlHttp.responseText;
				}
			}
		</script>
	</head>
	<body>
		<div id="loading"></div>
		<div class="header">
			<input type="text" class="search-box" placeholder="Search Movie or TV Show" onkeyup="searchMovie(this.value)">
		</div>
		<div class="container">
			<span id="movies" >
				
			</span>
		</div>
	</body>
</html>
