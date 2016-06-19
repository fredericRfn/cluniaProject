<script>
    $(function() {
      $("#navbar-collapse-target > ul.nav.navbar-nav.items").append("<li><a href='user.php'>Mi perfil</a></li>");
      $("#navbar-collapse-target > ul.nav.navbar-nav.items").append("<li><a href='logout.php'>Desconectarse</a></li>");
      $("body > nav > div > div.navbar-header > a.navbar-brand").empty().text("Clunia Viewer - !Bienvenido!")
    });
</script>


<div class="container" style="padding-left:0px; padding-right:0px; padding-top: 50px;">
		<div class="col-md-3" id="properties">
		    <h1> Properties </h1>
		</div>
		<div class="col-md-9" id="dashboard"> 
            <div class="row" id="title">Título</div>
            <div class="row" id="description">Una pequeña descripción de tu dashboard</div>  
            <div class="row" id="row1">        
		        <div class="col-md-6 graph">
                    <div class="graphbox">
                        <div class="row title">Título</div>
                        <div class="row description">Una pequeña descripción</div>
                        <div class="row chart">La grafica en si y su leyenda</div> 
                    </div>
                </div>
		        <div class="col-md-6 graph">
                    <div class="graphbox">
                        <div class="row title">Título</div>
                        <div class="row description">Una pequeña descripción</div>
                        <div class="row chart">La grafica en si y su leyenda</div> 
                    </div>
                </div>
            </div>
            <div class="row" id="row2">        
		        <div class="col-md-4 graph">
                    <div class="graphbox">
                        <div class="row title">Título</div>
                        <div class="row description">Una pequeña descripción</div>
                        <div class="row chart">La grafica en si y su leyenda</div> 
                    </div>
                </div>
		        <div class="col-md-4 graph">
                    <div class="graphbox">
                        <div class="row title">Título</div>
                        <div class="row description">Una pequeña descripción</div>
                        <div class="row chart">La grafica en si y su leyenda</div> 
                    </div>
                </div>
                <div class="col-md-4 graph">
                    <div class="graphbox">
                        <div class="row title">Título</div>
                        <div class="row description">Una pequeña descripción</div>
                        <div class="row chart">La grafica en si y su leyenda</div> 
                    </div>
                </div>
            </div>
		</div>
</div>
