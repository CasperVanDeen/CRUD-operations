<?php
session_start();
session_destroy();
if (session_destroy()){
exit;
}
?>
<script type="text/javascript">
setTimeout(function(){window.location.href='index.php'}, 0000);
</script>
