<?php
date_default_timezone_set('Europe/London');
include('../src/jquery.time.php');
?>
<script src="../lib/jquery-1.9.1.min.js"></script>
<script src="../src/jquery.time.js"></script>
<script>
$(function() {
	$.time({
		langFile:'../src/langs/en.json'
	});
})
</script>

<?php
$time=time();
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>


<?php
$time=0;
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime('-1 week');
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-5 weeks");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-3 weeks");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>


<?php
$time=strtotime("-45 weeks");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-13 days");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-2 days");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-12 hours");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-1 day");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-10 minutes");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-2 hours");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>

<?php
$time=strtotime("-1 minute");
echo "<p>Time: ".date('r',$time)." : ".jquery_time($time)."</p>";
?>