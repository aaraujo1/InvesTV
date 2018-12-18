// JavaScript Document
var app = angular.module('investvApp', ['ngRoute', 'chart.js']);

// might be needed for ajax requests
// set by CodeIgniter in HTML
app.base_url = '';

// define some global variables available to the entire app
app.run(function ($rootScope, $location) {
	$rootScope.appName = 'InvesTV';

	$rootScope.isActive = function (viewLocation) {
		return viewLocation === $location.path();
	};
	$rootScope.shows = [];
	$rootScope.search = '';


	$rootScope.clear = function () {
		$rootScope.shows = [];
		$rootScope.search = '';
	};
});

//filter to return integer from string and remove extra string
app.filter('num', function () {
	return function (input) {
		return parseInt(input.substring(0, input.length - 4), 10);
	};
});

//filter to get only shows that haven't been marked as removed
//SOURCE: https://stackoverflow.com/questions/20858395/how-to-use-ng-repeat-with-filter-and-index
app.filter('removed', function(){
	return function(data, parameter){
		var removed=[];
		for(var i=0; i < data.length; i++){
			if(data[i].flagRemove === parameter){
				removed.push(data[i]);
			}
		}
		return removed;
	};
});

app.filter('filterList', function(){
	return function(data, pKey, pValue){
		var filtered=[];
		data.forEach(function(element){
			if(element.pKey === pValue){
				filtered.push(element);
			}
		});
		return filtered;
	};
});

//number with commas using REGEX
//SOURCE: https://stackoverflow.com/questions/2901102/how-to-print-a-number-with-commas-as-thousands-separators-in-javascript
app.filter('numberWithCommas', function(){
	return function(x) {
    	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	};
});

// configure our routes
app.config(function ($routeProvider) {
	$routeProvider

	// Home page
		.when('/', {
		templateUrl: 'pages/home.html',
		controller: 'homeController'
	})

	// Show detail page
	.when('/Show/:showName', {
		//		.when('/Show/:showName', {
		templateUrl: 'pages/show.html',
		controller: 'showsController'
	})


	// My Shows page
	.when('/myShows', {
		templateUrl: 'pages/myShows.html',
		controller: 'myShowsController',
	})

	//register page
	.when('/User/Register', {
		templateUrl: 'pages/register.html',
		controller: 'registerController',
	})

	//login page
	.when('/User/Login', {
		templateUrl: 'pages/login.html',
		controller: 'loginController',
	})

	//user profile page
	.when('/User/:username', {
		templateUrl: 'pages/user.html',
		controller: 'userController',
	});
	
	/*.when('/User/User', {
		templateUrl: 'pages/user.html',
		controller: 'userController',
	});*/

});

//configure controllers

//home page
app.controller('homeController', function ($scope, $http, $rootScope) {
	$scope.loading = false;
	$scope.preload = true;
	$scope.show = {};
	$scope.episodes = [];
	$scope.ratingsArray = [];
	$scope.episodeListArray = [];
	$scope.totalEpisodes = 0;
	//chart color
	$scope.colors = ["rgba(155,216,235,0.75)"];

	//preloaded shows to view detail. hard coded objects.
	$scope.preloadShowsBuy = [
		{
		"Title": "Game of Thrones",
		"Poster": "https://m.media-amazon.com/images/M/MV5BMjE3NTQ1NDg1Ml5BMl5BanBnXkFtZTgwNzY2NDA0MjI@._V1_SX300.jpg"
	}, 
		{
		"Title": "Daredevil",
		"Poster": "https://m.media-amazon.com/images/M/MV5BODcwOTg2MDE3NF5BMl5BanBnXkFtZTgwNTUyNTY1NjM@._V1_SX300.jpg"
	}, 
		/*{
		"Title": "Doctor Who",
		"Year": "2005–",
		"imdbID": "tt0436992",
		"Type": "series",
		"Poster": "https://m.media-amazon.com/images/M/MV5BNDY1YmZhZjEtY2E3NC00M2VkLThlZmUtODczMmNiZjMxMWRhXkEyXkFqcGdeQXVyNzA5NTYxMDg@._V1_SX300.jpg"
		},*/
		{
		"Title": "Stranger Things",
    	"Poster": "https://m.media-amazon.com/images/M/MV5BMjUwMDgzOTg3Nl5BMl5BanBnXkFtZTgwNTI4MDk5MzI@._V1_SX300.jpg",
		}
	];
	$scope.preloadShowsSell = [
		{
		"Title": "Arrow",
		"Poster": "https://m.media-amazon.com/images/M/MV5BMTU5MjU5NjUyOV5BMl5BanBnXkFtZTgwMDY1ODIyNjM@._V1_SX300.jpg"
	}, {
		"Title": "The Walking Dead",
		"Poster": "https://m.media-amazon.com/images/M/MV5BMTcwMDAzMDk3OF5BMl5BanBnXkFtZTgwMjY0MzcyNjM@._V1_SX300.jpg"
	}, {
		"Title": "Dexter",
		"Poster": "https://m.media-amazon.com/images/M/MV5BMTM5MjkwMTI0MV5BMl5BanBnXkFtZTcwODQwMTc0OQ@@._V1_SX300.jpg"
	}];


	// perform "default" search when the page loads
	angular.element(document).ready(function () {

		//see in console if $rootScope.search is empty or not
		console.log("rootScope.Search: " + $rootScope.search);

		//search for whatever is in the $rootScope.search variable
		$scope.findShows();

		//see if anything got loaded in the $rootScope.shows array
		if ($rootScope.shows) {
			//it contains object, so don't display preloaded shows
			$scope.preload = false;
		} else {
			//it is empty, so display prelaoded shows
			$scope.preload = true;
		}
	});

	//search API for shows
	$scope.findShows = function () {
		$scope.loading = true;
		$scope.preload = false;

		$http({
			method: 'get',
			url: 'https://www.omdbapi.com/',
			params: {
				apikey: '670e6ec0',
				type: 'series',
				s: $rootScope.search
			}
		}).then(function (response) {
			$rootScope.shows = response.data.Search;
			console.log("shows");
			console.log($rootScope.shows);
			/*console.log("show");
			console.log($scope.show);*/
			$scope.loading = false;

			if ($rootScope.shows) {
				$scope.preload = false;

			} else {
				$scope.preload = true;
			}
		});

	};



	/*------------------------------------*/
	/*------ METHODS TO ADD TO LIST ------*/
	/*------------------------------------*/

	//done during search

	/*$scope.add = function (show, e) {
		$scope.loadShowDetails(show.Title);
		$scope.addToList(e);
	};*/

	//post to database
	/*$scope.addToList = function (e) {
		e.target.innerHTML = 'Adding...';
		e.target.classname = 'btn btn-primary';

		


		$http({
			method: 'post',
			url: app.base_url + 'shows/add', // CI route
			data: {
				showData: $scope.show
			} //,
			//user: user->id}//if i know id of user in angluar, I can pass it as a reqest
		}).then(function () {
			// check response to make sure everything was okay
			// ...

			e.target.innerHTML = 'Added!';
			e.target.className = 'btn btn-success';
		});
	};*/


});

//show detail
app.controller('showsController', function ($scope, $http, $rootScope, $routeParams) {
	$scope.show = {};
	$scope.ratingsArray = [];
	$scope.episodeListArray = [];
	$scope.totalEpisodes = 0;
	$scope.total = 0.0;

	// perform  search when the page loads
	angular.element(document).ready(function () {
		//load show
		$scope.loadShowDetails();
	});

	/*-----------------------------------------*/
	/*------ METHODS TO GET SHOW DETAILS ------*/
	/*-----------------------------------------*/

	/*---- load show ----*/
	$scope.loadShowDetails = function () {
		//$scope.loading = true;
		$http({
			method: 'get',
			url: 'https://www.omdbapi.com/',
			params: {
				apikey: '670e6ec0',
				type: 'series',
				t: $routeParams.showName
			}
		}).then(function (response) {
			$scope.show = response.data;
			//"show" object before functions
			console.log("loadShowDetails done. show:");
			console.log($scope.show);

			//get number of seasons the show has, 
			//and make that number of queries to get episodes of each season 

			//get season and episode info
			$scope.show.Seasons = [];

			$scope.show.Seasons = $scope.loadSeasons($scope.show.totalSeasons, $scope.show.Title);

		});

	};

	/*------ USING PROMISES ------*/
	
	/*---- load seasons of a show ----*/
	$scope.loadSeasons = function (seasons) {
		//var counter = 0;
		$scope.show.totalEpisodes = 0;

		//array for promises
		var ajaxCalls = [];

		//make AJAX calls based on number of seasons
		for (var i = 1; i <= seasons; i++) {
			//add to array of promises
			ajaxCalls.push($scope.loadEpisodesPerSeason(i));
		}

		//check all promises
		//SOURCE: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise/all
		Promise.all(ajaxCalls).then(function () {
			//once promises are successful, get additional details on show
			$scope.loadEpisodeData($scope.show.Seasons);
		});

		//return array of seasons
		return $scope.show.Seasons;
	};

	/*---- load season ----*/
	$scope.loadEpisodesPerSeason = function (i) {

		//returning a promise
		return $http({
			method: 'get',
			url: 'https://www.omdbapi.com/',
			params: {
				apikey: '670e6ec0',
				type: 'series',
				t: $scope.show.Title,
				Season: i
			}
		}).then(function (response) {
			//add response to array in specific index
			$scope.show.Seasons[i - 1] = response.data;
		});
	};

	/*---- gather additional details on show ----*/
	$scope.loadEpisodeData = function (episodeArray) {

		//get total of ratings
		//array of seasons
		console.log("starting loadEpisodeData");
		console.log(episodeArray);
		console.log("episodeArray length: " + episodeArray.length);


		//loop through seasons
		for (var i = 0; i < episodeArray.length; i++) {
			console.log(episodeArray);

			//array of episodes in a season
			for (var j = 0; j < episodeArray[i].Episodes.length; j++) {
				console.log("episodeArray length: " + episodeArray[i].Episodes.length);

				if (episodeArray[i].Episodes[j].imdbRating !== "N/A") {
					//add rating from each episode to an array
					$scope.ratingsArray.push(parseFloat(episodeArray[i].Episodes[j].imdbRating));

					//add rating to total
					$scope.total += parseFloat(episodeArray[i].Episodes[j].imdbRating);

					//array of episode by name
					$scope.episodeListArray.push("S" + episodeArray[i].Season + "E" + episodeArray[i].Episodes[j].Episode);
				}
			}
		}

		//apply to $scope.show - forces angular to rewatch object
		//SOURCE: http://jimhoskins.com/2012/12/17/angularjs-and-apply.html
		$scope.$apply(function () {



			//set total number of episodes
			$scope.show.totalEpisodes = $scope.ratingsArray.length;

			//set array of episodes ratings
			$scope.show.ratingsArray = $scope.ratingsArray;

			//set array of episode references
			$scope.show.episodeListArray = $scope.episodeListArray;

			//get total of episode ratings
			$scope.show.episodeRatingTotal = $scope.total;

			//get average episode ratings
			$scope.show.episodeRatings = ($scope.show.episodeRatingTotal / $scope.show.totalEpisodes).toFixed(1);


			//get min and max ratings
			//SOURCE: https://codeburst.io/javascript-finding-minimum-and-maximum-values-in-an-array-of-objects-329c5c7e22a2
			$scope.show.bestEpisode = $scope.episodeListArray[$scope.ratingsArray.indexOf(Math.max(...$scope.ratingsArray))];
			$scope.show.worstEpisode = $scope.episodeListArray[$scope.ratingsArray.indexOf(Math.min(...$scope.ratingsArray))];


			//chart data and labels
			$scope.labels = $scope.episodeListArray;
			$scope.data = $scope.ratingsArray;

		});
	};

	/*------------------------------------*/
	/*------ METHODS TO ADD TO LIST ------*/
	/*------------------------------------*/

	$scope.addToList = function (e) {
		e.target.innerHTML = 'Adding...';
		e.target.classname = 'btn btn-primary';

		/*console.log("add function starting");
		console.log(show);*/



		$http({
			method: 'post',
			url: app.base_url + 'shows/add', // CI route
			data: {
				showData: $scope.show
			} //,
			//user: user->id}//if i know id of user in angluar, I can pass it as a reqest
		}).then(function () {
			// check response to make sure everything was okay
			// ...

			e.target.innerHTML = 'Added!';
			e.target.className = 'btn btn-success';
		});
	};

});

//my show list
app.controller('myShowsController', function ($scope, $http) {
	$scope.loading = true;
	$scope.showList = [];
	$scope.watchingList = [];
	$scope.removedList = [];
	$scope.currentEpisodeName = '';
	$scope.remainingRating = '0';
	$scope.user = {};
	$scope.colors = ["rgba(155,216,235,0.75)"];
	
	$scope.sortAlphaOrder = 'ascending';
	$scope.sortNumOrder = 'ascending';


	angular.element(document).ready(function () {
		$scope.loadShows();
	});
	
	/*--------------------------------------*/
	/*------ METHODS TO GET SHOW LIST ------*/
	/*--------------------------------------*/ 
	
	//load shows
	$scope.loadShows = function(){
		// get Shows from our database
		$http({
			method: 'get',
			url: app.base_url + 'shows/listShows/' + 1 // CI route
		}).then(function (response) {
			console.log(response.data);
			$scope.showList = response.data.showList;
			$scope.watchingList = response.data.watchingList;
			$scope.removedList = response.data.removedList;
			//$scope.id = response.data.id;
			$scope.loading = false;
			
			console.log($scope.showList);

		
		
		$scope.showList.forEach(function(s){
			console.log(s);
			$scope.loadShowStats(s);
			
		});
			
		$scope.watchingList.forEach(function(s){
			console.log(s);
			$scope.loadShowStats(s);
			
		});
		
		console.log($scope.showList);
		console.log($scope.watchingList);
			});
	};
	
	/*------ USING MATH JS ------*/
	
	//get stats of a show
	$scope.loadShowStats = function (show){
		show.stats = {};
		show.stats.standardDeviation = math.std(show.ratingsArray);
		
		var ratingsArraySorted = show.ratingsArray.slice();
		
		math.sort(ratingsArraySorted);
		
		if ((show.totalEpisodes/2)%5){
			//odd number of shows
			show.stats.ratingsArraySortedFirstHalf = ratingsArraySorted.slice(0 , math.ceil(show.totalEpisodes/2));
			show.stats.ratingsArraySortedSecondHalf = ratingsArraySorted.slice(show.totalEpisodes/2);
		}else{
			//even number of shows
			show.stats.ratingsArraySortedFirstHalf = ratingsArraySorted.slice(0 , math.floor(show.totalEpisodes/2));
			show.stats.ratingsArraySortedSecondHalf = ratingsArraySorted.slice(show.totalEpisodes/2);
		}
		
		show.stats.quartile = [math.median(show.stats.ratingsArraySortedFirstHalf), math.median(show.ratingsArray), math.median(show.stats.ratingsArraySortedSecondHalf)];
		
		
		//show.quartile = math.quantileSeq(show.ratingsArray,[0.5],true);
		show.stats.iqr = show.stats.quartile[2]-show.stats.quartile[0];
		show.stats.lowerLimit = show.stats.quartile[0] - (show.stats.iqr * 1.5);
		show.stats.upperLimit = show.stats.quartile[2] - 0  + (show.stats.iqr * 1.5);
		
		//SOURCE: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter
		show.stats.lowerOutliers = show.stats.ratingsArraySortedFirstHalf.filter(rating => rating < show.stats.lowerLimit);
		show.stats.upperOutliers = show.stats.ratingsArraySortedSecondHalf.filter(rating => rating > show.stats.upperLimit);
		show.stats.outliers = show.stats.lowerOutliers.length + show.stats.upperOutliers.length;
	};

	/*---------------------------------------*/
	/*------ METHODS TO EDIT SHOW LIST ------*/
	/*---------------------------------------*/
	
	//add show to watching list
	$scope.addWatching = function (show, e){
		
		
		e.target.innerHTML = 'Adding...';
		
		show.flagWatching = true;
		
		$http({
			method: 'post',
			url: app.base_url + 'shows/addWatching/', // CI route
			data: {
				//showData: $scope.showList
				showData: show
			}
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...
			console.log(response);

			//$scope.$apply(function (){
			// remove from local showList array
			var index = $scope.showList.indexOf(show);
			$scope.showList.splice(index, 1);
			console.log($scope.showList);
			// add to local watchingList array
			$scope.watchingList.push(show);
			console.log($scope.watchingList);
			
			
			//});
		});
	};
	
	//move to next episode in show
	$scope.nextEpisode = function (show, e) {
		//add 1 to current episode
		//check if no more episodes
		
		if (show.Seasons[show.currentSeason].Episodes.length >  show.currentEpisode+1){
			//there are still episodes in the season
			show.currentEpisode++;
			show.totalEpisodesWatched++;
		} else {
			//there are no more episodes, so go to the next season
			//check if there are more seasons
			if (show.Seasons.length >  show.currentSeason+1){
				//there are more seasons
				show.currentSeason++;
				//reset episode
				show.currentEpisode = 0;
				show.totalEpisodesWatched++;
			}else{
				$scope.removeWatching(show, e);
				$scope.removeFromCollection(show, e);
				
			}
		}

		console.log(show);

		//save to DB
		$scope.updateList(show);

		
		//check if last episode
		//if so...

		//if not
		//get remaining ratings
		$scope.remainingRating(show);

		//remake chart?

	};

	//post to database
	$scope.updateList = function (show) {
		//e.target.innerHTML = 'Adding...';
		//e.target.classname = 'btn btn-primary';

		/*console.log("add function starting");
		console.log(show);*/




		$http({
			method: 'post',
			url: app.base_url + 'shows/update', // CI route
			data: {
				//showData: $scope.showList
				showData: show
			} //,
			//user: user->id}//if i know id of user in angluar, I can pass it as a reqest
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...
			console.log(response);
			//e.target.innerHTML = 'update!';
			//e.target.className = 'btn btn-success';
		});
	};

	//recalculate rating of remaining episodes
	$scope.remainingRating = function (show) {
		//var arr = show.object.ratingsArray;

		
		/*show.total = 0.0;

		for (var i = show.totalEpisodesWatched; i < show.totalEpisodes; i++) {
			show.total += show.ratingsArray[i];
		}



		return (show.total / (show.totalEpisodes - show.totalEpisodesWatched)).toFixed(2);*/
		
		show.remainingRatings = show.ratingsArray.slice(show.totalEpisodesWatched);
		return math.mean(show.remainingRatings).toFixed(2);
	};
	
	//remove show from collection
	$scope.removeFromCollection = function (show, e) {
		show.flagRemove = true;
		
		e.target.innerHTML = 'Removing...';
		
		// remove from database
		$http({
			method: 'post',
			url: app.base_url + 'shows/remove/', // CI route
			data: {
				//showData: $scope.showList
				showData: show
			}
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...
			console.log(response);

			// remove from local array
			//var index = $scope.showList.indexOf(show);
			//$scope.showList.splice(index, 1);
		});
	};
	
	//remove show from collection
	$scope.removeWatching = function (show, e) {
		e.target.innerHTML = 'Removing...';
		
		// remove from database
		$http({
			method: 'post',
			url: app.base_url + 'shows/removeWatching/', // CI route
			data: {
				//showData: $scope.showList
				showData: show
			}
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...
			console.log(response);

			// remove from local watchingList array
			var index = $scope.watchingList.indexOf(show);
			$scope.watchingList.splice(index, 1);
			console.log($scope.watchingList);
			
			// add to local showList array
			$scope.showList.push(show);
			console.log($scope.showList);
			
		});
	};
	
	//delete show completely
	$scope.delete = function (show, e){
		e.target.innerHTML = 'Deleting...';
		
		// remove from database
		$http({
			method: 'post',
			url: app.base_url + 'shows/delete/', // CI route
			data: {
				showData: show
			}
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...
			console.log(response);

			// remove from local array
			var index = $scope.showList.indexOf(show);
			$scope.showList.splice(index, 1);
		});
	};
	
	//sort list alphabetically
	$scope.sortAlpha = function () {

		// get Shows from our database
		$http({
			method: 'get',
			url: app.base_url + 'shows/sortListAlpha/' + $scope.sortAlphaOrder// CI route
		}).then(function (response) {
			console.log(response.data);
			$scope.showList = response.data.showList;
			console.log($scope.showList);

			//$scope.sortAlphaOrder = $scope.sortAlphaOrder === 'ascending' ? 'descending' :  'ascending';
			if($scope.sortAlphaOrder === 'ascending'){
				document.getElementById("sortAlphaDown").style = 'color: #0275d8';
				document.getElementById("sortAlphaUp").style = '';
				$scope.sortAlphaOrder = 'descending';
				
			}else{
				document.getElementById("sortAlphaUp").style = 'color: #0275d8';
				document.getElementById("sortAlphaDown").style = '';
				$scope.sortAlphaOrder = 'ascending';
			}
			
			//reset color of other sorter
			document.getElementById("sortNumDown").style = '';
			document.getElementById("sortNumUp").style = '';
			
		});

	};
	
	//sort list numerically
	$scope.sortNum = function () {

		// get Shows from our database
		$http({
			method: 'get',
			url: app.base_url + 'shows/sortListNum/' + $scope.sortNumOrder// CI route
		}).then(function (response) {
			console.log(response.data);
			$scope.showList = response.data.showList;
			console.log($scope.showList);

			//change order value and change arrow color
			if($scope.sortNumOrder === 'ascending'){
				document.getElementById("sortNumDown").style = 'color: #0275d8';
				document.getElementById("sortNumUp").style = '';
				$scope.sortNumOrder = 'descending';
				
			}else{
				document.getElementById("sortNumUp").style = 'color: #0275d8';
				document.getElementById("sortNumDown").style = '';
				$scope.sortNumOrder = 'ascending';
			}
			
			//reset color of other sorter
			document.getElementById("sortAlphaUp").style = '';
			document.getElementById("sortAlphaDown").style = '';
			
		});

	};
	
	//sort list alphabetically
	$scope.stdDev = function(rating, show){
		//var multiplier = 1;
		//var rating = show.Seasons[show.currentSeason].Episodes[show.currentEpisode].imdbRating;
		
		if(rating === show.episodeRatings){
			//0 deviation
			return 0;
		}else if(rating < show.episodeRatings){
			//negative deviation
			if (rating > show.episodeRatings - show.stats.standardDeviation){
				return -1;
			}else if(rating > show.episodeRatings - (2*show.stats.standardDeviation)){
				return -2;	 
			}else if(rating > show.episodeRatings - (3*show.stats.standardDeviation)){
				return -3;
			}else{
				return 'more than -3';
			}
		}else{
			//positive deviation
			//-0 to make into number
			if (rating < show.episodeRatings - 0 + show.stats.standardDeviation){
				return 1;
			}else if(rating < show.episodeRatings - 0 + (2*show.stats.standardDeviation)){
				return 2;	 
			}else if(rating < show.episodeRatings - 0 + (3*show.stats.standardDeviation)){
				return 3;
			}else{
				return 'more than 3';
			}
		}
		
		
	};
	
});

//register user
app.controller('registerController', function ($scope, $http) {
	$scope.firstName = "";
	$scope.lastName = "";
	$scope.email = "";
	$scope.username = "";
	$scope.password = "";
	$scope.repeat_password = "";

	$scope.registerNewUser = function () {
		
		$http({
			method: 'post',
			url: app.base_url + 'login/registerNewUser', // CI route
			data: {
				firstName: $scope.firstName,
				lastName: $scope.lastName,
				email: $scope.email,
				username: $scope.username,
				password: $scope.password,
				repeat_password: $scope.repeat_password
			} //,
			//user: user->id}//if i know id of user in angluar, I can pass it as a reqest
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...

			document.getElementById("submit").innerHTML = 'registered!';
			document.getElementById("submit").className = 'btn btn-success btn-lg btn-block';
			
			console.log(response);
		});
	};
});

//login user
app.controller('loginController', function ($scope, $http) {

	$scope.user = {};
	$scope.userName = '';
	$scope.password = '';
	
	//post to database
	$scope.attemptLogin = function () {
		//e.target.innerHTML = 'Logging In...';
		//e.target.classname = 'btn btn-primary';

		$http({
			method: 'post',
			url: app.base_url + 'login/attemptLogin', // CI route
			data: {
				requestData: {
					username: $scope.username,
					password: $scope.password
				}
			} //,
			//user: user->id}//if i know id of user in angluar, I can pass it as a reqest
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...

			console.log(response);
			//e.target.innerHTML = 'logged in!';
			//e.target.className = 'btn btn-success';
		});
	};


});

//user profile page
app.controller('userController', function ($scope, $http, $routeParams) {
	//if user is logged in, show profile page
	$scope.user = {};
	$scope.showList = [];
	$scope.watchingList = [];
	$scope.removedList = [];
	$scope.sumMin = 0;
	$scope.nestEgg = '';
	
	
	

	angular.element(document).ready(function () {

		// get Shows from our database
		$http({
			method: 'get',
			url: app.base_url + 'login/getUser/' + $routeParams.username // CI route
			
		}).then(function (response) {
			console.log(response);
			
			$scope.user = response.data;
			console.log($scope.user);

			$scope.getList();
			//console.log($scope.showList);
			
			
		});
	});
	
	$scope.getList = function () {

		return $http({
			method: 'get',
			url: app.base_url + 'shows/listShows/' + $scope.user.id // CI route
				//should pass user id here
		}).then(function (response) {
			console.log(response);
			$scope.showList = response.data.showList;
			$scope.watchingList = response.data.watchingList;
			
			
			$scope.getRemovedList();

			

			console.log($scope.showList);
			console.log($scope.watchingList);
			console.log($scope.removedList);

			
		});
			
			
			
		
		
		

	};

	$scope.getRemovedList = function () {
		$scope.showList.forEach(function (element) {
			if (element.flagRemove) {
				$scope.removedList.push(element);
			}
		});	
		
	};
	
	//delete show completely
	$scope.delete = function (show, e){
		e.target.innerHTML = 'Deleting...';
		
		// remove from database
		$http({
			method: 'post',
			url: app.base_url + 'shows/delete/', // CI route
			data: {
				showData: show
			}
		}).then(function (response) {
			// check response to make sure everything was okay
			// ...
			console.log(response);

			// remove from local array
			var index = $scope.removedList.indexOf(show);
			$scope.removedList.splice(index, 1);
		});
	};
	

	$scope.sumMinutes = function(){
		var minutes = [];
		
		$scope.removedList.forEach(function(show){
			minutes.push((show.totalEpisodes - show.totalEpisodesWatched) * parseFloat(show.Runtime.substring(0, show.Runtime.length - 1)));
		});
		
		$scope.sumMin = math.sum(minutes);
		
		return $scope.sumMin;
	};
	
	$scope.getNestEgg = function(){
		//SOURCE: https://stackoverflow.com/questions/6665997/switch-statement-for-greater-than-less-than
		//if statements are faster than switch
		if ($scope.sumMin < 10000) {
			$scope.nestEgg = '🥚';
		}else if ($scope.sumMin < 100000){
			$scope.nestEgg = '🐣';
		}else if ($scope.sumMin < 1000000){
			$scope.nestEgg = '🐥';
		}else if ($scope.sumMin < 10000000){
			$scope.nestEgg = '🐓';
		}else{
			$scope.nestEgg = '🍗';
		}
		return $scope.nestEgg;
	};
	
	$scope.minutes = function () {

	console.log($scope.sumMin);

	if ($scope.sumMin > 115200) {
		return 'travel around the world in 80 days';
	} else if ($scope.sumMin > 1440) {
		return 'sleep all day';
	}else if ($scope.sumMin > 400) {
		return 'drive to Nashville and sign a record deal';
	}else if ($scope.sumMin > 160) {
		return 'go see the full production of Les Misérables';
	} else if ($scope.sumMin > 60) {
		return 'go see Les Misérables';
	} else if ($scope.sumMin >30) {
		return 'bake cookies';
	} else {
		return 'watch an episode of your favorite TV show';
	}

	};

	});