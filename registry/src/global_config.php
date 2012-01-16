<?php
/*
Copyright 2012 The Australian National University
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/
/*======================================
	- Modify This File
	- And the .htaccess file inside the RDA folder
======================================*/

/*====================================
	LOCAL WEB SERVER ENVIRONMENT
====================================*/
$host 			= 'devl.ands.org.au';
$cosi_root 		= 'workareas/minh/ands/registry/src';
$orca_root 		= $cosi_root.'/orca';
$rda_root 		= $orca_root.'/rda';

//======================================
$solr_url 		= 'http://devl.ands.org.au:8080/solr/';
$harvester_ip 	= '';
$pids_uri		= "https://devl.ands.org.au:8443/pids/";
$pids_fid 		= '';


//======================================
$deploy_as		= 'PROD';
$debug 			= false;
$error 			= false;
$maintenance 	= false;

//White List IP are IPs that are allowed to access the system regardless of maitenance status
$white_list_ip 	= array(
	'xx.xx.xx.xx'
);
//Black List IP are IPs that are not allowed to access the system
$black_list_ip 	= array();


if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
$ip=$_SERVER["HTTP_CLIENT_IP"];
} else if ( isset($_SERVER["REMOTE_ADDR"]) )    {
$ip=$_SERVER["REMOTE_ADDR"];
} 
	
if($maintenance & !in_array($ip, $white_list_ip)){
	print("<html><body>");
	print("<center><div style='border:1px solid #C7D7BA; width:400px;'>");
	print("<img src='http://ands2.anu.edu.au:8080/ands_logo_white.jpg' width='60%' border='0'>");
	print("<h3 style='font-family:\"Lucida Grande\", Verdana, Lucida, Helvetica'>Under maintenance, please check back later.</h3>");
	print("</div></center>");
	exit;	
}


/*====================================
	DATABASE ENVIRONMENT
====================================*/
$cosi_db_host = 'devl.ands.org.au';
$cosi_db_name = 'dbs_work_leo_cosi_2';
//======================================
$orca_db_host = $cosi_db_host;
$orca_db_name = 'dbs_work_leo_orca_2';
//======================================
$pids_db_host = $cosi_db_host;
$pids_db_name = 'pids';
//======================================
$dois_db_host = $cosi_db_host;
$dois_db_name = 'dois';
//======================================
?>