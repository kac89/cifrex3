<?php

$shortopts = "k:";  // Required value
$shortopts .= "s::"; // Optional value

$longopts  = array(
    "filter:",     // Required value
    "ext:",
);
$options = getopt($shortopts, $longopts);

echo $options['k'];
echo $options['ext'];
echo $options['filter'];

//var_dump($options);





//cifrex_cli.php -k "/Library/WebServer/Documents/" --ext "php" --filter "asdasd" -s 

?>