<?php
function readData($file) {
    return json_decode(file_get_contents($file), true) ?? [];
}

function saveData($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
