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
include './include/general/navbar.php';

$whatManage='lang';
if(isset($_GET['action']) and $_GET['action']=='group') $whatManage='group';
if(!isset($_GET['id']) OR !is_numeric($_GET['id'])) die("exit");

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

if($whatManage=='lang'){
    $dbLink->sql("SELECT * FROM cifrex_languages WHERE lang_id=".intval($_GET['id']));
} else {
    $dbLink->sql("SELECT * FROM cifrex_groups WHERE group_id=".intval($_GET['id']));    
}
if($dbLink->numOfRows()!=1) die("Not exists");  

$outedit=$dbLink->getResults();

// HTML START up to navBar
echo startHtmlUpToNavBar("database");
?>

    <div class="container">
     <div class="row"><CENTER>
      <h1>Add/Remove filters for <?php echo $outedit[0]['name']; if($whatManage=='lang'){ echo 'language'; }else{ echo 'group'; } ?></h1><input type="text" ng-model="query" class="form-control" placeholder="Search">
    <table class="table">
      <tr>
        <th align='center'><a href="#" ng-click="predicate = 'id'; reverse=false">ID</a>
          (<a href="#" ng-click="predicate = '-id'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'title'; reverse=false">Name</a>
          (<a href="#" ng-click="predicate = '-title'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'env'; reverse=false">Language</a>
          (<a href="#" ng-click="predicate = '-env'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'author'; reverse=false">Author</a>
          (<a href="#" ng-click="predicate = '-author'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'cve'; reverse=false">CVE</a>
          (<a href="#" ng-click="predicate = '-cve'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'cwe'; reverse=false">CWE</a>
          (<a href="#" ng-click="predicate = '-cwe'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'date'; reverse=false">Created</a>
          (<a href="#" ng-click="predicate = '-date'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'diff'; reverse=false">Modified</a>
          (<a href="#" ng-click="predicate = '-diff'; reverse=false">^</a>)</th>
        <th>Remove</th>
		<th>Edit</th>
      </tr>
      <tr ng-repeat="filter in filters  | orderBy:predicate:reverse | filter:query" ng-controller="editFilterCtrl">
        <td class="gray-lighter"> {{filter.id}} </td>
        <td> {{filter.title}} </td>
        <td> {{filter.env}} </td>
        <td> {{filter.author}} </td>
        <td> {{filter.cve}} </td>
        <td> {{filter.cwe}} </td>
        <td> {{filter.date  | date }} </td>
        <td> {{filter.diff | date }} </td>
        <td><A href="#" class="btn btn-warning" id="deletefilter" ng-click="deleteFilter('lg')"><B>Delete</B></A></td>
        <td><A href="#" class="btn btn-primary" id="editfilter" ng-click="editFilter('lg')"><B>Edit</B></A></td>
      </tr>
    </table>	
	<a href="#" class="btn btn-primary" id="savefilter" ng-click="saveFilter('lg')"><B>Add New</B></a>
	
    </CENTER>
     </div>
    </div>

</BODY>
</html>