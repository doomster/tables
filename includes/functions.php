<?php 

function pdoDB($dbh, $sql, $args = NULL) {
    if (!$args)
    {
         return $dbh->query($sql);
    }
    $stmt = $dbh->prepare($sql);
    $stmt->execute($args);
    return $stmt;
}
?>
