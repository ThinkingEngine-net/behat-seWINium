<?php namespace thinkingengine\Behat\Contexts;

use \Behat\Behat\Context\TranslatableContext;
use \Behat\Gherkin\Node\TableNode;
use \Behat\Behat\Context\Context;


/**
 * ThinkingEngine.net seWINium context for Behat BDD tool.
 * Builds on Behat Context Capabilities.
 *
 * @author Mark Marshall  - ThinkingEngine.net
 */

class SeWINiumContext extends RawSeWINiumContext implements TranslatableContext
{
    public $Driver; // seWInium Driver

    public function __construct()
    {
        $this->Driver = new seWINiumDriver;
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
       if ($this->Driver->getAPIKey()==="")
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
       $ret=$this->Driver->apiSewiniumVersion(); 
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
        $ret=$this->Driver->apiFindWindowByTitle($title)
        if ($ret===false)
        {
            throw new \Exception("Window with title '".$title."' could not be found. ".$this->Driver->getLastCommand());
        }

       return;
    }


    

//*******************************************************************************************
//*******************************************************************************************
//*******************************************************************************************    
//*******************************************************************************************

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
