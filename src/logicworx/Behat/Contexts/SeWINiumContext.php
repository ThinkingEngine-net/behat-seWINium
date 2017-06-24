<?php namespace logicworx\Behat\Contexts;

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
