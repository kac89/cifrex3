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

class ErrorMe
{
    public $destination;

    function __constructor(){
        error_reporting(E_ALL);
        $tempnam = tempnam("./tmp/", "SCAN");
        ini_set('log_errors', '1'); 
        ini_set('display_errors', 0);
        $temp = fopen($tempnam, "w");
        fclose($temp);
        ini_set('error_log', $tempnam); 
    }
}

?>