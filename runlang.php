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

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

// HTML START up to navBar
echo startHtmlUpToNavBar("languages");
?>

    <div class="container">
    <h1><center>Run language patterns</center></h1>
    <div class="row">
        <div class="col-lg-15"><h5><U>Directory to source code:</U></h5><INPUT type="text" id="katalog" class="form-control input-sm" id="directory" placeholder="Directory" ng-model="items.path" ng-Init="items.path ='<?php echo $default['path']; ?>'"></div>
    </div>
            
            
    <div class="row"></div>   
 
      </div>              
            
<!-- TABLE --> 
    <div id="tabeladiv">
          <div class="table-responsive">
              
        <center>
            <accordion close-others="langSele">
                <accordion-group is-open="true">
                    <accordion-heading>
                        <center><B>Select Language:</B> {{ selected_lang.name }} ( Only Files : {{selected_lang.files}} )
                            <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.isLang, 'glyphicon-chevron-right': !status.isLang}"></i></center>
        
                    </accordion-heading>
        
    <div class="btn-group" dropdown is-open="status.isopen">

        
        <table><TR><TD>
        <h2>Name: <b>{{ selected_lang.name }}</b><BR>Files: <b>{{ selected_lang.files }} </b><BR>Description: <b><small>{{ selected_lang.description }}</small></B></h2>
        <input id='filesVal' value='{{ selected_lang.files }}' type='hidden'>

            </TD></TR><TR><TD>

            </TD></TR></table>
    
            
            
                  <button type="button" class="btn btn-primary dropdown-toggle" dropdown-toggle ng-disabled="disabled">Change<span class="caret"></span>
      </button>
        <ul class="dropdown-menu" role="menu" id='filesToScan'>
            <li ng-repeat="lang_item in languages  | orderBy:predicate:reverse" ng-controller="selectFiles"><a href="" ng-click="setValue()"><B>{{ lang_item.name }}</B> ( {{lang_item.files}} )</a></li>
        </ul>
        <a href="#" class="btn btn-danger" id="savefilter"  ng-click="saveLang('lg')"><B>Add new language</B></a>

            
            
    </div>
                </accordion-group>
            </accordion>
                
                <accordion>
                <accordion-group is-open="true">
                    <accordion-heading>
                        <center><B>Set properties of execution</B>
                            <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.isOther, 'glyphicon-chevron-right': !status.isOther}"></i></center>
                    </accordion-heading>
        
            <center><h1>Submit to database: {{ saveToDb }}</h1><BR>
                <div class="btn-group" id='toDbSave'>
                    <label  for="saveTag" class="productStatus btn btn-success" ng-model="saveToDb" ng-click='changeSaveToDb("True")' btn-radio="'True'" value='true' ng-Init="saveToDb ='<?php echo $default['saveResult']; ?>'">True</label>
                    <label  for="saveTag" class="productStatus btn btn-danger" ng-model="saveToDb" ng-click='changeSaveToDb("False")' btn-radio="'False'">False</label>
                    <input id='debugLogVal' value='{{ saveToDb }}' type='hidden'>
                </div>
                <BR>
    
                <center><h1>Generate Execution Log: {{ debugLog }}</h1><BR>
                <div class="btn-group" id='toDbSave'>
                    <label  for="saveTag" class="btn btn-success" ng-model="debugLog" ng-click='changeDebugLog("True")' btn-radio="'True'" value='true' ng-Init="debugLog ='<?php echo $default['debugLogCreate']; ?>'">True</label>
                    <label  for="saveTag" class="btn btn-danger" ng-model="debugLog" ng-click='changeDebugLog("False")' btn-radio="'False'">False</label>
                    <input id='execLog' value='{{ debugLog }}' type='hidden'>
                </div>
                <BR>

                <h1>Others:</h1>
                <INPUT type="text" class="form-control input-lg" id='nameOfScan' ng-model="items.nameOfScan" placeholder="Name of job" ng-Init="items.nameOfScan ='<?php echo $default['nameOfJob']; ?>'"><BR>
                <INPUT type="text" class="form-control input-lg" id='credit' ng-model="items.credit" placeholder="Credit" ng-Init="items.credit ='<?php echo $default['credit']; ?>'"><BR>
                <INPUT type="text" class="form-control input-lg" id='email' ng-model="items.email" placeholder="Send email with result (name@domain)"  ng-Init="items.email ='<?php echo $default['email']; ?>'">
                </accordion-group>
            </accordion>
                    </DIV>
            <center> 
            <h1>Run console:</h1>
            <textarea rows="6" cols="120">curl --data "toDb={{ saveToDb }}&execLog={{ debugLog }}&katalog={{ items.path }}&lang_id={{ selected_lang.lang_id }}&resultName={{ items.nameOfScan }}&email={{ items.email }}&credit={{ items.credit }}&printOutput=True&trythispatterns=Lang" <?php echo $url_config;?>run-core-php/run-lang.php</textarea>
            </center>
            <BR>    
        </div>
    
<!-- TABLE -->         
			<div class="row">

            
            </div>
                    </center>
           
        <div id="wyniki"></div>
        <div id="multisearch"></div>
            
        <a href="#" class="back-to-top">Back to Top</a>
    </div>
        <center><P>
        </div>

            
            
                        <P>&nbsp;
            </BR></div>
</div>    

            </BODY>
</html>