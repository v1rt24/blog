<?php
try {
	$db = new PDO( 'mysql:dbname=nuxt-blog;host=localhost', 'root', '', array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'" ) );
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}