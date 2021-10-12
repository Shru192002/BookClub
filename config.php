<?php
/*these file contains database assming yo are running mysql using user"root" & password ""*/
define ('DB_SERVER','localhost');
define ('DB_USERNAME','root');
define ('DB_PASSWORD','');
define ('DB_NAME','login');
//trying connecting to database
$conn =mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
//checking connection
if ($conn==false)
{
    dir('Error;cannot connect');
}

 ?>