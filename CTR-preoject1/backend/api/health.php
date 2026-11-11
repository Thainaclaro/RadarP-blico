<?php

header("Content-Type: application/json; charset=UTF-8");

echo json_encode([
    "status" => "ok",
    "message" => "API do Radar Público funcionando!"
]);
