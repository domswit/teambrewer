<?php


function getDates($startDate, $endDate)
{
    $return = array($startDate);
    $start = $startDate;
    $i=1;
    if (strtotime($startDate) < strtotime($endDate))
    {
       while (strtotime($start) < strtotime($endDate))
        {
            $start = date('Y-m-d', strtotime($startDate.'+'.$i.' days'));
            $return[] = $start;
            $i++;
        }
    }

    return $return;
}

print_r(getDates( '2010-10-01', '2010-10-05' ));
?>
