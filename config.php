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

// Timezone
    date_default_timezone_set("CET"); 

// Common Web Settings
    $url_config = "http://127.0.0.1/cifrex31/"; // URL of cifrex
    $dir_config = "/path/to/cifrex/"; // Full path to cifrex 

// Database Config
    $cconfig['db_config']['host']="127.0.0.1";
    $cconfig['db_config']['database']="";
    $cconfig['db_config']['login']="";
    $cconfig['db_config']['password']="";

// Security
    $cconfig['core']['internal_openbasedir']='/';

// Email Sender Setting
    $cconfig['mail']['Name'] = "Robot cIFrex"; //senders name 
    $cconfig['mail']['email'] = "robot@cifrex.org"; //senders e-mail adress 

// Multithreading
// Default 1 but if you have fast disk and CPU, you can set more proceses
    $cconfig['multithreading']['cores'] = 1; // Number of processes. 

?>