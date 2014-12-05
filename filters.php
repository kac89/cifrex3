<?php

if($_POST['show_filter']==1){
    
    if($_POST['valueselected']!==""){
        $json = file_get_contents("http://127.0.0.1/cifrex3/filters/filters.json");
        $obj = json_decode($json,TRUE);
            foreach($obj as $key => $item){
                if($obj[$key]['id']==$_POST['valueselected']){
                   // print $obj[$key]['id'];

                              $tab = array(
                            'id' => $obj[$key]['id'],
                            'title' => $obj[$key]['title'],
                            'author' => $obj[$key]['author'],
                            'env' => $obj[$key]['env'],
                            'cve' => $obj[$key]['cve'],
                            'cwe' => $obj[$key]['cwe'],
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