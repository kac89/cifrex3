<?php
//  
//    cIFrex Tool for Static Code Analysis
//    Copyright (C) 2015 cIFrex Team
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see http://www.gnu.org/licenses/.
//

include './config.php';
include './include/general/db.php';

$handleIt = (isset($_GET['action'])) ? $_GET['action'] : 'index';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

if(isset($_GET['langId']) AND is_numeric($_GET['langId'])){
    $langIds = intval($_GET['langId']); 
    
    $dbLink->sql("SELECT * FROM `cifrex_languages` WHERE lang_id= '".$langIds."'");

    if($dbLink->numOfRows()!=1){
        die("ERROR: No exists!");
    }
    $langdetail=$dbLink->getResults();
    $langdetail=$langdetail[0];
}
else
{
    die("ERROR: No lang!");   
}
    
$dbLink->sql("SELECT * FROM `cifrex_relation_lang_fil` WHERE lang_id= '".$langIds."'");

$results=$dbLink->getResults();

include './include/general/navbar.php';

$filtry=array();
for($index=0; $index<count($results); $index++){
    $filtry[]=$results[$index]['filtr_id'];
}

// HTML START up to navBar
echo startHtmlUpToNavBar("languages");
?>

    <div class="container">
            
             <center>
             <accordion close-others="langSele">
                <accordion-group is-open="true">
                    <accordion-heading>
                        <center><B>Manage filters for :</b> <?php echo htmlspecialchars($langdetail['name']); ?></center>
                    </accordion-heading>
        
    <div class="btn-group" dropdown is-open="status.isopen">

       <center>
        <input type='hidden' id='langId' value="<?php echo intval($langIds); ?>">
        <h2>Name: <b><?php echo htmlspecialchars($langdetail['name']); ?></b><BR>Files: <b><?php echo htmlspecialchars($langdetail['files']); ?></b><BR>Description: <b><small><?php echo htmlspecialchars($langdetail['description']); ?></small></B></h2>
        <input id='filesVal' value='{{ selected_lang.files }}' type='hidden'>
            </BR>
    
            <A href="./languages.php" class="btn btn-primary" id="deletelang"><B>Back</B></A>
                <button id="save_langs" class="btn btn-danger" name="trythispatterns" data-loading-text="Loading..."><FONT COLOR=white><B>Save</B></font> </button> <select id="select" multiple="multiple">
<?php
    $stack1 = array();
    $stack2 = array();
    
    $json = file_get_contents($url_config."filters/read.php");
    $obj = json_decode($json,TRUE);

        foreach($obj as $key => $item){
            array_push($stack1, $obj[$key]['env']);
            array_push($stack2, array($obj[$key]['id'], $obj[$key]['title'], $obj[$key]['env'], $obj[$key]['cwe']));
        }
				$stack1 = array_unique($stack1);

				foreach ($stack1 as $value) {
                    
                    echo "<optgroup label=\"".(!empty($value) ? htmlspecialchars($value) : '???ERROR???')."\">";
                            foreach ($stack2 as $valuek) {
                            if($value == $valuek[2]){
                            echo '<option value="'.htmlspecialchars($valuek[0]).'"';
                            if(in_array($valuek[0],$filtry))
                                echo " selected";
                            echo '>'.htmlspecialchars($valuek[3]).' '.htmlspecialchars($valuek[1]).'</option>';
                            }
                            }
                }

                unset($stack1);
				unset($stack2);
                      
?>
    </select>
            <button id="show_selected" class="btn btn-success" name="trythispatterns" data-loading-text="Loading..." type="button"><FONT COLOR=white><B>Show selected</B></font> </button>
    </div>
            
            </div>
                </CENTER>
                 </accordion-group>
            </accordion>

      </div>            
    <div id="tabeladiv">
        <a href="#" class="back-to-top">Back to Top</a>
    </div>
        <center>
            <div id="multisearch"></div>
        </center>
    </BODY>
</html>