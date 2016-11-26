<?php 

namespace App\Models;

class User {

	private $login;
	private $email;
	private $nom;
	private $prenom;
	private $password;

	public function __construct() {
	}

	// set

	public function setLogin($login) {
		$this->login = $login;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	public function setPrenom($prenom) {
		$this->prenom = $prenom;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	// get

	public function getLogin() {
		return $this->login;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getNom() {
		return $this->nom;
	}

	public function getPrenom() {
		return $this->prenom;
	}

	//save on db

	public function register() {
		app('db')->insert('INSERT INTO user (login, email, nom, prenom, password) 
			VALUES (:login, :email, :nom, :prenom, :password)',
			[
				'login' => $this->login,
				'email' => $this->email,
				'nom' => $this->nom,
				'prenom' => $this->prenom,
				'password' => $this->password
			]);
	}

	// static functions

	public static function emailExists($email) {
		$ret = app('db')->select('SELECT id FROM user WHERE email = :email', ['email' => $email]);
		if ($ret)
			return true;
		return false;
	}

	public static function loginExists($login) {
		$ret = app('db')->select('SELECT id FROM user WHERE login = :login', ['login' => $login]);
		if ($ret)
			return true;
		return false;
	}
}