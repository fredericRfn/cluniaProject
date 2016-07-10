$(function() {
    $(".clickable_cell").click(turnIntoForm);
})

function turnIntoForm() {
    $(this).off('click');
    var id = $(this).attr('id');
    var oldValue = $(this).text();
    $(this).empty().append("<input style='width: 100%' id='editform' type='text' value='"+oldValue+"'>");
    $("#editform").focus();
    $("#editform").focusout({item: $(this), old: oldValue, id: id}, turnBackAndSave);
}

function turnBackAndSave(event) {
    var v = $("#editform").val();
    var table = $(".table-text").text();
    var tokens = event.data.id.split(",");
    var idrecord = tokens[0];
    var field = tokens[1];

    if (v.toString()!=event.data.old.toString()) {
        var r = confirm("In table:" + table + ", the field '" + field + " will be updated to " + v
            + " for the id " + idrecord + ". Do you want to proceed?");
        $(this).remove();
        if (r == true) {
            event.data.item.text(v.toString());
            $.ajax({
                type: "POST",
                dataType: "text",
                url: "../data/update.php",
                data: 'table=' + table + '&column=' + field + '&id=' + idrecord + '&value=' + v,
                success: function (msg) {
                    location.reload();
                }
            });
        } else {
            event.data.item.text(event.data.old.toString());
        }
    } else {
        $(this).remove();
        event.data.item.text(event.data.old.toString());
    }
    event.data.item.click(turnIntoForm);
}