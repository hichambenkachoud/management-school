<?php
/**
 * Created by PhpStorm.
 * User: no one
 * Date: 3/12/2017
 * Time: 10:49 PM
 */
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
header("location:index.php");
//AIzaSyCJvMnTmEnzUN5_Jh5_a01n9r8vP0CKdlA