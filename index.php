<?php
session_start ();

require_once 'Krypton/Router.php';

$Router = new Krypton\Router ();

$Router->add ( '/page/([0-9]*)', function ($id)
{
	require_once 'Krypton/Page.php';
	new Krypton\Page ();
} );

$Router->run ();


?>



