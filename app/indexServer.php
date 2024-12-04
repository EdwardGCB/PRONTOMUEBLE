<?php
require ("server/logic/Product.php");
require ("server/logic/Supplier.php");
require ("server/logic/Supplier.php");

$pid = base64_decode($_GET["pid"]);
include($pid);
?>