<?php

use benhall14\phpCalendar\Calendar as Calendar;

// CREATE CALENDAR
$calendar = new Calendar(2025, 1);
$calendar->useMondayStartingDate();

// FETCH BOOKED ROOMS
$dateQuery = "SELECT arrival_date FROM bookings";
$bookedDates = queryFetchAssoc($db, $dateQuery);

// STANDARDIZE THE DATES
$standardizedBookedDates = array_map(
    fn($bookedDate) => calendarDatesToTimeStamp($bookedDate['arrival_date']),
    $bookedDates
);

// FLATTEN THE DATES
$allDates = is_array(reset($standardizedBookedDates))
    ? array_merge(...$standardizedBookedDates)
    : $standardizedBookedDates;

foreach ($allDates as $date) {
    $calendar->addEvent(
        $date,
        $date,
        "Booked",
        true,
        ['booked']
    );
}
