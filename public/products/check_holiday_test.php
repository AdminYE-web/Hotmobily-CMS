<?php
// include("/products/connect_db/Control_Connect.php");
require_once __DIR__ . "/../connect_db/Control_Connect.php";
date_default_timezone_set("Asia/Tokyo");
$date_s = array();
function CheckPublicHoliday($strChkDate, $conn)
{
  $strSQL = "SELECT * FROM `holiday_calendarHM` where date_h = '" . $strChkDate . "' ";
  $objQuery = mysqli_query($conn, $strSQL);
  $objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

  mysqli_free_result($objQuery);

  if (!$objResult) {
    return false;
  } else {
    return $objResult;
  }
}

$data = "SELECT * FROM `product_strap` where `prd_name_jp`='" . $_POST['product'] . "'";
$result = mysqli_query($conn, $data) or die(mysqli_error());
if (mysqli_num_rows($result)) {
  while ($info = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $day = $info['date_made'];
  }
}
$h = date('G');
if ($h >= 12) {
  $days_one =  date('Y-m-d', strtotime("+1 days"));
  $strStartDate = date('Y-m-d', strtotime("+1 days"));
} else {
  $days_one =  date('Y-m-d');
  $strStartDate = date('Y-m-d');
}

$strEndDate = date('Y-m-d');

$strEndDate = '';
$intWorkDay = 0;
$intHoliday = 0;

$able_to_ship = true;

while ($intWorkDay < $day) {
  $DayOfWeek = date("w", strtotime($strStartDate));
  if ($DayOfWeek == 0) { // Sunday
    $intHoliday++;
  } elseif (CheckPublicHoliday($strStartDate, $conn)['type'] == 3) {
    $intHoliday++;
  } elseif (CheckPublicHoliday($strStartDate, $conn)['type'] == 2 || $DayOfWeek == 6) {
    $intWorkDay++;
    if ($DayOfWeek == 6 && $intWorkDay == $day) {
      $strStartDate = date("Y-m-d", strtotime("+2 day", strtotime($strStartDate)));
    }
  } else {
    $intWorkDay++;
  }

  while (
    $intWorkDay >= $day &&
    ($DayOfWeek == 6 || $DayOfWeek == 0 || CheckPublicHoliday($strStartDate, $conn)['type'] == 2 || CheckPublicHoliday($strStartDate, $conn)['type'] == 3)
  ) {
    $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
    $DayOfWeek = date("w", strtotime($strStartDate));
  }

  $strEndDate = $strStartDate;
  $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
}

array_push($date_s, $days_one, $strEndDate);

echo json_encode($date_s);
