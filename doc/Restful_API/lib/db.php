<?php
	$dsn="mysql:host=localhost;dbname=api";
	$dpo = new PDO($dsn,'root','root');
	return $dpo;

