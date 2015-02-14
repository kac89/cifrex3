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

class debugMe
{
    public $debug=false;
    private $debug_type_allowed=array('standard', 'string');
    public $debug_type='standard';
    private $output='';

    public function __construct($type){
        if(in_array($type,$this->debug_type_allowed))
            $this->debug_type=$type;
        else 
        {
            print_r($debug_type_allowed);
            die("Debug type error! Use allowed");
        }
    }
    
    public function add($txt){
        if($this->debug_type=='standard'){
            echo $txt."\n";   
        }
        $this->output .= $txt."\n";  
    }
    
    public function printOut(){
        return $this->output;
    }
}

?>