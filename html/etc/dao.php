<?php
    class Chart {
        //var $id;
        var $title;
        var $description;
        var $type;
        var $row;
        var $column;
        var $height;
        var $width;
        var $from;
        var $to;
        var $sensor_id;
        var $accuracy;
        var $color;
        function Chart($sqlRow) {
            //$this->id=$sqlRow['id'];
            $this->title=utf8_encode($sqlRow['title']);
            $this->description=utf8_encode($sqlRow['description']);
            $this->type=$sqlRow['type'];
            $this->row=$sqlRow['row_num'];
            $this->column=$sqlRow['column_num'];
            $this->height=$sqlRow['height'];
            $this->width=$sqlRow['width'];
            $this->from=$sqlRow['data_from'];
            $this->to=$sqlRow['data_to'];
            $this->sensor_id=$sqlRow['sensor_id'];
            $this->accuracy=$sqlRow['accuracy'];
            $this->color=$sqlRow['color'];
        }
    }
    class Dashboard {
        var $id;
        var $title;
        var $description;
        var $number;
        var $user_id;
        var $is_default;
        var $charts = array();
        function Dashboard($sqlRow, $chartsSqlRow) {
            $this->id=$sqlRow['id'];
            $this->title=utf8_encode($sqlRow['title']);
            $this->description=utf8_encode($sqlRow['description']);
            $this->number=$sqlRow['display_order'];
            $this->user_id=$sqlRow['user_id'];
            $this->is_default=$sqlRow['is_default'];

            while($row = $chartsSqlRow->fetch_assoc()) {
                $tmp=new Chart($row);
                array_push($this->charts, $tmp);
            }
        }
    }
    class Sensor {
        var $id;
        var $datalogger_id;
        var $name;
        var $unit;
        var $operation;
        var $detected_at;
        function Sensor($sqlRow) {
            $this->id=$sqlRow['id'];
            $this->datalogger_id=$sqlRow['datalogger_id'];
            $this->name=utf8_encode($sqlRow['name']);
            $this->unit=$sqlRow['unit'];
            $this->operation=$sqlRow['operation'];
            $this->detected_at=$sqlRow['detected_at'];
        }
    }
    class ChartType {
        var $id;
        var $name;
        var $description;
        function ChartType($sqlRow) {
            $this->id=$sqlRow['id'];
            $this->name=utf8_encode($sqlRow['name']);
            $this->description=utf8_encode($sqlRow['description']);
        }
    }
?>
