<?php
define("WEBSERVER", "http://".$_SERVER["HTTP_HOST"]);
define("MAINHOST", WEBSERVER."/emapp");
define("MAINPATH",$_SERVER["DOCUMENT_ROOT"]."/emapp");
define("TIMEZONE","Asia/Dhaka");
define("CLASSDIR",MAINPATH."/classes");
define("UTILSDIR",MAINPATH."/utils");
define("CSSDIR",MAINHOST."/css");
define("JSDIR",MAINHOST."/js");
define("TEMPLATEDIR",MAINPATH."/template");
define("IMAGEFOLDER",MAINHOST."/images");
define("PAGINATIONRPP",50);
//list($scriptPath) = get_included_files();
//echo $scriptPath;
?>
