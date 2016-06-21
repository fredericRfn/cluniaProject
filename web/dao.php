<?php
    class Chart {
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
        function Chart($sqlRow) {
            $this->title=$sqlRow['title'];
            $this->description=$sqlRow['description'];
            $this->type=$sqlRow['type'];
            $this->row=$sqlRow['row_num'];
            $this->column=$sqlRow['column_num'];
            $this->height=$sqlRow['height'];
            $this->width=$sqlRow['width'];
            $this->from=$sqlRow['data_from'];
            $this->to=$sqlRow['data_to'];
            $this->sensor_id=$sqlRow['sensor_id'];
        }
    }
    class Dashboard {
        var $title;
        var $description;
        var $number;
        var $user_id;
        var $is_default;
        var $charts = array();
        function Dashboard($sqlRow, $chartsSqlRow) {
            $this->title=$sqlRow['title'];
            $this->description=$sqlRow['description'];
            $this->number=$sqlRow['display_order'];
            $this->user_id=$sqlRow['user_id'];
            $this->is_default=$sqlRow['is_default'];

            for ($i = 0; $i < count($chartsSqlRow) ; $i++) {
                $tmp=new Chart($chartsSqlRow[$i]);
                array_push($this->charts, $tmp);
            }
        }
    }
?>
