<?php
require __DIR__ . '/vendor/autoload.php';
$swagger = Swagger\scan([__DIR__ . '/app']);
file_put_contents(__DIR__ . '/storage/docs/api-docs.json', $swagger);
echo 'swagger generated';
