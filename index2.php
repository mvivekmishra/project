<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);


//instantiate the program object

//Class to load classes it finds the file when the progrm starts to fail for calling a missing class
class Manage {
    public static function autoload($class) {
        //you can put any file name or directory here
        include $class . '.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));

//instantiate the program object
$obj = new main();


class main {

    public function __construct()
    {
        //print_r($_REQUEST);
        //set default page request when no parameters are in URL
        $pageRequest = 'homepage';
        //check if there are parameters
        if(isset($_REQUEST['page'])) {
            //load the type of page the request wants into page request
            $pageRequest = $_REQUEST['page'];
        }
        //instantiate the class that is being requested
         $page = new $pageRequest;


        if($_SERVER['REQUEST_METHOD'] == 'GET') 			{            $page->get();
        } else {
            $page->post();
        }

    }

}

abstract class page {
    protected $html;

    public function __construct()
    {
        $this->html .= '<html>';
        $this->html .= '<link rel="stylesheet" href="styles.css">';
        $this->html .= '<body>';
    }
    public function __destruct()
    {
        $this->html .= '</body></html>';
        print_r($this->html);
    }

    public function get() {
        //echo 'default get message';
    }

    public function post() {
        print_r($_POST);
    }
}

class homepage extends page {

    public function get() {
        
		//print_r(isset($_GET["csv"]));
		if(isset($_GET["csv"])){
		$tmpName = $_GET["csv"];
    	     echo "<html><body><table border='1'>\n\n";

	if(($handle = fopen($tmpName, 'r')) !== FALSE) 
                  {
                        while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) 
                        {
                						echo "<tr>";
                		        foreach ($data as $cell) 
                            {
                				    echo "<td>" . htmlspecialchars($cell) . "</td>";
        										}
       							        echo "</tr>\n";
												}
				          fclose($handle);
		}
exit();
}
        $form = '<form action="index2.php" method="GET" enctype="multipart/form-data">';
        $form .= 'First name:<br>';
        $form .= '<input type="text" name="firstname" value="Vivek">';
        $form .= '<br>';
        $form .= 'Last name:<br>';
        $form .= '<input type="text" name="lastname" value="Mishra">';
	   $form .='<br>';
	   $form .= '<input type="file" name="csv" value="" />';
       $form .= '<input type="submit" value="Submit">';
        $form .= '</form> ';
	$this->html .='homepage';
	$this->html .=$form;

    }

}
class uploadform extends page
{

    public function get()
    {
        $form = '<form action="index2.php?page=uploadform" method="post"
	enctype="multipart/form-data">';
        $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
        $form .= '<input type="submit" value="Upload Image" name="submit">';
        $form .= '</form> ';
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;

    }

    public function post() {
        echo 'test';
        print_r($_FILES);
    }
}



class htmlTable extends page {}

?>
