<?php



if(isset($_GET['show']) AND !empty($_GET['show']) AND is_string($_GET['show'])){

	if(strncasecmp(PHP_OS, 'WIN', 3) == 0) {
		if(empty($_SESSION['katalog'])){
			$default_openbasedir = 'C:/';
		}else{
			$default_openbasedir = $_SESSION['katalog'];
		}
	}
	
	$_GET['show']=str_replace("../","/",str_replace("/..","/",$_GET['show']));
	
	if(is_file($_GET['show']) AND 0==strncmp($default_openbasedir, $_GET['show'], strlen($default_openbasedir))){
		$handle = fopen($_GET['show'], "r");
		$buffer="";
		
		if ($handle){
			while (!feof($handle)) $buffer .= htmlentities(fgets($handle, 4096));
			if(empty($_SESSION['ext'])) $id = 'js'; else $id = $_SESSION['ext'];
			if ($id == 1) {
				$ext_crush = 'shBrushJava';$brush = 'java';
			} elseif ($id == 2) {
				$ext_crush = 'shBrushPhp';$brush = 'php';
			} elseif ($id == 3) {
				$ext_crush = 'shBrushCpp';$brush = 'cpp';
			} elseif ($id == 4) {
				$ext_crush = 'shBrushPerl';$brush = 'perl';
			}else{
				$ext_crush = 'shBrushJScript';$brush = 'js';
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
		} else die("<CENTER>CAN'T OPEN FILE. <P><A HREF='http://".htmlspecialchars($_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"])."'>Back</A></CENTER>");
	} else { die("<CENTER>CAN'T OPEN FILE. <P><A HREF='http://".htmlspecialchars($_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"])."'>Back</A></CENTER>"); }
}



?>