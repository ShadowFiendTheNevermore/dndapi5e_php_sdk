<?php

use ShadowFiend\DndApi;

require __DIR__ . '/vendor/autoload.php';

$dnd = new DndApi();

// We need normal tests
$fakegnome = $dnd->races->entity('dwarf')->data();

var_dump($fakegnome);