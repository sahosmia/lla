<?php

namespace App\Models;

use Carbon\Carbon;

class Day {

    protected static $rows = [
        [
            'id' => 1,
            'week_day' => Carbon::SUNDAY,
            'short_name' => 'Sun',
            'name' => 'Sunday'
        ],
        [
            'id' => 2,
            'week_day' => Carbon::MONDAY,
            'short_name' => 'Mon',
            'name' => 'Monday'
        ],
        [
            'id' => 3,
            'week_day' => Carbon::TUESDAY,
            'short_name' => 'Tue',
            'name' => 'Tuesday'
        ],
        [
            'id' => 4,
            'week_day' => Carbon::WEDNESDAY,
            'short_name' => 'Wed',
            'name' => 'Wednesday'
        ],
        [
            'id' => 5,
            'week_day' => Carbon::THURSDAY,
            'short_name' => 'Thu',
            'name' => 'Thursday'
        ],
        [
            'id' => 6,
            'week_day' => Carbon::FRIDAY,
            'short_name' => 'Fri',
            'name' => 'Friday'
        ],
        [
            'id' => 7,
            'week_day' => Carbon::SATURDAY,
            'short_name' => 'Sat',
            'name' => 'Saturday'
        ]
    ];

    public static function get($startDay = Carbon::SUNDAY) {
        $startPosition = array_search($startDay, array_column(self::$rows, 'week_day'));
        return  array_merge(
            array_slice(self::$rows, $startPosition),
            array_slice(self::$rows, 0, $startPosition)
        );
    }
}
