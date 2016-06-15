<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $cached_events;
$cached_events = array();

// Populates an array with the EVENTS ids
$query = "SELECT * FROM qevent ORDER BY event_id";
$res = consulta_db($query, 0, 0);
while ($row = db_fetch_row($res)) {
    $cached_events[$row[1]] = $row[0];
}

function get_event_id($eventName) {
    $eventName = strtoupper($eventName);
    global $cached_events;
    if (key_exists($eventName, $cached_events)) {
        return $cached_events[$eventName];
    }
    $newId = max(array_values($cached_events)) + 1;
    $sql = 'INSERT INTO qstatslite.qevent(event_id,event) VALUES (' . $newId . ',\'' . $eventName . '\');';
    $res = consulta_db($sql, 0, 0, 1);
    $cached_events[$eventName] = $newId;
    return $newId;
}
