<?php
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    $sql = "SELECT * FROM Dataloggers";
    $result = $conn->query($sql);
?>

<div class="row separator">Global Data Grid</div>
<div class="container">
    <div class="row" style="margin-left:auto; margin-right: auto; width:80%">
        <label>Datalogger:</label>
        <select class="form-control" id="datalogger_selector" onchange="switchDatalogger()">
            <?php while($row = $result->fetch_assoc()) : ?>
                <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="row">
        <table id="main-table" class="data table-striped table-bordered table-hover table-sm">

        </table>
    </div>
</div>

<script>
    function switchDatalogger() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../admin/all.php",
            data : 'd=' + $("#datalogger_selector").val(),
            success: function(json) {
                $("table").empty();
                addHeader(json);
                addContent(json);
            }
        });
    }
    function addHeader(json) {
        $("table").append("<thead><tr>");
        $("table").append("<th>Measured At</th>");
        jQuery.each(json["sensors"], function(i, val) {
            $("table").append("<th>"+ val + "</th>");
        });
        $("table").append("</tr></thead>");
    }
    function addContent(json) {
        $("table").append("<tbody>");
        jQuery.each(json["data"], function(i, val) {
            var line="";
            line="<tr><td>"+ i + "</td>";
            jQuery.each(val, function(i, d) {
                line=line+"<td>"+ d + "</td>";
            });
            line=line+"</tr>";
            $("table").append(line);
        });
        $("table").append("</tbody>");
    }
    switchDatalogger();
</script>