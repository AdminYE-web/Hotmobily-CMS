<?php
include("connect_db/Control_Connect.php");
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

if ($_POST['days'] != "") {
  $day = $_POST['days'];
} else {
  $day = 6;
}

$day_express2 = $day + 6;

if (!empty($_POST['format_cal'])) {
  $calc = (int)$_POST['format_cal'];
} else {
  $calc = 12;
}

$h = (int)date('H');
// echo $h;
// echo $calc;
if ($h >= $calc) {
  $days_one =  date('Y-m-d', strtotime("+1 days"));
  $strStartDate = date('Y-m-d', strtotime("+1 days"));
} else {
  $days_one =  date('Y-m-d');
  $strStartDate = date('Y-m-d');
}

$strEndDate = date('Y-m-d');

// Normal production
$intWorkDay = 0;
$intHoliday = 0;
$intPublicHoliday = 0;
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
    ($DayOfWeek == 0 || CheckPublicHoliday($strStartDate, $conn)['type'] == 2 || CheckPublicHoliday($strStartDate, $conn)['type'] == 3)
  ) {
    $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
    $DayOfWeek = date("w", strtotime($strStartDate));
  }

  $strEndDate = $strStartDate;
  $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
}



$intWorkDay = 0;
$intHoliday = 0;
$intPublicHoliday = 0;
$strStartDate = $days_one;
while ($intWorkDay < $day_express2) {
  $DayOfWeek = date("w", strtotime($strStartDate));
  if ($DayOfWeek == 0) { // Sunday
    $intHoliday++;
  } elseif (CheckPublicHoliday($strStartDate, $conn)['type'] == 3) {
    $intHoliday++;
  } elseif (CheckPublicHoliday($strStartDate, $conn)['type'] == 2 || $DayOfWeek == 6) {
    $intWorkDay++;
    if ($DayOfWeek == 6 && $intWorkDay == $day_express2) {
      $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
    }
  } else {
    $intWorkDay++;
  }

  while (
    $intWorkDay >= $day_express2 &&
    ( $DayOfWeek == 0 || CheckPublicHoliday($strStartDate, $conn)['type'] == 2 || CheckPublicHoliday($strStartDate, $conn)['type'] == 3)
  ) {
    $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
    $DayOfWeek = date("w", strtotime($strStartDate));
  }
  $strEndDate2 = $strStartDate;
  $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
}

array_push($date_s, $days_one, $strEndDate, $strEndDate2);

// return date to html file
echo json_encode($date_s);
