<?php

declare(strict_types=1);

// EXECUTE QUERY
function executeQuery($db, $query)
{
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        echo "Query executed successfully.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//EXAMPLE:
// SQL QUERIES
// $queries = [
//QUERIES GOES HERE SEPARATED BY COMMAS
// ];

// EXECUTE
// foreach ($queries as $query) {
//     executeQuery($db, $query);
// }

// FETCH ALL, RETURNS VALUE OF QUERY
function queryFetchAssoc($db, $query)
{
    try {
        $result = $db->prepare($query);
        $result->execute();
        $value = $result->fetchAll(PDO::FETCH_ASSOC);
        return $value;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

function calendarDatesToTimeStamp(string $selectedDates): array
{
    //MAKE DATES INTO ARRAY
    $selectedDates = explode(",", $selectedDates);
    $cleanedDates = [];
    foreach ($selectedDates as $date) {
        // ADD JANUARY'S DATE IN FRONT OF $date, ADD A 0 TO THE START OF SINGLE DIGITS
        $date = $date < 10 ? '2025-01-0' . $date : '2025-01-' . $date;
        $cleanedDates[] = $date;
    }

    return $cleanedDates;
}
