<?php
echo '
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <div id="time"></div>
<script>
setInterval(() => $(\'#time\').load(\'time.php\'), 500);
</script>
';
