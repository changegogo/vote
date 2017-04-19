<?php
// 首先判断是否有user cookie
if(isset($_COOKIE["user"])){
 ?>
    <script type="text/javascript">
        window.location.href = "../manage";
    </script>
<?php
    //require_once ("admin.php");
}else{
    require("./header.html");
    require("./login.html");
    require("./footer.html");
}
?>