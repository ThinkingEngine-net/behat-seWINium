<?php

namespace logicworx\Behat\Contexts;

/**
 * Raw seWINium context for Behat BDD tool.
 * Provides raw seWINium integration (without step definitions) and web assertions.
 *
 * @author Mark Marshall
 */
class RawSeWINiumContext implements seWINiumAwareContext
{
   public $key="";
   public function __construct()
   {

    
    //Read Config file.

    $configFile="/sewinium.json";

    $fHandle = fopen($configFile, "r") or die("Unable to open file!");
    $json = fread($fHandle,filesize($configFile));

    fclose($fHandle);

    //Import JSON
    $cfg= json_decode($json);

    //Set Config

    if (isset($cfg["key"]))
    {
        $this->key="".$cfg["key"]; // convert to string and set
    }

   }
}
