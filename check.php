<?php
$autoloader = require "../../../vendor/autoload.php";

$results = $autoloader->findFile("\Cag\Behat\Contexts\CagContext");

print "Found file for class at: $results\r\n\r\n";

Print "Attempting Load....\r\n\r\n";

$autoloader->loadClass("\Behat\Behat\Context\TranslatableContext");
$autoloader->loadClass("\Behat\Gherkin\Node\TableNode");

$autoloader->loadClass("\logicworx\Behat\Contexts\behat-sewinium");

print_r($autoloader);
exit(2);