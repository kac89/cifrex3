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


$handleIt = (isset($_GET['action'])) ? $_GET['action'] : 'index';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

// HTML START up to navBar
echo startHtmlUpToNavBar("languages");
?>

    <div class="container">
     <div class="row"><CENTER>
      <h1>Search language:</h1><input type="text" ng-model="query" class="form-control" placeholder="Search">
    <table class="table table-striped">
      <tr>
        <th align='center'><a href="#" ng-click="predicate = 'lang_id'; reverse=false">ID</a>
          (<a href="#" ng-click="predicate = '-lang_id'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'name'; reverse=false">Name</a>
          (<a href="#" ng-click="predicate = '-name'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'description'; reverse=false">Description</a>
          (<a href="#" ng-click="predicate = '-description'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'files'; reverse=false">Files</a>
          (<a href="#" ng-click="predicate = '-files'; reverse=false">^</a>)</th>
        <th>Filters</th>
        <th>Remove</th>
		<th>Edit</th>
      </tr>
      <tr ng-repeat="item in languages  | orderBy:predicate:reverse | filter:query" ng-controller="languagesCtrl">
        <td class="gray-lighter">{{item.lang_id}} </td>
        <td> {{item.name}} </td>
        <td> {{item.description}} </td>
        <td> {{item.files}} </td>
        <td><A href="./managelang.php?langId={{item.lang_id}}" class="btn btn-default" id="deletefilter" ng-click="manageLang()"><B>Manage</B></A></td>
        <td><A href="#" class="btn btn-success" id="deletelang" ng-click="deleteLang(lg)"><B>Delete</B></A></td>
        <td><A href="#" class="btn btn-primary" id="editlang" ng-click="editLang('lg')"><B>Edit</B></A></td>
      </tr>
    </table>	
	<a href="#" class="btn btn-primary" id="savelang" ng-click="saveLang('lg')"><B>Add New</B></a>
	
    </CENTER>
     </div>
    </div>

</BODY>
</html>