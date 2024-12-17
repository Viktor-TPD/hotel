<?php

declare(strict_types=1);
// EXECUTE QUERY
function executeQuery($db, $query)
{
    try {
        $stmt = $db->prepare($query);
        $stmt->execute();
        echo "Query executed successfully.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

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
