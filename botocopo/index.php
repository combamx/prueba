<?php

include "models/BOTOCOPOSEARCHCOPOS.php";
date_default_timezone_set('America/Mexico_City');

$newSearchCopos = new BOTOCOPOSEARCHCOPOS();

$newSearchCopos->start();