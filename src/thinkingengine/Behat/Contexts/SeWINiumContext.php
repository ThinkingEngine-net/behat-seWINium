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

    /* -------------------------------------- Window by title -----------------------------*/

     /**
     * Find a window with title
     * Example: Given I can find a window titled "winname"
     *
     * @Given /^(?:|I )can find a window titled "([^"]*)"$/
     */
    public function iCanFindWindowTitle($title)
    {
        $ret=$this->Driver->apiFindWindowByTitle($title);
        if ($ret===false)
        {
            throw new \Exception("Window with title '".$title."' could not be found. ".$this->Driver->getLastCommand());
        }

       return;
    }

     /**
     * Select (add for later action) a widnow by title
     * Example: Given I can select a window titled "winname"
     *
     * @Given /^(?:|I )can select a window titled "([^"]*)"$/
     */
    public function iCanSelectWindowTitle($title)
    {
        $ret=$this->Driver->apiSelectWindowByTitle($title);
        if ($ret===false)
        {
            throw new \Exception("Window with title '".$title."' could not be selected. ".$this->Driver->getLastCommand());
        }

       return;
    }

    /**
     * Find a window with title (Reg Exp)
     * Example: Then I can find a window titled like "<RegEx>"
     *
     * @Given /^(?:|I )can find a window titled like "([^"]*)"$/
     */
    public function iCanFindWindowTitleLike($title)
    {
        $ret=$this->Driver->apiFindWindowLikeTitle($title);
        if ($ret===false)
        {
            throw new \Exception("Window with title '".$title."' could not be selected. ".$this->Driver->getLastCommand());
        }

       return;
    }

    /**
     * Select (add for later action) a window with title (Reg Exp)
     * Example: Then I can select a window titled like "<RegEx>"
     *
     * @Given /^(?:|I )can select a window titled like "([^"]*)"$/
     */
    public function iCanSelectWindowTitleLike($title)
    {
        $ret=$this->Driver->apiSelectWindowLikeTitle($title);
        if ($ret===false)
        {
            throw new \Exception("Window with title '".$title."' could not be selected. ".$this->Driver->getLastCommand());
        }

       return;
    }

 /* -------------------------------------- Window by class -----------------------------*/

     /**
     * Find a window with class
     * Example: Given I can find a window with the class "class"
     *
     * @Given /^(?:|I )can find a window with the class "([^"]*)"$/
     */
    public function iCanFindWindowClass($title)
    {
        $ret=$this->Driver->apiFindWindowByClass($title);
        if ($ret===false)
        {
            throw new \Exception("Window with class '".$title."' could not be found. ".$this->Driver->getLastCommand());
        }

       return;
    }

     /**
     * Select (add for later action) a windows with the class
     * Example: Given I can select a windows with the class "class"
     *
     * @Given /^(?:|I )can select a window with the class "([^"]*)"$/
     */
    public function iCanSelectWindowClass($title)
    {
        $ret=$this->Driver->apiSelectWindowByClass($title);
        if ($ret===false)
        {
            throw new \Exception("Window with class '".$title."' could not be selected. ".$this->Driver->getLastCommand());
        }

       return;
    }

    /**
     * Find a window with class (Reg Exp)
     * Example: Then I can find a window with a class like "<RegEx>"
     *
     * @Given /^(?:|I )can find a window with a class like "([^"]*)"$/
     */
    public function iCanFindWindowClassLike($title)
    {
        $ret=$this->Driver->apiFindWindowLikeClass($title);
        if ($ret===false)
        {
            throw new \Exception("Window with class '".$title."' could not be selected. ".$this->Driver->getLastCommand());
        }

       return;
    }

    /**
     * Select (add for later action) a window with class (Reg Exp)
     * Example: Then I can select a window with a class like "<RegEx>"
     *
     * @Given /^(?:|I )can select a window with a class like "([^"]*)"$/
     */
    public function iCanSelectWindowClassLike($title)
    {
        $ret=$this->Driver->apiSelectWindowLikeClass($title);
        if ($ret===false)
        {
            throw new \Exception("Window with class '".$title."' could not be selected. ".$this->Driver->getLastCommand());
        }

       return;
    }

/* -------------------------------------- Active Window -----------------------------*/

     /**
     * Find active window
     * Example: Given I can find an active window
     *
     * @Given /^(?:|I )can find an active window$/
     */
    public function iCanFindActiveWindow()
    {
        $ret=$this->Driver->apiFindWindowActive();
        if ($ret===false)
        {
            throw new \Exception("Active window could not be found. ".$this->Driver->getLastCommand());
        }

       return;
    }

    /**
     * Select (add for later action)  active window
     * Example: Given I can select the active window
     *
     * @Given /^(?:|I )can select the active window$/
     */
    public function iCanSelectActiveWindow()
    {
        $ret=$this->Driver->apiSelectWindowActive();
        if ($ret===false)
        {
            throw new \Exception("Active window could not be selected. ".$this->Driver->getLastCommand());
        }

       return;
    }
    

/********************************************************************************************
********************************************************************************************/


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
