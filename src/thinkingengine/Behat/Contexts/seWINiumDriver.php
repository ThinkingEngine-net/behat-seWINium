<?php namespace thinkingengine\Behat\Contexts;

/**
 * ThinkingEngine.net seWINium context for Behat BDD tool.
 * Builds on Behat Context Capabilities.
 *
 * @author Mark Marshall  - ThinkingEngine.net
 */

class SeWINiumDriver
    {
    private $key=""; // Te API Key used when calling seWINium
    private $cfgJson="{}"; //  The JSON COfig loaded form file
    private $cfgFile=""; // The config file path
    private $port = 8777; //  The port to call seWINium om
    private $lastCommand  = ""; //Debug string for last seWINium command called.
    private $lastWindowHandle = ""; // Stores the window handle of the the last window used/found.
    private $selectedWindowHandle = ""; // Stores the window handle of the the selected window.


    /*----------------------------------------------
        Constructor
    ----------------------------------------------- */
    public function __construct()
    {
        $this->loadConfig();
    }
  

    /*----------------------------------------------
        Set Config from File
    ----------------------------------------------- */
    public function setConfig($key, $port)
    {
        if (isset($key))
        {
            $this->key=$key; // convert to string and set
        }

        if (isset($port))
        {
            $this->port=intval($port); // convert to int and set
        }

        return true;

    }
    
    /*----------------------------------------------
        load Config from File
    ----------------------------------------------- */
    private function loadConfig()
    {
   
        //Read Config file.

        $configFile=__DIR__."/../../../../../../../sewinium.json";
        $this->cfgFile=$configFile;


        $fHandle = fopen($configFile, "r");

        if($fHandle===false)
        {
            throw \Exception("Cannot find seWINium config file (sewinium.json)!");
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

        return true;

    }

    /*----------------------------------------------
       Get the API Key
    ----------------------------------------------- */

    public function getAPIKey()
    {
       if ($this->key=="")
       {
        throw new \Exception("There is no server seWINium key configured :: '".$this->cfgFile."' -> ".$this->cfgJson);
       }
       return $this->key;
    }

    /*----------------------------------------------
       Get the last seWINium command
    ----------------------------------------------- */

    public function getLastCommand()
    {
       return $this->lastCommand;
    }

    /*----------------------------------------------
       Get the last window Handle
    ----------------------------------------------- */

    public function getLastWindowHandle()
    {
       return $this->lastWindowHandle;
    }

    /*----------------------------------------------
       Get the selected window Handle
    ----------------------------------------------- */

    public function getSelectedWindowHandle()
    {
       return $this->selectedWindowHandle;
    }

//*******************************************************************************************
//******************        seWINium Window API Functions               ****************************    
//*******************************************************************************************

     /*----------------------------------------------
       Get the seWINium Version
    ----------------------------------------------- */
    public function apiSewiniumVersion()
    {
        $data=$this->CallseWINium("about","");  
        if (isset($data->{"status"}) && isset($data->{"data"}))
        {
            if($data->{"status"}==="OK")
            {
                return $data->{"data"}->{"version"};
            }
            else
            {
                throw new \Exception("The requst to find out which version of seWINium was available failed. ".$lastCommand);
            }
        }
        else
        {
            var_dump($data);
            throw new \Exception("Response from seWINium not understood. ".$lastCommand);
            
        }

       return;
    }

    /*----------------------------------------------
       Find/Select Window (Raw By Params)
       see https://www.autoitscript.com/autoit3/docs/intro/windowsadvanced.htm
    ----------------------------------------------- */
    public function apiFindWindow($urlParams)
    {
        $cmd="window/find";
        $data = $this->CallseWINium($cmd,$urlParams);

        if (isset($data->{"status"}))
        {
            if($data->{"status"}==="OK")
            {
                $data->{"data"};
                $lastWindowHandle=$data->{"data"}->{"handle"};
            }
            else
            {
                return false;
            }
        }
        else
        {
            var_dump($data);
            throw new \Exception("Response from seWINium not understood. ".$lastCommand);

        }

        return;
    }

    
    /*----------------------------------------------
       Find/Select Window by Title/Class/Postion/Size
       [instance] - 0 = no specific instance / 1->n : Specific window instance
    ----------------------------------------------- */

    /* -------------- Find By Title -------------*/
    public function apiFindWindowByTitle($title, $instance=0)
    {
        $param="title=".urlencode($title);

        if (intval($instance)>0)
        {
            $param="&instance=".intval($instance);
        }

        return $this->apiFindWindow($param);
    }

    /* -------------- Select By Title -------------*/
    public function apiSelectWindowByTitle($title, $instance=0)
    {
        $data = $this->apiFindWindowByTitle($title, $instance);
        if ($data!==false)
        {
            var_dump($data);
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    }

    /* -------------- Find By Class -------------*/
    public function apiFindWindowByClass($class, $instance=0)
    {
        $param="class=".urlencode($class);


        if (intval($instance)>0)
        {
            $param="&instance=".intval($instance);
        }

        return $this->apiFindWindow($param);
    }

    /* -------------- Select By Class -------------*/
    public function apiSelectWindowByClass($class, $instance=0)
    {
        $data = $this->apiFindWindowByClass($class, $instance);
        if ($data!==false)
        {
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    }

    /* -------------- Find By Postion -------------*/
    public function apiFindWindowByXY($x,$y, $instance=0)
    {
        $param="x=".urlencode($x)."&y=".urlencode($x);


        if (intval($instance)>0)
        {
            $param="&instance=".intval($instance);
        }

        return $this->apiFindWindow($param);
    }

    /* -------------- Select By Postion -------------*/
    public function apiSelectWindowByXY($x,$y)
    {
        $data = $this->apiFindWindowByXY($x,$y, $instance);
        if ($data!==false)
        {
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    } 

    /* -------------- Find By Size -------------*/
    public function apiFindWindowBySize($width,$height, $instance=0)
    {
        $param="w=".urlencode($width)."&h=".urlencode($height);


        if (intval($instance)>0)
        {
            $param="&instance=".intval($instance);
        }

        return $this->apiFindWindow($param);
    }

    /* -------------- Select By Size -------------*/
    public function apiSelectWindowBySize($width,$height, $instance=0)
    {
        $data = $this->apiFindWindowByXY($width,$height, $instance);
        if ($data!==false)
        {
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    } 

    /* -------------- Find Like Title (Regex) -------------*/
    /* --- see https://www.autoitscript.com/autoit3/docs/functions/StringRegExp.htm ---*/
    public function apiFindWindowLikeTitle($titleRegex, $instance=0)
    {
        $param="regexptitle=".urlencode($titleRegex);


        if (intval($instance)>0)
        {
            $param="&instance=".intval($instance);
        }

        return $this->apiFindWindow($param);
    }

    /* -------------- Select Like Title (Regex) -------------*/
    /* --- see https://www.autoitscript.com/autoit3/docs/functions/StringRegExp.htm ---*/
    public function apiSelectWindowLikeTitle($titleRegex, $instance=0)
    {
        $data = $this->apiFindWindowLikeTitle($titleRegex, $instance);
        if ($data!==false)
        {
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    }

    /* -------------- Find Like Class (Regex) -------------*/
    /* --- see https://www.autoitscript.com/autoit3/docs/functions/StringRegExp.htm ---*/
    public function apiFindWindowLikeClass($classRegex, $instance=0)
    {
        $param="regexptitle=".urlencode($classRegex);


        if (intval($instance)>0)
        {
            $param="&instance=".intval($instance);
        }

        return $this->apiFindWindow($param);
    }

    /* -------------- Select Like Class (Regex) -------------*/
    /* --- see https://www.autoitscript.com/autoit3/docs/functions/StringRegExp.htm ---*/
    public function apiSelectWindowLikeClass($classRegex, $instance=0)
    {
        $data = $this->apiFindWindowLikeClass($classRegex, $instance);
        if ($data!==false)
        {
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    }

    /* -------------- Find Active Window -------------*/
    public function apiFindWindowActive()
    {
        $param="active=true";

        return $this->apiFindWindow($param);
    }

    /* -------------- Select Like Active -------------*/
    public function apiSelectWindowActive()
    {
        $data = $this->apiFindWindowActive();
        if ($data!==false)
        {
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    }

    /* -------------- Find Last Window -------------*/
    public function apiFindWindowLast()
    {
        $param="handle=".$lastWindowHandle;

        return $this->apiFindWindow($param);
    }

    /* -------------- Select Last Active -------------*/
    public function apiSelectWindowLast()
    {
        $data = $this->apiFindWindowLast();
        if ($data!==false)
        {
            $selectedWindowHandle = $data->{"handle"};
        }

        return $data;
    }

    /* -------------- Find Selected Window -------------*/
    public function apiFindWindowSelected()
    {
        $param="handle=".$selectedWindowHandle;

        return $this->apiFindWindow($param);
    }

    /* -------------- Select Window by handle-------------*/
    public function apiSelectWindowByHandle($handle)
    {
        $param="handle=".$handle;

        return $this->apiFindWindow($param);
    }
 

//*******************************************************************************************
//******************        seWINium Server Management           ****************************    
//*******************************************************************************************

     /*----------------------------------------------
       Call the seWINium Web Service
    ----------------------------------------------- */
 

    public  function CallseWINium($cmd, $params, $timeoutSeconds=5)
    {
        // -  Build URL
        $uri="http://127.0.0.1:".$this->port."/".$cmd."?key=".$this->key;

        $lastCommand="Called '".$cmd."' with '".$params."' [Target:: ".$uri."].";

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
    
}
