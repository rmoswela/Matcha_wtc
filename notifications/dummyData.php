<?php

require_once('../config/init.php');

	$user = $conn->prepare("INSERT INTO users (firstname, lastname, email, username, passwd, active) 
		VALUES ('reuben', 'moswela', 'rmoswela@gmail.com', 'reuben21', '12345', '1')");
	$user->execute();

	$user1 = $conn->prepare("INSERT INTO users (firstname, lastname, email, username, passwd, active) 
		VALUES ('temogo', 'moswela', 'tmoswela@gmail.com', 'tmg21', '12345', '1')");
	$user1->execute();

	$user2 = $conn->prepare("INSERT INTO users (firstname, lastname, email, username, passwd, active) 
		VALUES ('poloka', 'moswela', 'pmoswela@gmail.com', 'pk21', '12345', '1')");
	$user2->execute();

	$user2 = $conn->prepare("INSERT INTO users (firstname, lastname, email, username, passwd, active) 
		VALUES ('oteng', 'moswela', 'omoswela@gmail.com', 'ot21', '12345', '1')");
	$user2->execute();

	$user3 = $conn->prepare("INSERT INTO users (firstname, lastname, email, username, passwd, active) 
		VALUES ('bone', 'moswela', 'bmoswela@gmail.com', 'bone21', '12345', '1')");
	$user3->execute();

	$user = $conn->prepare("INSERT INTO profile (user_id, gender, age, sexual_pref) 
		VALUES ('1', 'male', '27', 'women')");
	$user->execute();

	$user1 = $conn->prepare("INSERT INTO profile (user_id, gender, age, sexual_pref)
		VALUES ('2', 'male', '29', 'women')");
	$user1->execute();

	$user2 = $conn->prepare("INSERT INTO profile (user_id, gender, age, sexual_pref) 
		VALUES ('3', 'female', '23', 'male')");
	$user2->execute();

	$user2 = $conn->prepare("INSERT INTO profile (user_id, gender, age, sexual_pref) 
		VALUES ('4', 'male', '34', 'women')");
	$user2->execute();

	$user3 = $conn->prepare("INSERT INTO profile (user_id, gender, age, sexual_pref) 
		VALUES ('5', 'male', '14', 'women')");
	$user3->execute();

?>
