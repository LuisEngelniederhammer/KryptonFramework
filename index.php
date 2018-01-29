<?php
session_start ();

require_once 'Krypton/Router.php';
require_once 'Krypton/System.php';

$Router = new Krypton\Router ();

$Router->add ( '/page/([0-9]*)', function ($id)
{
	require_once 'Krypton/Page.php';
	new Krypton\Page ($id);
} );

$Router->add ( '/page/([0-9]*)/system', function ($id)
{
	require_once 'Krypton/Page.php';
	new Krypton\Page ($id);
	echo 'with system';
} );

$Router->run ();


?>



