<?php
namespace App\Helpers;

use App\Helpers\TimeStringFormatHelpers;

class TimeHelper{
    public function getRegularHours($totalTime, $maxHrsBeforeOT = 8){// FUTURE get from systemsettings.maxHrsBeforeOT use default 8
        
        // convert time format string to array split by ':'
        $totalTimeArr = explode(':', $totalTime);
        
        // convert number string to int
        $seconds = intval($totalTimeArr[2]);
        $mins = intval($totalTimeArr[1]);
        $hours = intval($totalTimeArr[0]);
                 
        if($hours >= $maxHrsBeforeOT && $mins >= 0 && $seconds >= 0 )
            return ts_pad($maxHrsBeforeOT).':00:00';                    
        else if($hours < $maxHrsBeforeOT)
            return $totalTime;
        
        return $totalTime;
    }
    public function getOverTimeHours($totalTime, $maxHrsBeforeOT = 8){ // FUTURE get from systemsettings.maxHrsBeforeOT use default 8
        
        // convert time format string to array split by ':'
        $totalTimeArr = explode(':', $totalTime);
        // convert number string to int
        $seconds = intval($totalTimeArr[2]);
        $mins = intval($totalTimeArr[1]);
        $hours = intval($totalTimeArr[0]);

        
        if($hours > $maxHrsBeforeOT)
            return ts_pad($hours - $maxHrsBeforeOT).':'.ts_pad($mins).':'.ts_pad($seconds);
        else if($hours == $maxHrsBeforeOT && $mins > 0)
            return '00:'.ts_pad($mins).':'.ts_pad($seconds);
        else if($hours == $maxHrsBeforeOT && $mins == 0 && $seconds > 0)
            return '00:00:'.ts_pad($seconds);

        return '00:00:00';
    }
    public function sumHours($time1, $time2){
        // create arrays from the time formatted strings, where [0=>hours, 1=>mins, 2=>seconds]; or eg. from "03:45:23"  to ["03", "45", "23"]
        $time1_arr = explode(':', $time1); 
        $time2_arr = explode(':', $time2);

        $seconds = intval($time1_arr[2]) + intval($time2_arr[2]);
        $mins = $seconds - 60 >= 0 ? 1 : 0; // if seconds is more than or equal to 60 then we set minute to 1
        $seconds = $seconds - 60 >= 0 ? $seconds - 60 : $seconds; // if seconds is more than or equal 60 then we remove 60 and set the result as the seconds
        
        $mins = intval($time1_arr[1]) + intval($time2_arr[1]) + $mins; // add any mins we got from adding the seconds
        $hours = $mins - 60 >= 0 ? 1 : 0; // if mins is more than or equal to 60 then we set hours to 1
        $mins = $mins - 60 >= 0 ? $mins - 60 : $mins; // we remove any excess mins same as we did with the seconds

        $hours = intval($time1_arr[0]) + intval($time2_arr[0]) + $hours; // add any hours we got from adding the minutes

        
        return ts_pad($hours).':'.ts_pad($mins).':'.ts_pad($seconds);
    }
}