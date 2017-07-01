<?php namespace thinkingengine\Behat\Contexts;

use \Behat\Behat\Context\TranslatableContext;
use \Behat\Gherkin\Node\TableNode;
use \Behat\Behat\Context\Context;


/**
 * Logic-Worx seWINium context for Behat BDD tool.
 * Builds on Behat Context Capabilities.
 *
 * @author Mark Marshall
 */

class SeWINiumContext extends RawSeWINiumContext implements TranslatableContext
{
    public function __construct()
    {
        $this->LoadConfig();
    }
    /**
     * Confirms this library is in use - i.e. No exception if it exists
     * Example: Given I am using the seWINium
     *
     * @Given /^(?:|I )am using seWINium$/
     */
    public function iAmUsingExtension()
    {
       return;
    }


     /**
     * Confirms the seWINium key is available - i.e. No exception if it is configured
     * Example: Given I have a seWINium key
     *
     * @Given /^(?:|I )have a seWINium key$/
     */
    public function iHaveAPIKey()
    {
       if ($this->key=="")
       {
        throw new \Exception("There is no server seWINium key configured :: '".$this->cfgFile."' -> ".$this->cfgJson);
       }
       return;
    }

    /**
     * Confirms the seWINium is available - i.e. No exception if it is contactable
     * Example: Given I can contact seWINium
     *
     * @Given /^(?:|I )can contact seWINium$/
     */
    public function icanaccessSeWINium()
    {
       $this->CallseWINium("about","");   
       return;
    }

     /**
     * Window Exists
     * Example: Given I can find a window titled "winname"
     *
     * @Given /^(?:|I )can find a window titled "([^"]*)"$/
     */
    public function iCanFindWindowTitle($title)
    {
       $cmd="window/find";
       $params="title=".urlencode($title);
       $data = $this->CallseWINium($cmd,$params);

       if (isset($data->{"status"}))
       {
            if($data->{"status"}==="OK")
            {
                return;
            }
            else
            {
                throw new \Exception("Window with title '".$title."' could not be found. Called '".$cmd."' with '".$params."'.");
            }
       }
       else
       {
        var_dump($data);
        throw new \Exception("Response from seWINium not understood. Called '".$cmd."' with '".$params."'.");
        
       }

       return;
    }


    

//*******************************************************************************************
//*******************************************************************************************
//*******************************************************************************************    
//*******************************************************************************************

    /***
        Send command to server
    ***/

    public  function CallseWINium($cmd, $params, $timeoutSeconds=5)
    {
        // -  Build URL
        $uri="http://127.0.0.1:".$this->port."/".$cmd."?key=".$this->key;

        if ($params!=="")
        {
            $uri=$uri."&".$params;
        }

        // - Setup configuraiton

        $opts = array('http' =>
              array(
                'method'  => 'GET',
                'header'  => "Content-Type: text/html\r\n",
                'content' => "",
                'timeout' => $timeoutSeconds
              )
            );
                        
        
        $context  = stream_context_create($opts);

        // -  Call webserver
        $json= file_get_contents($uri,false,$context);
        
        // - response not valid - Server not repsponding
        if ($json===false)
        {
           throw new \Exception("Cannot find seWINium Web Server. ".$uri); 
        }

        // - Return decode JSON

        $dat= json_decode($json);

        return $dat;

    }

     /**
     * Returns list of definition translation resources paths
     *
     * @return array
     */
    public static function getTranslationResources()
    {
        return self::getSewiniumTranslationResources();
    }

    /**
     * Returns list of definition translation resources paths for this dictionary
     *
     * @return array
     */
    public static function getSewiniumTranslationResources()
    {
        return glob(__DIR__.'/../../../../locale/*.xliff');
    }
    
}
