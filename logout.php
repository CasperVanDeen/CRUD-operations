<?php
session_start();
session_destroy();
if (session_destroy()){
header("Location:index.php");
exit;
}
?>
<script type="text/javascript">
setTimeout(function(){window.location.href='index.php'}, 0000);
</script>
