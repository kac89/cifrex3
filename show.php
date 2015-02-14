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

if(isset($_GET['show']) AND !empty($_GET['show']) AND is_string($_GET['show'])){
	
	$_GET['show']=str_replace("../","/",str_replace("/..","/",$_GET['show']));
    
	if(is_file($_GET['show']) AND 0==strncmp($cconfig['core']['internal_openbasedir'], $_GET['show'], strlen($cconfig['core']['internal_openbasedir']))){
		$handle = fopen($_GET['show'], "r");
		$buffer="";
	    $title=explode("/", $_GET['show']);
        $title = $title[(count($title)-1)];
		
		if ($handle){
			while (!feof($handle)) $buffer .= htmlentities(fgets($handle, 4096));
            
            $rozszez = explode('.', $_GET['show']);
            
            $ext_crush = 'shBrushJScript';$brush = 'js';
            if(!empty($rozszez[count($rozszez)-1])){
                $rozszez=$rozszez[count($rozszez)-1];
                
                if ($rozszez == 'java') {
                    $ext_crush = 'shBrushJava';$brush = 'java';
                } elseif ($rozszez == 'php') {
                    $ext_crush = 'shBrushPhp';$brush = 'php';
                } elseif ($rozszez == 'cpp' OR $rozszez == 'c') {
                    $ext_crush = 'shBrushCpp';$brush = 'cpp';
                } elseif ($rozszez == 'xml') {
                    $ext_crush = 'shBrushXml';$brush = 'xml';
                } elseif ($rozszez == 'py') {
                    $ext_crush = 'shBrushPython';$brush = 'py';
                }elseif ($rozszez == 'sql') {
                    $ext_crush = 'shBrushSql';$brush = 'sql';
                }elseif ($rozszez == 'ry') {
                    $ext_crush = 'shBrushRuby';$brush = 'ry';
                }elseif ($rozszez == 'pl') {
                    $ext_crush = 'shBrushPerl';$brush = 'pl';
                }
            }

            $high=0;
			if(isset($_GET['l'])){
				$high = htmlspecialchars($_GET['l'], ENT_QUOTES);
			}
			
			echo '<html><head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>'.$title.'</title>
			<script type="text/javascript" src="include/syntaxhighlighter/scripts/shCore.js"></script>
			<script type="text/javascript" src="include/syntaxhighlighter/scripts/'.$ext_crush.'.js"></script>
			<link type="text/css" rel="stylesheet" href="include/syntaxhighlighter/styles/shCoreDefault.css"/>
			<script type="text/javascript">
			SyntaxHighlighter.defaults["quick-code"] = false;
			SyntaxHighlighter.all();
			</script>
			</head>
			<body><pre class="brush: '.$brush.';highlight: ['.$high.']">'.$buffer.'</pre></body>
			</html>';
			die();
		} else die("<CENTER>CAN'T OPEN FILE. <P><A HREF='".$url_config."'>Back</A></CENTER>");
	} else { die("<CENTER>CAN'T OPEN FILE. <P><A HREF='".$url_config."'>Back</A></CENTER>"); }
}



?>