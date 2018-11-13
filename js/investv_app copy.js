// JavaScript Document
var app = angular.module('investvApp', ['ngRoute', 'chart.js']);

// might be needed for ajax requests
// set by CodeIgniter in HTML
app.base_url = '';

// define some global variables available to the entire app
app.run(function($rootScope, $location) {
	$rootScope.appName = 'InvesTV';
	
	$rootScope.isActive = function(viewLocation){
		return viewLocation === $location.path();
	};
	$rootScope.shows = [];
	$rootScope.showBasic = '';
	
	$rootScope.clear = function(){
		$rootScope.shows = [];
		$rootScope.showBasic = '';
	};
});

//service to pass data between controllers
//SOURCE: https://stackoverflow.com/questions/25601755/angular-ng-click-load-controller
/*app.service('Share', function(){
	//return {text: 'hello'};
	var text ='show';
   return { 
     get: function(){
       return text;
    },
     set: function(value){
      text=value;
      console.log(text);
    },
      value:text
    };
});*/

// configure our routes
app.config(function($routeProvider) {
	$routeProvider

		// Home page
		.when('/', {
			templateUrl : 'pages/home.html',
			controller  : 'homeController'
		})

		// Show detal page
		.when('/shows', {
			templateUrl : 'pages/shows.html',
			controller  : 'showsController'
		})
	
	// Show detail page
		.when('/Show/:showName', {
			templateUrl : 'pages/show.html',
			controller  : 'homeController'
		})
	
		// My Shows page
		.when('/myShows', {
			templateUrl: 'pages/myShows.html',
			controller: 'myShowsController',
        });
});

//configure controllers
app.controller('homeController', function($scope, $http, $rootScope, $routeParams){
	$scope.search = '';
	$scope.loading = false;
	$scope.preload = true;
	//$scope.shows = [];
	$scope.show = {};
	//$scope.showSeasons = '';
	$scope.episodes = [];
	$scope.ratingsArray = [];
	$scope.episodeListArray = [];
	$scope.totalEpisodes = 0;
	//chart color
	$scope.colors = "yellow";
	
	
	
	// perform "default" search when the page loads
	angular.element(document).ready(function(){
		//$scope.findShows();
		
		$scope.preload = false;
		
		console.log("showBasic");
		console.log($rootScope.showBasic);
		
		if ($rootScope.showBasic){
			$scope.loadShowDetails($rootScope.showBasic.Title);
		}
	});
	
	
	$scope.preloadShowsBuy = [
		{
            "Title": "Game of Thrones",
            "Year": "2011–",
            "imdbID": "tt0944947",
            "Type": "series",
            "Poster": "https://m.media-amazon.com/images/M/MV5BMjE3NTQ1NDg1Ml5BMl5BanBnXkFtZTgwNzY2NDA0MjI@._V1_SX300.jpg"
        },
		{
            "Title": "Daredevil",
            "Year": "2015–",
            "imdbID": "tt3322312",
            "Type": "series",
            "Poster": "https://m.media-amazon.com/images/M/MV5BODcwOTg2MDE3NF5BMl5BanBnXkFtZTgwNTUyNTY1NjM@._V1_SX300.jpg"
        },
		{
            "Title": "Doctor Who",
            "Year": "2005–",
            "imdbID": "tt0436992",
            "Type": "series",
            "Poster": "https://m.media-amazon.com/images/M/MV5BNDY1YmZhZjEtY2E3NC00M2VkLThlZmUtODczMmNiZjMxMWRhXkEyXkFqcGdeQXVyNzA5NTYxMDg@._V1_SX300.jpg"
        }
	];
	
	$scope.preloadShowsSell = [
		{
            "Title": "Arrow",
            "Year": "2012–",
            "imdbID": "tt2193021",
            "Type": "series",
            "Poster": "https://m.media-amazon.com/images/M/MV5BMTU5MjU5NjUyOV5BMl5BanBnXkFtZTgwMDY1ODIyNjM@._V1_SX300.jpg"
        },
		{
            "Title": "The Walking Dead",
            "Year": "2010–",
            "imdbID": "tt1520211",
            "Type": "series",
            "Poster": "https://m.media-amazon.com/images/M/MV5BMTcwMDAzMDk3OF5BMl5BanBnXkFtZTgwMjY0MzcyNjM@._V1_SX300.jpg"
        },
		{
            "Title": "The Simpsons",
            "Year": "1989–",
            "imdbID": "tt0096697",
            "Type": "series",
            "Poster": "https://m.media-amazon.com/images/M/MV5BYjFkMTlkYWUtZWFhNy00M2FmLThiOTYtYTRiYjVlZWYxNmJkXkEyXkFqcGdeQXVyNTAyODkwOQ@@._V1_SX300.jpg"
        }
	];
	
	$scope.preloadShowDetails = function(show){
		/*$rootScope.shows = $scope.preloadShows;*/
		$rootScope.shows = $rootScope.shows.concat($scope.preloadShowsBuy, $scope.preloadShowsSell);
		
		$scope.loadShowDetails(show.Title);
	};
	
	
	
	//search API
	$scope.findShows = function(){
		$scope.loading = true;
		$scope.preload = true;
		
		$http({
			method: 'get',
			url: 'https://www.omdbapi.com/',
			params: {apikey: '670e6ec0', type:'series', s: $scope.search}
		}).then(function(response){
			$rootScope.shows = response.data.Search;
			console.log("shows");
			console.log($rootScope.shows);
			/*console.log("show");
			console.log($scope.show);*/
			$scope.loading = false;
			if ($rootScope.shows){
				$scope.preload = false;
				
			}else{
				$scope.preload = true;
			}
		});
		
	};
	
	$scope.add = function(show, e){
		$scope.loadShowDetails(show.Title);
		$scope.addToList(e);
	};
	
	//post to database
	$scope.addToList = function(e){
		e.target.innerHTML = 'Adding...';
		e.target.classname = 'btn btn-primary';
		
		/*console.log("add function starting");
		console.log(show);*/
		
		
		
		$http({
			method: 'post',
			url: app.base_url + 'shows/add', // CI route
			data: {showData: $scope.show}//,
				  //user: user->id}//if i know id of user in angluar, I can pass it as a reqest
		}).then(function(response){
			// check response to make sure everything was okay
			// ...
			
			e.target.innerHTML = 'Added!';
			e.target.className = 'btn btn-success';
		});
	};
	
	$scope.loadShowDetails = function(showTitle){
		//$scope.loading = true;
		$http({
			method: 'get',
			url: 'https://www.omdbapi.com/',
			params: {apikey: '670e6ec0', type:'series', t: showTitle}
		}).then(function(response){
			$scope.show = response.data;
			//"show" object before functions
			console.log("show");
			console.log($scope.show);
			
			//get number of seasons the show has, 
			//and make that number of queries to get episodes of each season 
			$scope.show.Seasons = $scope.loadEpisodes($scope.show.totalSeasons, showTitle);
			
			//log function
			console.log("loadEpisodes function done ");
			
			console.log("Season array");
			console.log($scope.episodes);
			
			
			
			//console.log("Season array length: ");
			//console.log($scope.show.Seasons.length);
			//console.log($scope.episodes.length);
			
			//get total number of episodes and add to "show" object
			//$scope.show.totalEpisodes = $scope.getTotalEpisodes($scope.show.Seasons);
			//$scope.show.totalEpisodes = $scope.getTotalEpisodes($scope.episodes);
			
			//$scope.show.totalEpisodes = $scope.totalEpisodes;
			//log function 
			//console.log("getTotalEpisodes function done ");
			
			
			//make sure functions added to the "show" object
			console.log($scope.show);
			
			
			//$scope.loading = false;
		});
		//$rootScope.showDetail = show;
		//$scope.show = show;
	};
	
	$scope.loadEpisodes = function(seasons, showTitle){
		//var counter = 0;
		$scope.show.totalEpisodes = 0;
		
		//get total of ratings
		var total = 0.0;
		
		for (var i = 1; i <= seasons; i++){
			$http({
				method: 'get',
				url: 'https://www.omdbapi.com/',
				params: {apikey: '670e6ec0', type:'series', t: showTitle, Season: i}
			}).then(function(response){
				//add object to array
				$scope.episodes.push(response.data);
				console.log(i);
				console.log(response.data);
				/*console.log(response.data.Episodes);
				console.log(response.data.Episodes.length);*/
				
				//get episode array length and total it
				//$scope.show.totalEpisodes += response.data.Episodes.length;
				
				for(var j = 0; j < response.data.Episodes.length; j++){
					if (response.data.Episodes[j].imdbRating != "N/A"){
						$scope.ratingsArray.push(parseFloat(response.data.Episodes[j].imdbRating));
						total += parseFloat(response.data.Episodes[j].imdbRating);
						$scope.episodeListArray.push("S" + response.data.Season + "E" + response.data.Episodes[j].Episode);
					}
				}
				
				//set total number of episodes
				$scope.show.totalEpisodes = $scope.ratingsArray.length;
				//set array of episodes ratings
				$scope.show.ratingsArray = $scope.ratingsArray;
				
				//get total of episode ratings
				$scope.show.episodeRatingTotal = total;
				
				//get average episode ratings
				$scope.show.episodeRatings = ($scope.show.episodeRatingTotal/$scope.show.totalEpisodes).toFixed(1);
				
				
				//get min and max ratings
				//SOURCE: https://codeburst.io/javascript-finding-minimum-and-maximum-values-in-an-array-of-objects-329c5c7e22a2
				
				console.log("best episode");
				console.log(Math.max(...$scope.ratingsArray));
				console.log($scope.ratingsArray.indexOf(Math.max(...$scope.ratingsArray)));
				console.log($scope.episodeListArray[$scope.ratingsArray.indexOf(Math.max(...$scope.ratingsArray))]);
				
				
				$scope.show.bestEpisode = $scope.episodeListArray[$scope.ratingsArray.indexOf(Math.max(...$scope.ratingsArray))];
				$scope.show.worstEpisode = $scope.episodeListArray[$scope.ratingsArray.indexOf(Math.min(...$scope.ratingsArray))];
				/*$scope.show.worstEpisode = function() {
					return $scope.ratingsArray.reduce((min, p) => p.y < min ? p.y : min, $scope.ratingsArray[0].y);
				};

				$scope.show.bestEpisode = function() {
					return $scope.ratingsArray.reduce((max, p) => p.y > max ? p.y : max, $scope.ratingsArray[0].y);
				};*/
				
				
				
				//chart data and labels
				$scope.labels = $scope.episodeListArray;
				$scope.data = $scope.ratingsArray;
				
			});
			
			
			
			//console.log($scope.labels);
			//console.log($scope.data);
		}
		
		/*//get min and max ratings
		//SOURCE: https://codeburst.io/javascript-finding-minimum-and-maximum-values-in-an-array-of-objects-329c5c7e22a2
		function getMinY(data) {
			return data.reduce((min, p) => p.y < min ? p.y : min, data[0].y);
		}
		
		function getMaxY(data) {
			return data.reduce((max, p) => p.y > max ? p.y : max, data[0].y);
		}*/
//		console.log("episodes");
//		console.log($scope.episodes);
		/*console.log("counter after");
		console.log(counter);
		$scope.show.totalEpisodes = counter;*/
		
		//get total of ratings
				
		
		
		return $scope.episodes;
		
	};
	
	/*$scope.getTotalEpisodes = function(seasonArray){
		var counter = 0;
		console.log("starting getTotalEpisodes function");
		console.log(counter);
		console.log(seasonArray);
		console.log(seasonArray.length);
		console.log(seasonArray[0]);
		console.log(seasonArray[0].Episodes);
		console.log(seasonArray[0].Episodes.length);
		
		for (var i = 0; i < seasonArray.length; i++){
			counter += seasonArray[i].Episodes.length;
			console.log(seasonArray[i]);
			
		}
		console.log(counter);
		return counter;
		
	};*/
	
	
	
	$rootScope.showBasic = $rootScope.shows.find(function(s){
		return s.Title == $routeParams.showName;
	});
	
	
	
	
});

/*app.controller('showsController', function($scope, Share, $rootScope, $routeParams){
	// perform "default" search when the page loads
	angular.element(document).ready(function(){
		//alert("show");
	});
	
	$scope.showDetails = function(show){
		//$scope.loading = true;
		$http({
			method: 'get',
			url: 'https://www.omdbapi.com/',
			params: {apikey: '670e6ec0', type:'series', i: $rootScope.show.title}
		}).then(function(response){
			$scope.shows = response.data.Search;
			//$scope.loading = false;
		});
	};
	
	
});*/

app.controller('myShowsController', function($scope, $http){
	$scope.loading = true;
	$scope.showList = [];
	$scope.currentEpisodeName = '';
	$scope.remainingRating = '0';
	
	angular.element(document).ready(function(){
		// get Shows from our database
		$http({
			method: 'get',
			url: app.base_url + 'shows/list' // CI route
		}).then(function(response){
			$scope.showList = response.data;
			$scope.loading = false;
			console.log($scope.showList);
			
			
		});
	});
	
	$scope.nextEpisode = function(show){
		//add 1
		show.episode ++;
		//save to DB
		$scope.updateList(show);
		//get remaining ratings
		$scope.remainingRating(show);
		
	}
	
	//post to database
	$scope.updateList = function(show){
		//e.target.innerHTML = 'Adding...';
		//e.target.classname = 'btn btn-primary';
		
		/*console.log("add function starting");
		console.log(show);*/
		
		
		
		$http({
			method: 'post',
			url: app.base_url + 'shows/update', // CI route
			data: {showData: $scope.show}//,
				  //user: user->id}//if i know id of user in angluar, I can pass it as a reqest
		}).then(function(response){
			// check response to make sure everything was okay
			// ...
			
			//e.target.innerHTML = 'update!';
			//e.target.className = 'btn btn-success';
		});
	};
	
	$scope.remainingRating = function(show){
		var arr = show.object.ratingsArray;
		
		var total = 0.0;
		
		$scope.show.remainingRating = arr.splice(0,1,'');
	};
	
	
	
	$scope.removeFromCollection = function(show, e){
		e.target.innerHTML = 'Removing...';
		
		// remove from database
		$http({
			method: 'get',
			url: app.base_url + 'shows/remove/' + show.id // CI route
		}).then(function(response){
			// check response to make sure everything was okay
			// ...
			
			// remove from local array
			var index = $scope.showList.indexOf(show);
  			$scope.showList.splice(index, 1);    
		});
	};
});
