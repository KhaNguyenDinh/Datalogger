<div class="display:none">
<?php 
function Get($time){
	$currentDateTime = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
	$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

	$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
	$date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));

	$interval = $date1->diff($date2);
	// echo $interval->format('%R%a ngày %H giờ %i phút %S giây');
	$thongbao = '';
	if ($interval->y > 0) {
	    $thongbao = $interval->format('%R%y năm %m tháng %d ngày %H giờ %i phút %S giây');
	} elseif($interval->m > 0) {
	    $thongbao = $interval->format('%R%m tháng %a ngày %H giờ %i phút %S giây');
	} elseif($interval->d > 0) {
	    $thongbao = $interval->format('%R%a ngày %h giờ %i phút %S giây');
	} elseif($interval->h > 0) {
	    // $thongbao = $interval->format('%R%H giờ %i phút %S giây');
	} elseif($interval->i > 30) {
	    // $thongbao = $interval->format('%R%i phút %S giây');
	}

	return $thongbao;
}?>
</div>