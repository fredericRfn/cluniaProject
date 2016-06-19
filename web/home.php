<div class="container">
	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
	    <div class="container-fluid">
		<div class="navbar-header">
		    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-target">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
			    <a style="text-align: center;">Bienvenido <?php $_SESSION["username"]?></a>
		    </button>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse-target">
		        <ul class = "nav navbar-nav navbar-right">
		        <li><a href = "about.php">Dashboards</a></li>
		        <li><a href = "help.php">Graficas</a></li>
		        <li><a href = "contact.php">Signout</a></li>
		        </ul>
		</div>
	    </div><!-- /.container -->
	</nav>
    <div class="row">
        <div class="col-md-3" id="col1">
	        <div id="container-properties">
            <h1> Properties </h1>
            <a href = "logout.php">Sign Out</a>

        </div>
	</div>
        <div class="col-md-9" id="col2">         
                    
        </div>
    </div>
</div>
