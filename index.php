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


class main 
{

    public function __construct()
    {
                    $c1 = new Csv();
                    $c2 = new htmltable();
            if (!isset($_GET['filename'])) 
            {
                    $c1->homepage();
            }                   
            else {
                    $c2->csvTable();
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
        stringFunctions::printThis($this->html);
    }

    public function get() {
        echo 'default get message';
    }

    public function post() {
        print_r($_POST);
    }
}


class Csv {
    /* Member functions */

    function homePage() {
        echo 'Homepage<br/><br/><br/>
          <form action="upload.php?upload_csv=1" method="POST" enctype="multipart/form-data">
          <input type="file" name="csv" value="" />
          <input type="submit" name="submit" value="Submit" />
          </form>';
    }

}

Class htmltable{
    
    function csvTable() {
        $file = $_GET['filename'];
        echo "Homepage Upload : $file<br/>type:csv<br/>Temp File : $file<br/>File Uploaded";
        $tmpName = 'uploads/' . $_GET['filename'];
        echo "<html><body><table border='1'>\n\n";
        if (($handle = fopen($tmpName, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                echo "<tr>";
                foreach ($data as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>\n";
            }
            fclose($handle);
            echo "\n</table></body></html>";
        }
    }

}
?>