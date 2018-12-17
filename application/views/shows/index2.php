<!DOCTYPE html>
<html lang="en" ng-app="investvApp">
<head>

	<!-- Site meta -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<title>{{appName}}</title>
	
	<!--Angular-->
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/angularjs/1.7.2/angular.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.2/angular-route.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angularjs/1.7.2/angular-animate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angularjs/1.7.2/angular-aria.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angularjs/1.7.2/angular-messages.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular_material/1.1.8/angular-material.min.js"></script>-->


	<!-- CSS -->
	<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
	<!--
<div class="col col-xs-1">
        <div class="pull-right">
        	{if $auth->user()}
				<a href="{site_url('logout')}" class="btn btn-default hidden-xs top-menu-button" role="button">
					<span class="glyphicon glyphicon-user"></span> Logout
				</a>
        	{else}
        		<a href="#" class="btn btn-default hidden-xs top-menu-button" role="button" data-toggle="modal" data-target="#login-modal">
					<span class="glyphicon glyphicon-user"></span> Login
				</a>
        	{/if}
			<h1><a class="visible-xs glyphicon glyphicon-menu-hamburger pull-right" data-toggle="collapse" href="#collapsable-nav" aria-expanded="false" aria-controls="collapsable-nav"></a></h1>
        </div>
      </div>
	-->
	
		
    <div class="container">
<div class="row">
	
	<div class="col col-xs-12">
		<div class="pull-right">

			<a href="#!/User/aaraujo1" class="btn btn-default" role="button">
					<span class="glyphicon glyphicon-user"></span> Hello, aaraujo1
				</a>
		



		</div>
	</div>
		</div>
    <div class="row">
        <div class="col col-sm-12 text-center">
			<a href="#" ng-click="clear()">
				<!--<h1 class="heading">{{appName}}</h1>-->
				<img src="https://aaraujo1.bitlampsites.com/php2/InvesTV/images/investv.png" alt="{{appName}}" class="img-responsive logo">
			</a>
		</div>
	</div>
	<div class="row">
        <div class="col col-sm-12 text-center">
			<a href="#!/myShows" ><button class="btn-lg btn-warning">My Shows</button></a>
		</div>
	</div>
  <!--<div class="col col-sm-4">
    <h3>Find TV Shows</h3>
  </div>-->
		
  
<!-- end header -->
	
	
	
	
	<!--<div class="row">
        <div class="col col-sm-3">
			<h1 class="heading">{{appName}}</h1>
		</div>-->
		
	<!--<div class="col col-sm-9">-->
            <div ng-view>

			</div> <!-- end panel -->
    	<!--</div> --><!-- end col-9 -->
   </div> <!-- end row -->	
	

	
<!-- begin footer -->
		</div> <!-- end panel -->
    </div> <!-- end col-9 -->
   </div> <!-- end row -->	
   <div class="row">
	   
     <div class="col text-center">
      	<p> &copy; 2018 André Araujo</p>
     </div>
   </div>
</div>

<!-- JS -->
<!--Angular-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.2/angular.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.2/angular-route.min.js"></script>

<!--Angular Match Media-->
<!-- https://github.com/jacopotarantino/angular-match-media -->
<script type='text/javascript' src='/static/path/to/angular-media-queries/match-media.js'></script>

<!--Angular Charts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="<?= base_url('js/angular-chart.min.js') ?>"></script>

<!--MathJS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/5.4.0/math.min.js"></script>

<script src="<?= base_url('js/investv_app.js') ?>"></script>

<script>
	// needed for ajax requests
	app.base_url = '<?= base_url() ?>';	
</script>

</body>
</html>
