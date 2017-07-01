<?php

namespace thinkingengine\Behat\Contexts;

/**
 * Raw seWINium context for Behat BDD tool.
 * Provides raw seWINium integration (without step definitions) and web assertions.
 *
 * @author Mark Marshall
 */
class RawSeWINiumContext implements seWINiumAwareContext
{
   public $key="";
   public $cfgJson="{}";
   public $cfgFile="";
   public $port = 8777;
   public function LoadConfig()
   {

    
    //Read Config file.

    $configFile=__DIR__."/../../../../../../../sewinium.json";
    $this->cfgFile=$configFile;


    $fHandle = fopen($configFile, "r");

    if($fHandle===false)
    {
        throw \Exception("Cannot find seWINium config file!");
    }

    $this->cfgJson = fread($fHandle,filesize($configFile));

    fclose($fHandle);

    //Import JSON
    $cfg= json_decode($this->cfgJson);

    //Set Config

    if (isset($cfg->{'key'}))
    {
        $this->key="".$cfg->{'key'}; // convert to string and set
    }

    if (isset($cfg->{'port'}))
    {
        $this->port=intval($cfg->{'port'}); // convert to int and set
    }

   }
}
