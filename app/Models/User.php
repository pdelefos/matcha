<?php 

namespace App\Models;

class User {

	private $id;
	private $login;
	private $email;
	private $nom;
	private $prenom;
	private $password;
	private $sexe;
	private $orientation;
	private $anniversaire;
	private $adresse;
	private $presentation;
	private $interests = array();

	public function __construct() {
	}

	// set
	public function setId($id) {
		$this->id = $id;
	}

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

	public function setSexe($sexe) {
		$this->sexe = $sexe;
	}

	public function setOrientation($orientation) {
		$this->orientation = $orientation;
	}

	public function setAdresse($adresse) {
		$this->adresse = $adresse;
	}

	public function setPresentation($presentation) {
		$this->presentation = $presentation;
	}

	public function setInterests(array $interests) {
		$this->interests = $interests;
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
		$ret = app('db')->insert('INSERT INTO user (login, email, nom, prenom, password) 
			VALUES (:login, :email, :nom, :prenom, :password)',
			[
				'login' => $this->login,
				'email' => $this->email,
				'nom' => $this->nom,
				'prenom' => $this->prenom,
				'password' => $this->password
			]);
	}

	//login
	public function login() {
		$ret = app('db')->select('SELECT id FROM user WHERE login = :login AND password = :password',
			[
				'login' => $this->login,
				'password' => $this->password
			]);
		if ($ret)
			return $ret[0]->{'id'};
		return false;
	}

	public function completeProfile() {
		$ret = app('db')->update('UPDATE user SET 
			sexe_id = :sexe_id,
			orientation_sexe_id = :orientation_sexe_id,
			presentation = :presentation
			WHERE id = :id', //ajouter date de naissance en base
			[
				'sexe_id' => Sexe::getId($this->sexe),
				'orientation_sexe_id' => Orientation::getId($this->orientation),
				'presentation' => $this->presentation,
				'id' => $this->id
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