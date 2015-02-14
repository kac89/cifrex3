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

include './../config.php';
include './../include/general/db.php';
include './../include/general/debug.php';
include './../include/general/error.php';
include './../include/general/json.php';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

// create error handler
        error_reporting(E_ALL);
        $tempnam = tempnam("./error_log/", date('mdy_G.i.s_'));
        ini_set('log_errors', '1'); 
        ini_set('display_errors', 0);
        $temp = fopen($tempnam, "w");
        fclose($temp);
        chmod($tempnam, 755);
        ini_set('error_log', $tempnam); 

if(isset($_POST['execLog']) AND $_POST['execLog']=='True') $saveLog=true; else $saveLog=false;
if(isset($_POST['printOutput']) AND $_POST['printOutput']=='True') $printOutput=true; else $printOutput=false;

// create debug handler {string,standard}
$log = new debugMe($printOutput ? 'standard' : 'string');

// input validation
if(isset($_POST['toDb']) AND $_POST['toDb']=='True') $writeToDb=true; else $writeToDb=false;
if(isset($_POST['resultName']) AND !empty($_POST['resultName'])) $resultName=$_POST['resultName']; else $resultName='Generic';
if(isset($_POST['credit']) AND !empty($_POST['credit'])) $credit=$_POST['credit']; else $credit='Anonymous';
if(isset($_POST['langId']) AND !empty($_POST['langId'])) $langId=$_POST['langId']; else $langId='0';
if(isset($_POST['email']) AND !empty($_POST['email'])) $email=$_POST['email']; else $email='';
if(isset($_POST['filtrName']) AND !empty($_POST['filtrName'])) $filtrName=$_POST['filtrName']; else $filtrName='';
if(isset($_POST['filtrDesciption']) AND !empty($_POST['filtrDesciption'])) $filtrDesciption=$_POST['filtrDesciption']; else $filtrDesciption='';
if(isset($_POST['filtrId']) AND !empty($_POST['filtrId'])) $filtrId=$_POST['filtrId']; else $filtrId='';

if(isset($_POST['katalog'])){ $katalog = $_POST['katalog']; } else $katalog='';

    // Initial Directory 
    if(!empty($_GET['katalog']) AND 0>=strncmp($cconfig['core']['internal_openbasedir'], $_POST['katalog'], strlen($cconfig['core']['internal_openbasedir']))) $katalog=$_GET['katalog']; 
    elseif(!empty($_POST['katalog']) AND 0>=strncmp($cconfig['core']['internal_openbasedir'], $_POST['katalog'], strlen($cconfig['core']['internal_openbasedir']))) $katalog=$_POST['katalog']; 
    else die("Ups. Specified directory outside internal openbasedir ".htmlspecialchars($cconfig['core']['internal_openbasedir']));

    $katalog=str_replace("../","/",str_replace("/..","/",$katalog));

    // Initial values
    // [V1,V2,V3] Value
    if(!empty($_GET['value1'])) $value1=$_GET['value1']; else if(!empty($_POST['value1'])) $value1=base64_decode($_POST['value1']); else $value1="";
    if(!empty($_GET['value2'])) $value2=$_GET['value2']; else if(!empty($_POST['value2'])) $value2=base64_decode($_POST['value2']); else $value2="";
    if(!empty($_GET['value3'])) $value3=$_GET['value3']; else if(!empty($_POST['value3'])) $value3=base64_decode($_POST['value3']); else $value3="";

    // [T1,T2,T3] True
    if(!empty($_GET['true1'])) $true1=$_GET['true1']; else if(!empty($_POST['true1'])) $true1=base64_decode($_POST['true1']); else $true1="";
    if(!empty($_GET['true2'])) $true2=$_GET['true2']; else if(!empty($_POST['true2'])) $true2=base64_decode($_POST['true2']); else $true2="";
    if(!empty($_GET['true3'])) $true3=$_GET['true3']; else if(!empty($_POST['true3'])) $true3=base64_decode($_POST['true3']); else $true3="";

    // [F1,F2,F3] False
    if(!empty($_GET['false1'])) $false1=$_GET['false1']; else if(!empty($_POST['false1'])) $false1=base64_decode($_POST['false1']); else $false1="";
    if(!empty($_GET['false2'])) $false2=$_GET['false2']; else if(!empty($_POST['false2'])) $false2=base64_decode($_POST['false2']); else $false2="";
    if(!empty($_GET['false3'])) $false3=$_GET['false3']; else if(!empty($_POST['false3'])) $false3=base64_decode($_POST['false3']); else $false3="";

    $searchext='.*';
    if(isset($_POST['files']) AND !empty($_POST['files'])){ $searchext=$_POST['files']; }
    if($searchext=='*') $searchext='.*';

if(isset($_POST['setCookie']) AND $_POST['setCookie']=="True"){
        setcookie('dir', $katalog, time() + (86400 * 30), "/");
        setcookie('credit', $credit, time() + (86400 * 30), "/");
        setcookie('toDB', ($writeToDb ? 'True' : 'False'), time() + (86400 * 30), "/");
        setcookie('execLog', ($saveLog ? 'True' : 'False'), time() + (86400 * 30), "/");
        setcookie('langId', $langId, time() + (86400 * 30), "/");
        setcookie('value1', $value1, time() + (86400 * 30), "/");    
        setcookie('value2', $value2, time() + (86400 * 30), "/");    
        setcookie('value3', $value3, time() + (86400 * 30), "/");    
        setcookie('true1', $true1, time() + (86400 * 30), "/");    
        setcookie('true2', $true2, time() + (86400 * 30), "/");    
        setcookie('true3', $true3, time() + (86400 * 30), "/");    
        setcookie('false1', $false1, time() + (86400 * 30), "/");    
        setcookie('false2', $false2, time() + (86400 * 30), "/");    
        setcookie('false3', $false3, time() + (86400 * 30), "/");    
}


// response type
header('Content-Type: application/json');

// start it baby
if(isset($_POST['trythispatterns'])){
    
    $tablica_z_wynikami = array();
    
    function skanujDirectory($rootDir) {
        $allData = array();
        $invisibleFileNames = array(".", "..", ".htaccess", ".htpasswd");
        $fileCounter = 0;
        $dirContent = scandir($rootDir);
        foreach($dirContent as $key => $content) {
            $path = $rootDir.'/'.$content;
            if(!in_array($content, $invisibleFileNames)) {
                if(is_file($path) && is_readable($path)) {
                    $tmpPathArray = explode("/",$path);
                    $allData[$fileCounter]['fileName'] = end($tmpPathArray);
                    $allData[$fileCounter]['filePath'] = $path;
                    $filePartsTmp = explode(".", end($tmpPathArray));
                    $allData[$fileCounter]['fileExt'] = end($filePartsTmp);
                    $allData[$fileCounter]['fileDate'] = filectime($path);
                    $allData[$fileCounter]['fileSize'] = filesize($path);
                    $fileCounter++;
                }elseif(is_dir($path) && is_readable($path)) {
                    $dirNameArray = explode('/',$path);
                    $allData[$path]['dirPath'] = $path;
                    $allData[$path]['dirName'] = end($dirNameArray);
                    $allData[$path]['content'] = skanujDirectory($path);
                }
            }
        }
        return $allData;
    }

    function array_sort_by_column(&$array, $column, $direction = SORT_DESC) {
        $reference_array = array();

        foreach($array as $key => $row)
            $reference_array[$key] = $row[$column];

        array_multisort($reference_array, $direction, $array);
    }

    function scanpreg($bufftmp,$buffer,$ematchnot){

        if(0<preg_match_all("/".$bufftmp."/m",$buffer,$wyszukane2))
            if(!empty($ematchnot)){

                if(preg_match_all("/".$ematchnot."/m",$buffer,$wyszukane3)<=0){
                    echo "<FONT color='red'>Check";
                    print_r($wyszukane2);
                    echo "</FONT>";
                    unset($wyszukane2);
                    unset($wyszukane3);
                } else echo "SKIPED";

            } else {
                echo "<FONT color='red'>Check";
                print_r($wyszukane2);
                echo "</FONT>";
                unset($wyszukane2);
            }

    }
    function remarr($arr){
        $gen=array();

        foreach($arr as $val)
            if(!is_int(array_search($val,$gen))) $gen[]=$val;

        return $gen;
    }

    function extractarray($tab){
        foreach($tab as $no => $val)
        {
            if(is_array($val)) $tab[$no] = extractarray($val);
              else $tab[$no] = ltrim(($val));
        }

        return $tab;
    }

    function nrlini_preg_match_all($pattern, $subject)
    {
        $offset = 0;
        $match_count = 0;
        $lol3 = null;
        $stack = array();
        while(preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, $offset))
        {
            $match_count++;
            $match_start = $matches[0][1];
            $match_length = strlen($matches[0][0]);
            foreach($matches as $k => $match) $newmatches[$k] = $match[0];
            $offset = $match_start + $match_length;
            list($before) = str_split($subject, $offset);
            $line_number = strlen($before) - strlen(str_replace("\n", "", $before)) + 1;
            array_push($stack,$line_number);
        }
        $result33 = array_unique($stack);
        foreach ($result33 as &$value) {
            $lol3 .= $value.',';
        }

        return substr($lol3, 0, -1);
    }

    function scanfile($name){
        global $log;
        global $value1,$value2,$value3;
        global $true1,$true2,$true3;
        global $false1,$false2,$false3;
        global $tablica_z_wynikami;

        $log->add("[SC] File: ".$name);

        $handle = fopen($name, "r");
        $infoo=array();

        $values=array(array(),array(),array(),array(),array(),array()); // values like (?<v1>\w+) up to 6
        $buffer='';


        if ($handle) {
            while (!feof($handle)) {
                $buffer .= fgets($handle, 4096);			
            }

            flush();

            if(!empty($value1)){ $resv1=preg_match_all("/".$value1."/m",$buffer,$wyszukane1);
            if($resv1==0) return 0;
            else {
                if(isset($wyszukane1['v1'])) $values[0]=remarr($wyszukane1['v1']);
                $nrlini = nrlini_preg_match_all("/".$value1."/m", $buffer);
                if(isset($wyszukane1['v2'])) $values[1]=remarr($wyszukane1['v2']);
                if(isset($wyszukane1['v3'])) $values[2]=remarr($wyszukane1['v3']);
                if(isset($wyszukane1['v4'])) $values[3]=remarr($wyszukane1['v4']);
                if(isset($wyszukane1['v5'])) $values[4]=remarr($wyszukane1['v5']);
                if(isset($wyszukane1['v6'])) $values[5]=remarr($wyszukane1['v6']);
            }}
            if(!empty($value2)){ $resv2=preg_match_all("/".$value2."/m",$buffer,$wyszukane2);
            if($resv2==0) return 0;
            else {
                if(isset($wyszukane2['v1'])) $values[0]=remarr($wyszukane2['v1']);
                if(isset($wyszukane2['v2'])) $values[1]=remarr($wyszukane2['v2']);
                if(isset($wyszukane2['v3'])) $values[2]=remarr($wyszukane2['v3']);
                if(isset($wyszukane2['v4'])) $values[3]=remarr($wyszukane2['v4']);
                if(isset($wyszukane2['v5'])) $values[4]=remarr($wyszukane2['v5']);
                if(isset($wyszukane2['v6'])) $values[5]=remarr($wyszukane2['v6']);
            }}
            if(!empty($value3)){ $resv3=preg_match_all("/".$value3."/m",$buffer,$wyszukane3);
            if($resv3==0) return 0;
            else {
                if(isset($wyszukane3['v1'])) $values[0]=remarr($wyszukane3['v1']);
                if(isset($wyszukane3['v2'])) $values[1]=remarr($wyszukane3['v2']);
                if(isset($wyszukane3['v3'])) $values[2]=remarr($wyszukane3['v3']);
                if(isset($wyszukane3['v4'])) $values[3]=remarr($wyszukane3['v4']);
                if(isset($wyszukane3['v5'])) $values[4]=remarr($wyszukane3['v5']);
                if(isset($wyszukane3['v6'])) $values[5]=remarr($wyszukane3['v6']);

            }}

            for($ffa=0;$ffa<count($values[0]) or $ffa==0;$ffa++)
            for($ffb=0;$ffb<count($values[1]) or $ffb==0;$ffb++)
            for($ffc=0;$ffc<count($values[2]) or $ffc==0;$ffc++)
            for($ffd=0;$ffd<count($values[3]) or $ffd==0;$ffd++)
            for($ffe=0;$ffe<count($values[4]) or $ffe==0;$ffe++)
            for($fff=0;$fff<count($values[5]) or $fff==0;$fff++){
                $empty=array();

                if(isset($values[0][$ffa])){
                    $empty[0][1]=$values[0][$ffa];
                    $values[0][$ffa]=str_replace("_","\_",$values[0][$ffa]);
                    $values[0][$ffa]=str_replace("'","\'",$values[0][$ffa]);
                }
                if(isset($values[1][$ffb])){
                    $empty[0][2]=$values[1][$ffb];
                    $values[1][$ffb]=str_replace("_","\_",$values[1][$ffb]);
                    $values[1][$ffb]=str_replace("'","\'",$values[1][$ffb]);
                }
                if(isset($values[2][$ffc])){
                    $empty[0][3]=$values[2][$ffc];
                    $values[2][$ffc]=str_replace("_","\_",$values[2][$ffc]);
                    $values[2][$ffc]=str_replace("'","\'",$values[2][$ffc]);
                }
                if(isset($values[3][$ffd])){
                    $empty[0][4]=$values[3][$ffd];
                    $values[3][$ffd]=str_replace("_","\_",$values[3][$ffd]);
                    $values[3][$ffd]=str_replace("'","\'",$values[3][$ffd]);
                }
                if(isset($values[4][$ffe])){
                    $empty[0][5]=$values[4][$ffe];
                    $values[4][$ffe]=str_replace("_","\_",$values[4][$ffe]);
                    $values[4][$ffe]=str_replace("'","\'",$values[4][$ffe]);
                }
                if(isset($values[5][$fff])){
                    $empty[0][6]=$values[5][$fff];
                    $values[5][$fff]=str_replace("_","\_",$values[5][$fff]);
                    $values[5][$fff]=str_replace("'","\'",$values[5][$fff]);
                }

                if(!empty($true1)){
                    $bufft1='';
                    if(isset($values[0][$ffa]))
                    $bufft1=str_replace("<v1>",$values[0][$ffa],$true1);
                    if(isset($values[1]) and isset($values[1][$ffb]) and $values[1]==$values[1][$ffc])
                    $bufft1=str_replace("<v2>",$values[1][$ffb],$bufft1);
                    if(isset($values[2]) and isset($values[2][$ffc]) and $values[2]==$values[2][$ffc])
                    $bufft1=str_replace("<v3>",$values[2][$ffc],$bufft1);
                    if(isset($values[3]) and isset($values[3][$ffd]))
                    $bufft1=str_replace("<v4>",$values[3][$ffd],$bufft1);
                    if(isset($values[4]) and isset($values[4][$ffe]))
                    $bufft1=str_replace("<v5>",$values[4][$ffe],$bufft1);
                    if(isset($values[5]) and isset($values[5][$fff]))
                    $bufft1=str_replace("<v6>",$values[5][$fff],$bufft1);

                    if(preg_match_all("/".$bufft1."/m",$buffer,$empty[1])<=0) continue;
                }

                if(!empty($true2)){
                    if(isset($values[0][$ffa]))
                    $bufft2=str_replace("<v1>",$values[0][$ffa],$true2);
                    if(isset($values[1]) and isset($values[1][$ffb]))
                    $bufft2=str_replace("<v2>",$values[1][$ffb],$bufft2);
                    if(isset($values[2]) and isset($values[2][$ffc]))
                    $bufft2=str_replace("<v3>",$values[2][$ffc],$bufft2);
                    if(isset($values[3]) and isset($values[3][$ffd]))
                    $bufft2=str_replace("<v4>",$values[3][$ffd],$bufft2);
                    if(isset($values[4]) and isset($values[4][$ffe]))
                    $bufft2=str_replace("<v5>",$values[4][$ffe],$bufft2);
                    if(isset($values[5]) and isset($values[5][$fff]))
                    $bufft2=str_replace("<v6>",$values[5][$fff],$bufft2);

                    if(preg_match_all("/".$bufft2."/m",$buffer,$empty[2])<=0) continue;

                }

                if(!empty($true3)){
                    if(isset($values[0][$ffa]))
                    $bufft3=str_replace("<v1>",$values[0][$ffa],$true3);
                    if(isset($values[1]) and isset($values[1][$ffb]))
                    $bufft3=str_replace("<v2>",$values[1][$ffb],$bufft3);
                    if(isset($values[2]) and isset($values[2][$ffc]))
                    $bufft3=str_replace("<v3>",$values[2][$ffc],$bufft3);
                    if(isset($values[3]) and isset($values[3][$ffd]))
                    $bufft3=str_replace("<v4>",$values[3][$ffd],$bufft3);
                    if(isset($values[4]) and isset($values[4][$ffe]))
                    $bufft3=str_replace("<v5>",$values[4][$ffe],$bufft3);
                    if(isset($values[5]) and isset($values[5][$fff]))
                    $bufft3=str_replace("<v6>",$values[5][$fff],$bufft3);
                    if(preg_match_all("/".$bufft3."/m",$buffer,$empty[3])<=0) continue;
                }

                if(!empty($false1)){
                    if(isset($values[0][$ffa]))
                    $bufft1=str_replace("<v1>",$values[0][$ffa],$false1);
                    if(isset($values[1]) and isset($values[1][$ffb]))
                    $bufft1=str_replace("<v2>",$values[1][$ffb],$bufft1);
                    if(isset($values[2]) and isset($values[2][$ffc]))
                    $bufft1=str_replace("<v3>",$values[2][$ffc],$bufft1);
                    if(isset($values[3]) and isset($values[3][$ffd]))
                    $bufft1=str_replace("<v4>",$values[3][$ffd],$bufft1);
                    if(isset($values[4]) and isset($values[4][$ffe]))
                    $bufft1=str_replace("<v5>",$values[4][$ffe],$bufft1);
                    if(isset($values[5]) and isset($values[5][$fff]))
                    $bufft1=str_replace("<v6>",$values[5][$fff],$bufft1);

                    if(0<preg_match_all("/".$bufft1."/m",$buffer,$empty[4])) continue;
                }

                if(!empty($false2)){
                    if(isset($values[0][$ffa]))
                    $bufft2=str_replace("<v1>",$values[0][$ffa],$false2);
                    if(isset($values[1]) and isset($values[1][$ffb]))
                    $bufft2=str_replace("<v2>",$values[1][$ffb],$bufft2);
                    if(isset($values[2]) and isset($values[2][$fff]))
                    $bufft2=str_replace("<v3>",$values[2][$fff],$bufft2);
                    if(isset($values[3]) and isset($values[3][$ffd]))
                    $bufft2=str_replace("<v4>",$values[3][$ffd],$bufft2);
                    if(isset($values[4]) and isset($values[4][$ffe]))
                    $bufft2=str_replace("<v5>",$values[4][$ffe],$bufft2);
                    if(isset($values[5]) and isset($values[5][$fff]))
                    $bufft2=str_replace("<v6>",$values[5][$fff],$bufft2);

                    if(0<preg_match_all("/".$bufft2."/m",$buffer,$empty[5])) continue;

                }

                if(!empty($false3)){
                    if(isset($values[0][$ffa]))
                    $bufft3=str_replace("<v1>",$values[0][$ffa],$false3);
                    if(isset($values[1]) and isset($values[1][$ffb]))
                    $bufft3=str_replace("<v2>",$values[1][$ffb],$bufft3);
                    if(isset($values[2]) and isset($values[2][$fff]))
                    $bufft3=str_replace("<v3>",$values[2][$fff],$bufft3);
                    if(isset($values[3]) and isset($values[3][$ffd]))
                    $bufft3=str_replace("<v4>",$values[3][$ffd],$bufft3);
                    if(isset($values[4]) and isset($values[4][$ffe]))
                    $bufft3=str_replace("<v5>",$values[4][$ffe],$bufft3);
                    if(isset($values[5]) and isset($values[5][$fff]))
                    $bufft3=str_replace("<v6>",$values[5][$fff],$bufft3);

                    if(0<preg_match_all("/".$bufft3."/m",$buffer,$empty[6])) continue;
                }

                $log->add("[RE] Watch lines: ".$nrlini);
                $log->add("[RE] ".print_r(extractarray($empty), true));

                array_push($tablica_z_wynikami,array('file' => $name, 'file_line' => $nrlini, 'array' => base64_encode(print_r(extractarray($empty), true))));
                flush();
            }
        }


    }

    function opend($dir){
        global $log;
        global $searchext;

        if(!($dir[strlen($dir)-1]=='/')){
            $dir=$dir."/";
        } 
        $arr=array();

        $log->add("[TO] Try open dir: ".$dir);
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false){
                if(is_dir($dir.$file) or preg_match("/.*\.(?:".$searchext.")$/m",$file)){
                    $arr[]=$dir.$file;
                }

            }
            closedir($dh);
        }

        return $arr;
    }


    function badaj($name){

        global $tablica_z_wynikami;
        global $searchext;
        global $log;
        
        for($count=0; $count<count($name); $count++){
            if($name[$count][strlen($name[$count])-1]=='.') continue;
            
            $regexpat="/.*\.(?:".$searchext.")$/m";
            
            if(is_file($name[$count]) and preg_match($regexpat,$name[$count],$ppemtp)) {
                scanfile($name[$count]);
                continue;
            }	

            if(is_dir($name[$count])){
                flush();
                badaj(opend($name[$count]));	
            }
        }

        return $tablica_z_wynikami;

    }

    $dateux=date("U");

    $tablica_z_wynikami=badaj(opend($katalog));
    $outRes=(json_encode($tablica_z_wynikami));
    echo $outRes;
    
    if($writeToDb==true){
            $log->add("[DB] Start storing result in db \n");
        
            $pattern = "{
\"v1\":\"".stripJsSlash($value1)."\",
\"v2\":\"".stripJsSlash($value2)."\",
\"v3\":\"".stripJsSlash($value3)."\",
\"t1\":\"".stripJsSlash($true1)."\",
\"t2\":\"".stripJsSlash($true2)."\",
\"t3\":\"".stripJsSlash($true3)."\",
\"f1\":\"".stripJsSlash($false1)."\",
\"f2\":\"".stripJsSlash($false2)."\",
\"f3\":\"".stripJsSlash($false3)."\"
}";
        
        $logsTodb='';
        $haszz = md5($outRes).md5($katalog.$searchext);

        $logsTodb .= "===========================================================\n";
        $logsTodb .= "Scan Name: ".$resultName."\n";
        if($filtrName)
        $logsTodb .= "Filtr Name: ".$filtrName."\n";
        if($filtrDesciption)
        $logsTodb .= "Description: ".$filtrDesciption."\n";
        $logsTodb .= "\nFiles: ".$searchext."\n";
        $logsTodb .= "Directory: ".$katalog."\n";

        if($filtrId)
        $logsTodb .= "\nFiltr Id: ".$filtrId."\n";
        if($filtrId AND $filtrName)
            $logsTodb .= "Filtr URL: ".$url_config."database.php?q=".urlencode($filtrName)."\n";
        
        $logsTodb .= "\nDate: ".date("Y/m/d H:i:s", $dateux)."\n";
        $logsTodb .= "Started by: ".$credit."\n";
        $logsTodb .= "===========================================================\n";
        $logsTodb .= "Results: ".count($tablica_z_wynikami)."\n";
        $logsTodb .= "Show result: ".$url_config."schedule.php?q=".urlencode($resultName)."\n";
        $logsTodb .= "===========================================================\n";
        $logsTodb .= "Hash result: ".$haszz."\n";
        $logsTodb .= "ErrorLog: ".$tempnam."\n";
        $logsTodb .= "==================== Patterns in JSON ====================\n";
        $logsTodb .=$pattern."\n";
        $logsTodb .= "===================== EXECUTION LOG =====================\n";
        $logsTodb .= addslashes($log->printOut());
        $logsTodb .= "\n\n===================== REGEX ERROR LOG =====================\n";
        $logsTodb .= $tempnam."\n";
        $logsTodb .= "\n===========================================================";
        
        if($searchext=='.*') $searchext='*';

            $dbLink->insertSql("INSERT INTO `cifrex_results` (`result_id`, `name`, `date`, `path`, `files`, `filtr`, `hasz`, `credit`, `count_result`) VALUES (NULL, '".addslashes($resultName)."', '".$dateux."', '".addslashes($katalog)."','".addslashes($searchext)."', '".($pattern)."', '".$haszz."', '".addslashes($credit)."', '".count($tablica_z_wynikami)."');");
            $new_filtr_id = $dbLink->lastInsert;
            $dbLink->insertSql("INSERT INTO `cifrex_results_details` (`result_id`, `result`, `debug_log`) VALUES ('".intval($new_filtr_id)."', '".$outRes."', '".base64_encode(($saveLog) ? $logsTodb : '')."');");
            $log->add("[DB] Stored as a id#".$new_filtr_id." \n");

     if(!empty($email)){
        $subject = "[QuickScan] ".$resultName." (".date("Y/m/d H:i:s", $dateux).")";
        $header = "From: ". $cconfig['mail']['Name'] . " <" . $cconfig['mail']['email'] . ">\r\n";
        
        $outemail = "===========================================================\n";   
        $outemail .= "====================== cIFrex QuickScan ======================\n";   
        $outemail.=$logsTodb."\n";       
        $outemail .= "===========================================================\n";      
        $outemail .= "===========================================================\n";
        $outemail.="Best Regards,\n".$cconfig['mail']['Name']." [ visit http://cifrex.org ]\n";    
  
        @mail($email, $subject, $outemail, $header);
    }
        
    }
    unset($tablica_z_wynikami);
}

?>