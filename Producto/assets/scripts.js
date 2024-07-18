$(document).ready(function() {
    $("#someForm").submit(function(event) {
        event.preventDefault();
        $.post("server.php", $(this).serialize(), function(data) {
            $("#responseDiv").html(data);
        });
    });
});
