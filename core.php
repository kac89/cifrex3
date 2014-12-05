<?php
header('Content-Type: application/json');
if(isset($_POST['trythispatterns'])){
    
if(isset($_SESSION['ext']))unset($_SESSION['ext']);

$searchext='';
if(isset($_POST['jin']) AND $_POST['jin']==1){ if(!empty($searchext)) $searchext.='|'; $searchext.='java|jsp';$_SESSION['ext'] = 1; }
if(isset($_POST['phpin']) AND $_POST['phpin']==1){ if(!empty($searchext)) $searchext.='|'; $searchext.='php';$_SESSION['ext'] = 2; }
if(isset($_POST['cin']) AND $_POST['cin']==1){ if(!empty($searchext)) $searchext.='|'; $searchext.='c|cpp|cc|h';$_SESSION['ext'] = 3; }
if(isset($_POST['perlin']) AND $_POST['perlin']==1){ if(!empty($searchext)) $searchext.='|'; $searchext.='pl';$_SESSION['ext'] = 4; }
if(isset($_POST['writeotherin']) AND $_POST['writeotherin']==1 AND !empty($_POST['otherexin'])){ if(!empty($searchext)) $searchext.='|'; $searchext.=$_POST['otherexin'];$_SESSION['ext'] = $_POST['otherexin']; }

if(isset($_POST['allin']) AND $_POST['allin']==1) $searchext='.*';


$tablica_z_wynikami = array();
// Initial GPC
if( (version_compare(PHP_VERSION, '5.4.0') == -1) AND (ini_get('magic_quotes_gpc')=="1") ){
	foreach($_GET as $key => $val)
		$_GET[$key]=stripslashes($val);

	foreach($_POST as $key => $val)
		$_POST[$key]=stripslashes($val);
}

if(empty($default_openbasedir)) $default_openbasedir=$default_directory;

// Initial values
// [V1,V2,V3] Value
if(!empty($_GET['value1'])) $value1=$_GET['value1']; else if(!empty($_POST['value1'])) $value1=$_POST['value1']; else $value1="";
if(!empty($_GET['value2'])) $value2=$_GET['value2']; else if(!empty($_POST['value2'])) $value2=$_POST['value2']; else $value2="";
if(!empty($_GET['value3'])) $value3=$_GET['value3']; else if(!empty($_POST['value3'])) $value3=$_POST['value3']; else $value3="";

// [T1,T2,T3] True
if(!empty($_GET['true1'])) $true1=$_GET['true1']; else if(!empty($_POST['true1'])) $true1=$_POST['true1']; else $true1="";
if(!empty($_GET['true2'])) $true2=$_GET['true2']; else if(!empty($_POST['true2'])) $true2=$_POST['true2']; else $true2="";
if(!empty($_GET['true3'])) $true3=$_GET['true3']; else if(!empty($_POST['true3'])) $true3=$_POST['true3']; else $true3="";

// [F1,F2,F3] False
if(!empty($_GET['false1'])) $false1=$_GET['false1']; else if(!empty($_POST['false1'])) $false1=$_POST['false1']; else $false1="";
if(!empty($_GET['false2'])) $false2=$_GET['false2']; else if(!empty($_POST['false2'])) $false2=$_POST['false2']; else $false2="";
if(!empty($_GET['false3'])) $false3=$_GET['false3']; else if(!empty($_POST['false3'])) $false3=$_POST['false3']; else $false3="";

if(isset($_POST['silent'])) $silent=true; else $silent=false;
if(isset($_POST['katalog'])) $_SESSION['katalog'] = $_POST['katalog'];

// Initial Directory 
if(!empty($_GET['katalog']) AND 0>=strncmp($default_openbasedir, $_POST['katalog'], strlen($default_openbasedir))) $katalog=$_GET['katalog']; 
elseif(!empty($_POST['katalog']) AND 0>=strncmp($default_openbasedir, $_POST['katalog'], strlen($default_openbasedir))) $katalog=$_POST['katalog']; 
else $katalog=$default_directory;

//title
$title='cIFrex 3.0 Regular Expression SwA';

$katalog=str_replace("../","/",str_replace("/..","/",$katalog));
$acc=$katalog;
/*
if(is_dir('include')==false){
die("Can't find /include folder. Error");
}
*/
    
if(isset($_POST['savefilterpost']) AND isset($_POST['nazwafiltra']) AND $_POST['savefilterpost']=="ok"){
    $nazwafiltra = urldecode($_POST['nazwafiltra']);
	$filter = '<?xml version="1.0" encoding="UTF-8"?>
    <filter>
    <author></author>
    <env></env>
    <cwe></cwe>
    <v1>'.htmlspecialchars($_POST['v1'], ENT_QUOTES).'</v1>
    <v2>'.htmlspecialchars($_POST['v2'], ENT_QUOTES).'</v2>
    <v3>'.htmlspecialchars($_POST['v3'], ENT_QUOTES).'</v3>
    <t1>'.htmlspecialchars($_POST['t1'], ENT_QUOTES).'</t1>
    <t2>'.htmlspecialchars($_POST['t2'], ENT_QUOTES).'</t2>
    <t3>'.htmlspecialchars($_POST['t3'], ENT_QUOTES).'</t3>
    <f1>'.htmlspecialchars($_POST['f1'], ENT_QUOTES).'</f1>
    <f2>'.htmlspecialchars($_POST['f2'], ENT_QUOTES).'</f2>
    <f3>'.htmlspecialchars($_POST['f3'], ENT_QUOTES).'</f3>
    </filter>';
    file_put_contents(getcwd()."/Filters/".$nazwafiltra.".xml", $filter, LOCK_EX);
}




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
		else $tab[$no] = ltrim(htmlspecialchars($val, ENT_QUOTES));
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

	global $value1,$value2,$value3;
	global $true1,$true2,$true3;
	global $false1,$false2,$false3;
	global $silent;
    global $tablica_z_wynikami;

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
						
			

            array_push($tablica_z_wynikami,array('file' => $name, 'file_line' => $nrlini, 'array' => base64_encode(print_r(extractarray($empty), true))));
           
			flush();
		}
	}
    

}

function opend($dir){
	global $searchext;
    
	if(!($dir[strlen($dir)-1]=='/')){
		$dir=$dir."/";
	} 
	$arr=array();
	
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false){
			if(is_dir($dir.$file) or preg_match("/.*\.(?:".$searchext.")$/m",$file))
				$arr[]=$dir.$file;
	
		}
		closedir($dh);
	}
	
	return $arr;
}


function badaj($name){

    global $tablica_z_wynikami;
	global $acc,$searchext,$silent;
	for($count=0; $count<count($name); $count++){
		if($name[$count][strlen($name[$count])-1]=='.') continue;

		if(is_file($name[$count]) and preg_match("/.*\.(?:".$searchext.")$/m",$name[$count],$ppemtp)) {
			scanfile($name[$count]);
			continue;
		}	

		if(is_dir($name[$count])){
			if(!$silent){
                array_push($tablica_z_wynikami,array('file' => $name[$count], 'file_line' => null, 'array' => null));
            }
			flush();
			badaj(opend($name[$count]));	
		}
	}
    
	return $tablica_z_wynikami;
	
}


    $tablica_z_wynikami=badaj(opend($katalog));
    echo json_encode($tablica_z_wynikami);
    unset($tablica_z_wynikami);
}
?>