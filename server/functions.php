<?php

// ===================================== АДМИНСКАЯ ЧАСТЬ

// =========================== ПОЛЬЗОВАТЕЛИ

// ================ Регистрация пользователя
function registration( $db, $data ) {
	// Проверка на существование login у пользователя
	if ( getUserRegister( $db, $data['login'] ) ) {
		http_response_code( 404 );
		$res = [
			'message' => 'Такой login уже занят. Введите другой',
		];
		echo json_encode( $res, JSON_UNESCAPED_UNICODE );
		die();
	}

	// Проверяем длину пароля
	if ( strlen( $data['password'] ) < 6 ) {
		http_response_code( 404 );
		$res = [
			'message' => 'Пароль должен быть не менее 6 символов',
		];
		echo json_encode( $res, JSON_UNESCAPED_UNICODE );
		die();
	}

	// Вставка нового пользователя
	$token = bin2hex( random_bytes( 50 ) ); // создаём токен

	$sth = $db->prepare( "INSERT INTO `users` SET `login` = :login, `password` = :password, `token` = :token" );
	$sth->execute( array(
		'login'    => $data['login'],
		'password' => password_hash( $data['password'], PASSWORD_DEFAULT ),
		'token'    => $token
	) );

	// Получаем id вставленной записи пользователя
	$insert_id = $db->lastInsertId();

	if ( $insert_id ) {
		http_response_code( 201 );
		$res = [
			'id'      => $insert_id,
			'login'   => $data['login'],
			'token'   => $token,
			'message' => 'Регистрация прошла успешно',
		];
	} else {
		http_response_code( 500 );
		$res = [
			'message' => 'Ошибка при регистрации',
		];
	}

	echo json_encode( $res );
}

// Получение логина пользователя при регистрации. если находим, то пользователь не создаётся
function getUserRegister( $db, $login ) {
	$sth = $db->prepare( "SELECT login FROM `users` WHERE `login` = ?" );
	$sth->execute( array( $login ) );
	$array = $sth->fetch( PDO::FETCH_ASSOC );

	if ( $array ) {
		return true;
	} else {
		return false;
	}
}

// ================ Авторизация пользователя
function autorisation( $db, $data ) {
	$sth = $db->prepare( "SELECT id, login, password, token FROM `users` WHERE `login` = ?" );
	$sth->execute( array( $data['login'] ) );
	$array = $sth->fetch( PDO::FETCH_ASSOC );

	if ( $array ) {
		if ( password_verify( $data['password'], $array['password'] ) ) {
			$res = array_filter( $array, function ( $k ) {
				return $k !== 'password';
			}, ARRAY_FILTER_USE_KEY );

			$token = bin2hex( random_bytes( 50 ) ); // создаём токен

			if ( updateUserToken( $db, $res['id'], $token ) ) {
				$res['token'] = $token;
				echo json_encode( $res );
			} else {
				http_response_code( 500 );
				$res = [
					'message' => 'Логин / Пароль неверны',
				];
			}

			die();
		} else {
			http_response_code( 401 );
			$res = [
				'message' => 'Логин / Пароль неверны',
			];
		}
	}

	http_response_code( 401 );
	$res = [
		'message' => 'Логин / Пароль неверны',
	];

	echo json_encode( $res );
}

// Обновление токена пользователя
function updateUserToken( $db, $id, $token ) {
	$sth = $db->prepare( "UPDATE `users` SET `token` = :token WHERE `id` = :id" );
	$sth->execute( [ 'token' => $token, 'id' => $id ] );

	$errorArr = $sth->errorInfo(); // находится массив ошибок

	if ( $errorArr[2] ) {
		return false;
	} else {
		return true;
	}
}

// Удаление токена пользователя
function deleteUserToken( $db, $data ) {
	$sth = $db->prepare( "UPDATE `users` SET `token` = :token WHERE `id` = :id" );
	$sth->execute( [ 'token' => '', 'id' => $data['id'] ] );

	$errorArr = $sth->errorInfo(); // находится массив ошибок

	if ( $errorArr[2] ) {
		return false;
	} else {
		return true;
	}
}

// Проверка куки
function getCookie( $db ) {
	$data = json_decode( file_get_contents( "php://input" ), true );

	$sth = $db->prepare( "SELECT id, login, token FROM `users` WHERE `token` = ?" );
	$sth->execute( array( $data['token'] ) );
	$array = $sth->fetch( PDO::FETCH_ASSOC );

	if ( $array ) {
		$res = $array;
	} else {
		http_response_code( 401 );
		$res = [
			'message' => 'Авторизуйтесь',
		];
	}

	echo json_encode( $res );
}

// =========================== /ПОЛЬЗОВАТЕЛИ


// ======================== СОЗДАНИЕ НОВОЙ ЗАПИСИ

// Загрузка изображений записи
function upload() {
	if ( ! empty( $_FILES['image']['tmp_name'] ) ) {
		$test      = explode( '.', $_FILES['image']['name'] ); // получаем отдельно имя и расширение
		$nameFile  = $test[0]; // выбираем имя файла
		$extension = end( $test ); // выбираем расширение файла
		$name      = $nameFile . time() . '.' . $extension; // даём новое название файла

		$uploaddir  = "images/"; // это папка куда загрузится изображение. Нужно в заранее создать
		$uploadfile = $uploaddir . basename( $name ); // basename защищаем

		// Загружаем
		if ( ! move_uploaded_file( $_FILES['image']['tmp_name'], $uploadfile ) ) {
			return false;
		} else {
			return $uploadfile;
		}
	}
}

// Создание записи
function addPost( $db, $data ) {
	if ( ! $urlImg = upload() ) {
		http_response_code( 500 );
		$res = [ 'message' => 'Изображение не загрузилось' ];
		echo json_encode( $res );
		die();
	}

	$sth = $db->prepare( "INSERT INTO `posts` SET title = :title, text = :text, imageUrl = :imageUrl" );
	$sth->execute( [
		'title'    => $data['title'],
		'text'     => $data['text'],
		'imageUrl' => "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/$urlImg"
	] );

	// Получаем id вставленной записи
	$insert_id = $db->lastInsertId();

	if ( $insert_id ) {
		http_response_code( 201 );
		$res = [
			'id' => $insert_id
		];
	} else {
		http_response_code( 404 );
		$res = [
			'message' => 'Запись не создана'
		];
	}

	echo json_encode( $res );
}

// Выборка всех записей
function allPosts( $db ) {
	// Подготовленный запрос
	/*$stmt = $db->prepare( "SELECT posts.*, COUNT(comments.id_post) AS comments FROM posts LEFT JOIN comments ON comments.id_post = posts.id GROUP BY posts.id ORDER BY date DESC" );
	$stmt->execute();
	$posts = $stmt->fetchAll( PDO::FETCH_ASSOC );
	echo json_encode( $posts, JSON_UNESCAPED_UNICODE );*/

	// Прямой запрос
	$stmt  = $db->query( "SELECT posts.*, COUNT(comments.id_post) AS comments FROM posts LEFT JOIN comments ON comments.id_post = posts.id GROUP BY posts.id ORDER BY date DESC" );
	$posts = $stmt->fetchAll( PDO::FETCH_ASSOC );
	echo json_encode( $posts );
}

// Удаление записи
function deletePost( $db, $id ) {
	$sth = $db->prepare( "DELETE FROM `posts` WHERE `id` = :id" );
	$sth->execute( array( 'id' => $id ) );

	$res = [
		'message' => 'Запись удалена'
	];

	echo json_encode( $res );
}

// Обновление записи
function updatePost( $db, $data ) {
	$sth = $db->prepare( "UPDATE `posts` SET `text` = :text WHERE `id` = :id" );
	$sth->execute( array( 'text' => $data['text'], 'id' => $data['id'] ) );

	http_response_code( 200 );

	$res = [
		'message' => 'Запись обновлена'
	];

	echo json_encode( $res );
}

// Выборка одной записи по id
function getPostId( $db, $id ) {
	$sth = $db->prepare( "SELECT * FROM `posts` WHERE `id` = ?" );
	$sth->execute( array( $id ) );
	$array = $sth->fetch( PDO::FETCH_ASSOC );

	if ( ! $array ) {
		http_response_code( 404 );
		$res = [
			'message' => 'Статья не найдена'
		];
	} else {
		$res = $array;
	}

	echo json_encode( $res );
}

// ======================== /СОЗДАНИЕ НОВОЙ ЗАПИСИ


// ===================================== КЛИЕНТСКАЯ ЧАСТЬ

// Получение всех записей
function getAllPostsClient( $db ) {
	$sth = $db->prepare( "SELECT posts.*, COUNT(comments.comment) as comments FROM posts LEFT JOIN comments ON posts.id = comments.id_post GROUP BY posts.id ORDER BY date DESC" );
	$sth->execute();
	$array = $sth->fetchAll( PDO::FETCH_ASSOC );
	echo json_encode( $array );
}

// Получение одной записи по переданному id
function getPostClientById( $db, $id ) {
	// Выбор статьи
	$sthPost = $db->prepare( "SELECT * FROM posts WHERE $id = posts.id" );
	$sthPost->execute( array( $id ) );
	$post = $sthPost->fetch( PDO::FETCH_ASSOC );

	// Выбор комментариев к статье
	$sthComments = $db->prepare( "SELECT * FROM comments WHERE $id = comments.id_post ORDER BY date DESC" );
	$sthComments->execute( array( $id ) );
	$comments = $sthComments->fetchAll( PDO::FETCH_ASSOC );

	if ( ! $post ) {
		http_response_code( 404 );
		$res = [
			'message' => 'Статья не найдена'
		];

	} else {
		$res = [ 'post' => $post, 'comments' => $comments ];
	}

	echo json_encode( $res, JSON_UNESCAPED_UNICODE );
}

// Обновление счётчика просмотров записи
function updateView( $db, $data ) {
	$sth = $db->prepare( "UPDATE `posts` SET `views` = {$data['view']} WHERE `id` = ?" );
	$sth->execute( [ $data['id'] ] );

	$errorArr = $sth->errorInfo(); // ошибки
	$count    = $sth->rowCount(); // количество затронутых строк

	if ( $errorArr[2] ) {
		http_response_code( 500 );
		$res = [
			'message' => $errorArr[2]
		];
		echo json_encode( $res );
	} elseif ( ! $count ) {
		http_response_code( 404 );
		$res = [
			'message' => 'Ноль записей обновлено'
		];
		echo json_encode( $res, JSON_UNESCAPED_UNICODE );
	}
}

// Создание комментариев
function createComment( $db, $data ) {
	$sth = $db->prepare( "INSERT INTO `comments` SET name = :name, comment = :comment, id_post = :id_post" );
	$sth->execute( [
		'name'    => $data['name'],
		'comment' => $data['comment'],
		'id_post' => $data['id_post'],
	] );

	// Получаем id вставленной записи
	$insert_id = $db->lastInsertId();

	if ( $insert_id ) {
		http_response_code( 201 );
		$res = [
			'id'      => $insert_id,
			'message' => 'Комментарий добавлен'
		];
	} else {
		http_response_code( 404 );
		$res = [
			'message' => 'Комментарий не добавлен'
		];
	}

	echo json_encode( $res );
}























