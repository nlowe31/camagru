<?php
?>

<!DOCTYPE html>
<html>
<body>

<div>
  <h2 id="ajax">Not sent.</h2>
  <button type="button" onclick="get()">Send</button>
</div>

</body>

<script>
function get() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 1 && this.status == 200)
            document.getElementById("ajax").innerHTML = "Connected...";
        else if (this.readyState == 2 && this.status == 200)
            document.getElementById("ajax").innerHTML = "Received...";
        else if (this.readyState == 3 && this.status == 200)
            document.getElementById("ajax").innerHTML = "Processing...";
        else if (this.readyState == 4 && this.status == 200)
            document.getElementById("ajax").innerHTML = this.responseText;
    }
    request.open("POST", "ajaxpost.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send("test=yes&why=cuz");
}
</script>

</html>