<?php

    try {
        
        $conn = new PDO("sqlite:db.sqlite");
        // $conn->exec("INSERT INTO students (`name`, school, manage, `number`, spz, `status`, `totalnumber`,per, `fail`) VALUES ('kareem', 'meet gazal', 'jdfa', 555, 'dfs', 1,364,94.5, 5)");
    
    } catch (PDOException $e) {
        
        echo $e->getmessage();
    
    }