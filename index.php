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
include './default_values.php';
include './include/general/db.php';
include './include/general/navbar.php';

$handleIt = (isset($_GET['action'])) ? $_GET['action'] : 'index';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

// HTML START up to navBar
echo startHtmlUpToNavBar("quick_scan");

if(isset($_COOKIE['langId']) AND is_numeric($_COOKIE['langId'])){
    $langIds = intval($_COOKIE['langId']); 
} else {
    $langIds = intval($default['defaultLandId']);
}

if(isset($_COOKIE['toDB']) AND ($_COOKIE['toDB']=='True' OR $_COOKIE['toDB']='False')){
    $coo_toDb = $_COOKIE['toDB']; 
} else {
    $coo_toDb = $default['saveResult'];
}

if(isset($_COOKIE['execLog']) AND ($_COOKIE['execLog']=='True' OR $_COOKIE['execLog']='False')){
    $coo_exeL = $_COOKIE['execLog']; 
} else {
    $coo_exeL = $default['debugLogCreate'];
}

$dbLink->sql("SELECT * FROM `cifrex_languages` WHERE lang_id= '".$langIds."'");
$cookie_lang_nbrOfRes=$dbLink->numOfRows();
    
if($cookie_lang_nbrOfRes==1){
        $langdetail=$dbLink->getResults();
        $langdetail=$langdetail[0];
} else $cookie_lang_nbrOfRes=0;

?>
<div class="container">
    <div class="row">
        <div class="col-lg-15"><h5><U>Direectory to source code:</U></h5><INPUT type="text" id="katalog" class="form-control input-sm" id="directory" placeholder="Directory" ng-model="items.path" ng-Init="items.path ='<?php echo (isset($_COOKIE['dir'])) ? addslashes(htmlspecialchars($_COOKIE['dir'])) : $default['path']; ?>'"></div>
    </div>           
    <div class="row"></div>   
     <div class="row">

     	<div class="col-lg-15"><center><button id="start_cifrex" class="btn btn-primary" name="trythispatterns" data-loading-text="Loading..." type="button"><FONT COLOR=white><B>Start static code analysis!</B></font> </button> <select id="select" multiple="multiple">
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
                    
                    echo "<optgroup label=\"".(!empty($value) ? htmlspecialchars($value) : 'else')."\">";
                            foreach ($stack2 as $valuek) {
                            if($value == $valuek[2]){
                            echo '<option value="'.intval($valuek[0]).'">'.htmlspecialchars($valuek[3]).' '.htmlspecialchars($valuek[1]).'</option>';
                            }
                            }
                }

                unset($stack1);
				unset($stack2);
                      
?>
    </select><button id="show_selected" class="btn btn-success" name="trythispatterns" data-loading-text="Loading..." type="button"><FONT COLOR=white><B>Show selected</B></font> </button>
            <a href="#" class="btn btn-primary" id="savefilter"  ng-click="saveFilter('lg')"><B>Save Filter</B></a> <a href="./destroycookie.php" class="btn btn-primary"><B>Clean</B></a>
            
    </div>
      </div>
      </div>              
            
<!-- TABLE --> 
    <div id="tabeladiv">
          <div class="table-responsive">
              
        <center>
            <div id="patterns">

            <div id="divCheckbox" style="visibility: hidden">        
                    <INPUT type="text" name="filtrName" id='filtrName' ng-model="items.filtrName" ng-change="changeFiltrName()">
                    <INPUT type="text" name="filtrId" id='filtrId' ng-model="items.filtrId">
                    <INPUT type="text" name="filtrDescription" id='filtrDescription' ng-model="items.filtrDescription" ng-change="changeFiltrDescription()">
            </div>
        
        <TABLE>
            <tbody>
                <tr>
                    <td width="1%" bgcolor="#F8F8F8"></td>
                    <td width="98%" bgcolor="#F8F8F8"><BR>
                    
              
          <TABLE class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><center>Value</center></th>
                        <th><center>True</center></th>
                        <th><center>False</center></th>
                    </tr>
                </thead>

            <tbody>
                <tr>
                    <td>1<BR><INPUT type="text" name="value1" placeholder="Requied" class="form-control input-sm" id="v1" size="100" ng-model="vValues.v1" ng-change="changePatternV1()" ng-Init="vValues.v1 ='<?php  echo (isset($_COOKIE['value1'])) ? addslashes(htmlspecialchars($_COOKIE['value1'])) : '' ?>'"></td>
                    <td>1<BR><INPUT type="text" name="true1" class="form-control input-sm" id='t1' size="50" ng-model="tValues.t1" value="" ng-change="changePatternT1()" ng-Init="tValues.t1 ='<?php  echo (isset($_COOKIE['true1'])) ? addslashes(htmlspecialchars($_COOKIE['true1'])) : '' ?>'"></td>
                    <td>1<BR><INPUT type="text" name="false1" class="form-control input-sm" id='f1' size="50" ng-model="fValues.f1" value="" ng-change="changePatternF1()" ng-Init="fValues.f1 ='<?php  echo (isset($_COOKIE['false1'])) ? addslashes(htmlspecialchars($_COOKIE['false1'])) : '' ?>'"></td>
                </tr>
                <tr>
                    <td>2<BR><INPUT test-change type="text" name="value2" class="form-control input-sm" id='v2' size="100" ng-model="vValues.v2" value="" ng-change="changePatternV2()"  ng-Init="vValues.v2 ='<?php  echo (isset($_COOKIE['value2'])) ? addslashes(htmlspecialchars($_COOKIE['value2'])) : '' ?>'"></td>
                    <td>2<BR><INPUT type="text" name="true2" class="form-control input-sm"  size="50" id='t2' ng-model="tValues.t2" value="" ng-change="changePatternT2()" ng-Init="tValues.t2 ='<?php  echo (isset($_COOKIE['true2'])) ? addslashes(htmlspecialchars($_COOKIE['true2'])) : '' ?>'"></td>
                    <td>2<BR><INPUT type="text" name="false2" class="form-control input-sm" size="50"  id='f2'ng-model="fValues.f2" value="" ng-change="changePatternF2()" ng-Init="fValues.f2 ='<?php  echo (isset($_COOKIE['false2'])) ? addslashes(htmlspecialchars($_COOKIE['false2'])) : '' ?>'"></td>
                </tr>
                <tr>
                    <td>3<BR><INPUT type="text" name="value3" class="form-control input-sm" size="100" id='v3' ng-model="vValues.v3" value="" ng-change="changePatternV3()" ng-Init="vValues.v3 ='<?php  echo (isset($_COOKIE['value3'])) ? addslashes(htmlspecialchars($_COOKIE['value3'])) : '' ?>'"></td>
                    <td>3<BR><INPUT type="text" name="true3" class="form-control input-sm" size="100" id='t3' ng-model="tValues.t3" value="" ng-change="changePatternT3()" ng-Init="tValues.t3 ='<?php  echo (isset($_COOKIE['true3'])) ? addslashes(htmlspecialchars($_COOKIE['true3'])) : '' ?>'"></td>
                    <td>3<BR><INPUT type="text" name="false3" class="form-control input-sm" size="100" id='f3' ng-model="fValues.f3" value="" ng-change="changePatternF3()" ng-Init="fValues.f3 ='<?php  echo (isset($_COOKIE['false3'])) ? addslashes(htmlspecialchars($_COOKIE['false3'])) : '' ?>'"></td>
                </tr>    
            </tbody>
        </TABLE></td>
                    <td width="1%"  bgcolor="#F8F8F8"></td>
                        </tr>
                        </tbody>
                        </TABLE><BR>
                        </DIV>
                        
                    <TABLE border=0 class=table>
                    
                        <tr>
                            <td width="10%" bgcolor="#FFFFFF"></td>
                            <td width="80%" bgcolor="#FFFFFF"><CENTER>

            <accordion close-others="langSele">
                <accordion-group is-open="status.isLang">
                    <accordion-heading>
                        <center><B>Select Language</B> ( Only Files : {{selected_lang.files}} )
                            <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.isLang, 'glyphicon-chevron-right': !status.isLang}"></i></center>
                    </accordion-heading>
        
    <div class="btn-group" dropdown is-open="status.isopen">
        <table><TR><TD>
            <h2>Name: <b ng-bind="selected_lang.name"<?php if($cookie_lang_nbrOfRes){ echo ' ng-Init="selected_lang.name =\''.htmlspecialchars(stripslashes($langdetail['name'])).'\'"'; } ?>></b><BR>Files: <b ng-bind="selected_lang.files"<?php if($cookie_lang_nbrOfRes){ echo ' ng-Init="selected_lang.files =\''.htmlspecialchars(stripslashes($langdetail['files'])).'\'"'; } ?>></b><BR>Description: <br><b><small ng-bind="selected_lang.description"<?php if($cookie_lang_nbrOfRes){ echo ' ng-Init="selected_lang.description =\''.htmlspecialchars(stripslashes($langdetail['description'])).'\'"'; } ?>></small></B></h2>
        <input id='filesVal' value='{{ selected_lang.files }}' type='hidden'>
        <input id='langId' value='{{ selected_lang.lang_id }}' type='hidden'>
        </TD></TR></table>
            
                  <button type="button" class="btn btn-primary dropdown-toggle" dropdown-toggle ng-disabled="disabled">Change<span class="caret"></span>
      </button>
        <ul class="dropdown-menu" role="menu" id='filesToScan'>
            <li ng-repeat="lang_item in languages  | orderBy:predicate:reverse" ng-controller="selectFiles"><a href="" ng-click="setValue()"><B>{{ lang_item.name }}</B> ( {{lang_item.files}} )</a></li>
        </ul>
        <a href="#" class="btn btn-danger" id="savefilter"  ng-click="saveLang('lg')"><B>Add new language</B></a>

            
            
            </div>
</CENTER>
                </accordion-group>
            </accordion>

                <accordion>
                <accordion-group is-open="status.isOther">
                    <accordion-heading>
                        <center><B>Set properties of execution</B>
                            <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.isOther, 'glyphicon-chevron-right': !status.isOther}"></i></center>
                    </accordion-heading>
        
            <center><h1>Submit to database: {{ saveToDb }}</h1><BR>
                <div class="btn-group" id='toDbSave'>
                    <label for="saveTag" class="productStatus btn btn-success" ng-model="saveToDb" ng-click='changeSaveToDb("True")' btn-radio="'True'" ng-Init="saveToDb ='<?php echo $coo_toDb; ?>'" value='true'>True</label>
                    <label for="saveTag" class="productStatus btn btn-danger" ng-model="saveToDb" ng-click='changeSaveToDb("False")' btn-radio="'False'" value='false'>False</label>
                    <input id='debugLogVal' value='{{ saveToDb }}' type='hidden'>
                </div>
                <BR>
    
                <center><h1>Generate Execution Log: {{ debugLog }}</h1><BR>
                <div class="btn-group" id='toDbSave'>
                    <label  for="saveTag" class="btn btn-success" ng-model="debugLog" ng-click='changeDebugLog("True")' btn-radio="'True'" value='true' ng-Init="debugLog ='<?php echo $coo_exeL; ?>'">True</label>
                    <label  for="saveTag" class="btn btn-danger" ng-model="debugLog" ng-click='changeDebugLog("False")' btn-radio="'False'">False</label>
                    <input id='execLog' value='{{ debugLog }}' type='hidden'>
                </div>
                <BR>

                <h1>Others:</h1>
                <INPUT type="text" class="form-control input-lg" id='nameOfScan' ng-model="items.nameOfScan" placeholder="Name of job" ng-Init="items.nameOfScan ='<?php echo $default['nameOfJob']; ?>'"><BR>
                <INPUT type="text" class="form-control input-lg" id='credit' ng-model="items.credit" placeholder="Credit" ng-Init="items.credit ='<?php  echo (isset($_COOKIE['credit'])) ? addslashes(htmlspecialchars($_COOKIE['credit'])) : $default['credit']; ?>'"><BR>
                <INPUT type="text" class="form-control input-lg" id='email' ng-model="items.email" placeholder="Send email with result (name@domain)" ng-Init="items.email ='<?php echo $default['email']; ?>'">
                </accordion-group>
            </accordion>
                    
                    </td>
                    <td width="10%" bgcolor="#FFFFFF"></td>
                </tr>
            </TABLE>
                
            <div id="runConsoleW">
            <center> 
            <h1>Run console:</h1>
            <textarea rows="6" cols="120">curl --data "toDb={{ saveToDb }}&execLog={{ debugLog }}&katalog={{ items.path }}&files={{ selected_lang.files }}&value1={{BvValues.v1}}&true1={{BtValues.t1}}&false1={{BfValues.f1}}&value2={{BvValues.v2}}&true2={{BtValues.t2}}&false2={{BfValues.f2}}&value3={{BvValues.v3}}&true3={{BtValues.t3}}&false3={{BfValues.f3}}&resultName={{ items.nameOfScan }}&email={{ items.email }}&credit={{ items.credit }}&filtrId={{items.filtrId}}&filtrName={{items.BfiltrName}}&filtrDescription={{items.BfiltrDescription}}&printOutput=True&trythispatterns=Single" <?php echo $url_config;?>run-core-php/search.php</textarea>
            </center>
            <BR>
            </div>                    
        </div>
    </center>

        <div id="multisearch"></div>
                    
                    <center><button id="start_cifrex2" class="btn btn-primary" name="trythispatterns" data-loading-text="Loading..." type="button"><FONT COLOR=white><B>Start static code analysis!</B></font> </button></center>

        <div id="wyniki"></div>
            
        <a href="#" class="back-to-top">Back to Top</a>
    </div>
        <center><P>
        </div>


                        <P>&nbsp;
            </BR></div>
</div>    

            </BODY>
</html>