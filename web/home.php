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
                    <button class="btn btn-block btn-default" id="add_dashboard" onclick="newDashboard()">Añadir</button>
                </div>
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default" id="save_dashboard" onclick="exportToDatabase()">Guardar</button>
                </div>
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default" id="remove_dashboard" onclick="removeFromDatabase()">Eliminar</button> 
                </div>
            </div>
            <div class="row">
                <label>Ver el dashboard: </label><select class="form-control" id="dashboard_selector" onchange="switchDashboardFromSelector()"></select>  
            </div>
            <div class="row">
                <label><input type ="checkbox" name="role" value="1" id='#dashboard_is_default' oninput="refreshDashboardParam('is_default', '#dashboard_is_default')">Dashboard por defecto</label>  
            </div>
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Titulo</label>
                    <label>Descripción</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="text" class ="form-control" name="title" id="dashboard_title" oninput="refreshDashboardTitle()">
                    <input type ="text" class ="form-control" name="description" id="dashboard_description" oninput="refreshDashboardParam('description','#dashboard_description')">
                </div>
            </div>	    
            <div class="row separator">
                <label> Gráfica </label>  
            </div>
            <div class="row" id="graphics-bar">
                <button class="btn btn-default" id="add_chart" onclick="add_chart()">Añadir gráfica</button>
                <button class="btn btn-default" id="remove_chart" onclick="remove_chart()">Eliminar esta gráfica</button>  
            </div>
            <div class="row">
                <label>Gráficas del dashboard:</label><select class="form-control" id="chart_selector" onchange="switchChartFromSelector()"></select>  
            </div>
            <div class="row bordered"></div> 
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Titulo</label>
                    <label>Descripción</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="text" class ="form-control" id="chart_title" oninput="refreshChartTitle()">
                    <input type ="text" class ="form-control" id="chart_description" oninput="refreshChartParam('description', '#chart_description')">
                </div>
            </div> 
            <div class="row">
                <div class="col-md-4 inlined">
                     <label>Tipo</label>
                </div>
                <div class="col-md-8 inlined">
                     <select class="form-control" id="chartType_selector" onchange="setChartType()"></select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 inlined">
                    <label>Fila</label>
                    <label>Anchura</label>
                </div>
                <div class="col-md-3 inlined">
                    <input type ="number" class ="form-control" id="chart_row" oninput="refreshChartParam('row', '#chart_row')">
                    <input type ="number" class ="form-control" id="chart_width" oninput="refreshChartParam('width', '#chart_width')">
                </div>
                <div class="col-md-3 inlined">
                    <label>Columna</label>
                    <label>Altura</label>
                </div>
                <div class="col-md-3 inlined">
                    <input type ="number" class ="form-control" id="chart_column" oninput="refreshChartParam('column', '#chart_column')">
                    <input type ="number" class ="form-control" id="chart_height" oninput="refreshChartParam('height', '#chart_height')">
                </div>
            </div>
            <div class="row bordered"></div> 
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Desde</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="date" class ="form-control" id="chart_from" oninput="refreshChartFrom()">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Hasta</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="date" class ="form-control" id="chart_to" oninput="refreshChartTo()">
                </div>
            </div> 
           <div class="row">
                <label>Sensor del cual imprimir datos:</label><select class="form-control" id="sensor_selector" onchange="setChartSensor()"></select>
           </div>
		</div>
		<div class="col-md-9" id="dashboard"> 
		</div>
    </div>
</div>
