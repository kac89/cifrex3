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

if(isset($_GET['groupId']) AND is_numeric($_GET['groupId'])){
    $groupIds = intval($_GET['groupId']); 
    
    $dbLink->sql("SELECT * FROM `cifrex_groups` WHERE group_id= '".$groupIds."'");

    if($dbLink->numOfRows()!=1){
        die("ERROR: No exists!");
    }
    $groupdetail=$dbLink->getResults();
    $groupdetail=$groupdetail[0];
}
else
{
    die("ERROR: No group!");   
}
    
$dbLink->sql("SELECT * FROM `cifrex_relation_fil_gro` WHERE group_id= '".$groupIds."'");

$results=$dbLink->getResults();

for($index=0; $index<count($results); $index++){
    $grupy[]=$results[$index]['group_id'];
}

$dbLink->sql("SELECT name as group_name, group_id FROM `cifrex_groups`");

$groupsy=$dbLink->getResults();

$stack1=array();

foreach($groupsy as $key => $item){
            array_push($stack1, $groupsy[$key]['group_name']);
}

include './include/general/navbar.php';

// HTML START up to navBar
echo startHtmlUpToNavBar("groups");
?>

    <div class="container">
            
             <center>
             <accordion close-others="groupSele">
                <accordion-group is-open="true">
                    <accordion-heading>
                        <center><B>Manage filters for :</b> <?php echo htmlspecialchars($groupdetail['name']); ?> <b>Group</b></center>
                    </accordion-heading>
        
    <div class="btn-group" dropdown is-open="status.isopen">

       <center>
        <input type='hidden' id='groupId' value="<?php echo intval($groupIds); ?>">
        <input type='hidden' id='langId' value="<?php echo intval($groupIds); ?>">
        <h2>Name: <b><?php echo htmlspecialchars($groupdetail['name']); ?></b><BR>Files: <b><?php echo htmlspecialchars($groupdetail['custom_files']); ?></b><BR>Description: <b><small><?php echo htmlspecialchars($groupdetail['description']); ?></small></B></h2>
        <input id='filesVal' value='{{ selected_group.files }}' type='hidden'>
            </BR>
                <A href="./groups.php" class="btn btn-primary"><B>Back</B></A>

                <button id="save_groups" class="btn btn-danger" name="trythispatterns" data-loading-text="Loading..."><FONT COLOR=white><B>Save</B></font> </button> <select id="select" multiple="multiple">
<?php
    $stack2 = array();
    
    $json = file_get_contents($url_config."filters/read.php");
    $obj = json_decode($json,TRUE);
        foreach($obj as $key => $item){
            array_push($stack2, array($obj[$key]['id'], $obj[$key]['title'], $obj[$key]['groups']));
        }
				$stack1 = array_unique($stack1);
                    
                    echo "<optgroup label=\"".htmlspecialchars($groupdetail['name'])."\">";
                            foreach ($stack2 as $valuek) {
                                $is_capu=false;
                                foreach ($valuek[2] as $capu) { //search in filter/read.php
                                    if($capu['group_name']==htmlspecialchars($groupdetail['name'])){
                                        $is_capu=true;
                                        break;
                                    }
                                }
                                
                                if($is_capu){
                                    echo '<option value="'.htmlspecialchars($valuek[0]).'" selected>'.htmlspecialchars($valuek[1]).'</option>';
                                }
                            }
                    echo "</optgroup>";

                    echo "<optgroup label='Unassigned'>";
                            foreach ($stack2 as $valuek) {
                                $is_capu=false;
                                foreach ($valuek[2] as $capu) { //search in filter/read.php
                                    if($capu['group_name']==$groupdetail['name']){
                                        $is_capu=true;
                                        break;
                                    }
                                }
                                
                                if(!$is_capu){
                                    echo '<option value="'.htmlspecialchars($valuek[0]).'">'.htmlspecialchars($valuek[1]).'</option>';
                                }
                            }
                    echo "</optgroup>";

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