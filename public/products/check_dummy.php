<?php
date_default_timezone_set("Asia/Tokyo");
function CheckPublicHoliday($strChkDate, $conn) {
    $hols = ["2026-04-29","2026-05-03","2026-05-04","2026-05-05","2026-05-06"];
    if (in_array($strChkDate, $hols)) return ["type" => 3];
    return false;
}

function calc($day) {
    $date_s = array();
    $days_one = "2026-04-22";
    $strStartDate = "2026-04-22";
    $intWorkDay = 0;
    while ($intWorkDay < $day) {
        $DayOfWeek = date("w", strtotime($strStartDate));
        if ($DayOfWeek == 0) { 
        } elseif (CheckPublicHoliday($strStartDate, null)["type"] == 3) {
        } elseif (CheckPublicHoliday($strStartDate, null)["type"] == 2 || $DayOfWeek == 6) {
            $intWorkDay++;
            if ($DayOfWeek == 6 && $intWorkDay == $day) {
                $strStartDate = date("Y-m-d", strtotime("+2 day", strtotime($strStartDate)));
            }
        } else {
            $intWorkDay++;
        }

        while ($intWorkDay >= $day && ($DayOfWeek == 6 || $DayOfWeek == 0 || CheckPublicHoliday($strStartDate, null)["type"] == 2 || CheckPublicHoliday($strStartDate, null)["type"] == 3)) {
            $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
            $DayOfWeek = date("w", strtotime($strStartDate));
        }

        $strEndDate = $strStartDate;
        $strStartDate = date("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
    }
    return $strEndDate;
}

echo "10: " . calc(10) . "\n";
echo "11: " . calc(11) . "\n";
echo "12: " . calc(12) . "\n";
?>
