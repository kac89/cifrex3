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

if($_POST['show_filter']==1){
    
    if($_POST['valueselected']!==""){
        $json = file_get_contents($url_config."filters/read.php");
        $obj = json_decode($json,TRUE);
            foreach($obj as $key => $item){
                if($obj[$key]['id']==$_POST['valueselected']){

                    $tab = array(
                            'id' => $obj[$key]['id'],
                            'title' => $obj[$key]['title'],
                            'description' => $obj[$key]['description'],
                            'author' => $obj[$key]['author'],
                            'env' => $obj[$key]['env'],
                            'cve' => $obj[$key]['cve'],
                            'cwe' => $obj[$key]['cwe'],
                            'wlb' => $obj[$key]['wlb'],
                            'v1' => $obj[$key]['v1'],
                            'v2' => $obj[$key]['v2'],
                            'v3' => $obj[$key]['v3'],
                            't1' => $obj[$key]['t1'],
                            't2' => $obj[$key]['t2'],
                            't3' => $obj[$key]['t3'],
                            'f1' => $obj[$key]['f1'],
                            'f2' => $obj[$key]['f2'],
                            'f3' => $obj[$key]['f3'],
                            'diff' => $obj[$key]['diff'],
                            'date' => $obj[$key]['date'],
                            );

                                echo json_encode($tab);

                    }
            }
    }
}