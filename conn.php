<?php
/**
 * Created by PhpStorm.
 * User: no one
 * Date: 3/12/2017
 * Time: 10:33 AM
 */
	$conn = new mysqli('localhost', 'root', '', 'scolarite');
	if(!$conn){
        die('Could not Connect to Database' . $conn->mysqli_error );
    }