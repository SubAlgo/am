<?php
    include './bundle.php';
?>

<div id="content"></div>

 <script type="text/javascript">
    $(document).ready(function() {
        $('#content').load('./frontend/pos.php');
    });
</script>