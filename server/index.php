<?php
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Headers: *" );
header( "Access-Control-Allow-Methods: *" );
header( "Access-Control-Allow-Credentials: true" );
header( "Content-Type: application/json; charset=UTF-8" );

if ( empty( $_GET['q'] ) ) {
	exit();
}

require_once 'db.php';
require_once 'functions.php';

$method = $_SERVER['REQUEST_METHOD']; // получаем метод запроса

$q      = $_GET['q'];
$params = explode( '/', $q );
$type   = $params[0];
$id     = isset( $params[1] ) ? $params[1] : null;

switch ( $method ) {
	case 'GET':
		if ( $type === 'allPosts' ) { // Выборка всех записей для админки
			allPosts( $db );
		} elseif ( $type === 'getPostId' ) { // Выборка одной записи по id для админки
			getPostId( $db, $id );
		} elseif ( $type === 'getAllPostsClient' ) { // Получение всех записей для клиента
			getAllPostsClient( $db );
		} elseif ( $type === 'getPostClientById' ) { // Получение одной записи по переданному id для клиента
			if ( $id ) {
				getPostClientById( $db, $id );
			}
		} else {
			http_response_code( 400 );
			echo json_encode( [
				'message' => "По параметру: $type ничего не найдено",
			] );
		}
		break;
	case 'POST':
		if ( $type === 'usersReg' ) { // Создание пользователя / админка
			registration( $db, $_POST );
		} elseif ( $type === 'usersAut' ) { // Авторизация пользователя / админка
			autorisation( $db, $_POST );
		} else if ( $type === 'addPost' ) { // Создание записи / админка
			addPost( $db, $_POST );
		} else if ( $type === 'createComment' ) { // Создание комментария / клиент
			createComment( $db, $_POST );
		} else if ( $type === 'getCookie' ) { // Проверка куки / админка
			getCookie( $db );
		} else {
			http_response_code( 400 );
			echo json_encode( [
				'message' => "По параметру: $type ничего не найдено",
			] );
		}
		break;
	case 'PUT':
		if ( $type === 'updatePost' ) { // Обновление записи / админка
			$data = file_get_contents( 'php://input' );
			$data = json_decode( $data, true );
			updatePost( $db, $data );
		} elseif ( $type === 'updateView' ) { // Обновление счётчика просмотров записи / клиент
			$data = file_get_contents( 'php://input' );
			$data = json_decode( $data, true );
			updateView( $db, $data );
		} else {
			http_response_code( 400 );
			echo json_encode( [
				'message' => "По параметру: $type ничего не найдено",
			] );
		}
		break;
	case 'PATCH':
		if ( $type === 'deleteUserToken' ) { // Удаление токена пользователя / админка
			$data = file_get_contents( 'php://input' );
			$data = json_decode( $data, true );
			deleteUserToken( $db, $data );
		} else {
			http_response_code( 400 );
			echo json_encode( [
				'message' => "По параметру: $type ничего не найдено",
			] );
		}
		break;
	case 'DELETE':
		if ( $type === 'deletePost' ) { // Удаление записи / админка
			if ( $id ) {
				deletePost( $db, $id );
			}
		} else {
			http_response_code( 400 );
			echo json_encode( [
				'message' => "По параметру: $type ничего не найдено",
			] );
		}
		break;
	/*default:
		http_response_code( 400 );
		echo json_encode( [
			'message' => "Метод $method не найден",
		] );*/
}


































