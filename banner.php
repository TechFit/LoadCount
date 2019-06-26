<?php

require_once('./classes/Database.php');
require_once('./classes/VisitorHandler.php');
require_once('./classes/VisitorRepository.php');
require_once('./classes/Image.php');

/** @var Database $db */
$db = new Database('127.0.0.1', 'loadcount', 'root', '');

/** @var VisitorRepository $visitorRepository */
$visitorRepository = new VisitorRepository($db);

/** @var VisitorHandler $visitorHandler */
$visitorHandler = new VisitorHandler($visitorRepository);

$visitorHandler->handle();

/** @var Image $image */
$image = new Image();

header("content-type: image/jpeg");

echo $image->getContent();

exit();
