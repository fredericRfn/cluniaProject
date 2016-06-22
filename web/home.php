<?php
     include("redirect.php");
?>

<script type="text/javascript" src="dashboard_editor.js"></script>

<div class="container" style="padding-left:0px; padding-right:0px; padding-top: 50px;">
    <div class="row base">
		<div class="col-md-3" id="properties">
            <div class="row separator">
                <label> Dashboard </label> 
            </div> 		    
            <div class="row" id="dashboard-bar">
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default" onclick="newDashboard()">Añadir</button>
                </div>
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default" onclick="exportToDatabase()">Guardar</button>
                </div>
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default">Eliminar</button> 
                </div>
            </div>
            <div class="row">
                <label>Ver el dashboard: </label><select class="form-control" id="dashboard_selector"></select>  
            </div>
            <div class="row">
                <label><input type ="checkbox" name="role" value="1">Dashboard por defecto</label>  
            </div>
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Titulo</label>
                    <label>Descripción</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="text" class ="form-control" name="title" id="dashboard_title">
                    <input type ="text" class ="form-control" name="description" id="dashboard_description">
                </div>
            </div>	    
            <div class="row separator">
                <label> Gráfica </label>  
            </div>
            <div class="row" id="graphics-bar">
                <button class="btn btn-default">Añadir gráfica</button>
                <button class="btn btn-default">Eliminar esta gráfica</button>  
            </div>
            <div class="row">
                <label>Gráficas del dashboard:</label><select class="form-control"></select>  
            </div>
            <div class="row bordered"></div> 
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Titulo</label>
                    <label>Descripción</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="text" class ="form-control" name="grtitle">
                    <input type ="text" class ="form-control" name="grdescription">
                </div>
            </div> 
            <div class="row">
                <div class="col-md-4 inlined">
                     <label>Tipo</label>
                </div>
                <div class="col-md-8 inlined">
                     <select class="form-control"></select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 inlined">
                    <label>Fila</label>
                    <label>Anchura</label>
                </div>
                <div class="col-md-3 inlined">
                    <input type ="number" class ="form-control" name="fila">
                    <input type ="number" class ="form-control" name="anchura">
                </div>
                <div class="col-md-3 inlined">
                    <label>Columna</label>
                    <label>Altura</label>
                </div>
                <div class="col-md-3 inlined">
                    <input type ="number" class ="form-control" name="fila">
                    <input type ="number" class ="form-control" name="anchura">
                </div>
            </div>
            <div class="row bordered"></div> 
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Desde</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="number" class ="form-control" name="from">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Hasta</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="number" class ="form-control" name="to">
                </div>
            </div> 
           <div class="row">
                <label>Sensor del cual imprimir datos:</label><select class="form-control"></select>
           </div>
		</div>
		<div class="col-md-9" id="dashboard"> 
		</div>
    </div>
</div>
