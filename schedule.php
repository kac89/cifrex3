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
echo startHtmlUpToNavBar("schedule");
?>


    <div class="container">
     <div class="row"><CENTER>
         
         
              <script>
function myFunction() {
    document.getElementById("demo").innerHTML = "Hello World";
}
</script>
         
         
      <h1>Search Result:</h1><input type="text" ng-model="query" class="form-control" placeholder="Search" ng-Init="query ='<?php echo (isset($_GET['q'])) ? htmlspecialchars(addslashes($_GET['q'])) : ''; ?>'">
    <table class="table table-striped">
      <tr>
        <th align='center'><a href="#" ng-click="predicate = 'lang_id'; reverse=false">ID</a>
          (<a href="#" ng-click="predicate = '-lang_id'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'name'; reverse=false">Name</a>
          (<a href="#" ng-click="predicate = '-name'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'description'; reverse=false">Credit</a>
          (<a href="#" ng-click="predicate = '-description'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'files'; reverse=false">Date</a>
          (<a href="#" ng-click="predicate = '-files'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'files'; reverse=false">Path</a>
          (<a href="#" ng-click="predicate = '-files'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'files'; reverse=false">Files</a>
          (<a href="#" ng-click="predicate = '-files'; reverse=false">^</a>)</th>
        <th><a href="#" ng-click="predicate = 'files'; reverse=false">Count</a>
          (<a href="#" ng-click="predicate = '-files'; reverse=false">^</a>)</th>
        <th>Details</th>
        <th>Result</th>
        <th>Remove</th>
      </tr>
        
      <tr ng-repeat="item in results | orderBy:predicate:reverse | filter:query" ng-controller="resultCtrl">
        <td class="gray-lighter">{{item.result_id}} </td>
        <td> {{item.name}} </td>
        <td> {{item.credit}} </td>
        <td> {{item.date}} </td>
        <td> {{item.path}} </td>
        <td> {{item.files}} </td>
        <td> {{item.count}} </td>
        <td><A href="#" class="btn btn-default" ng-click="showFilter('lg')"><B>Log</B></A></td>
        <td><A href="#" class="btn btn-primary" ng-click="resultShow('lg')"><B>Result</B></A></td>
        <td><A href="#" class="btn btn-success" ng-click="resultDelete()"><B>Del</B></A></td>

      </tr>
    </table>		
    </CENTER>
     </div>
    </div>

</BODY>
</html>