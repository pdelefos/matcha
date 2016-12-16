<?php 

namespace App\Models;

use App\Models\Interest;

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
	private $localisation;
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

	public function setAnniversaire($anniversaire) {
		$this->anniversaire = $anniversaire;
	}

	public function setLocalisation($localisation) {
		$this->localisation = $localisation;
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
		if ($ret)
			return Self::getId($this->login);
		return false;
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
			anniversaire = :anniversaire,
			localisation = :localisation,
			presentation = :presentation,
			completed = :completed
			WHERE id = :id',
			[
				'sexe_id' => Sexe::getId($this->sexe),
				'orientation_sexe_id' => Orientation::getId($this->orientation),
				'anniversaire' => $this->anniversaire,
				'localisation' => $this->localisation,
				'presentation' => $this->presentation,
				'id' => $this->id,
				'completed' => true
			]);
		if ($ret)
			Self::saveInterests();
		return $ret;
	}

	static function getId($login) {
		$ret = app('db')->select('SELECT id FROM user WHERE login = :login',
		['login' => $login]);
		if ($ret)
			return $ret[0]->{'id'};
		return false;
	}

	private function saveInterests() {
		Interest::saveInterests($this->id, $this->interests);
	}

	static function getCompleted($id) {
		$ret = app('db')->select('SELECT completed FROM user WHERE id = :id',
		['id' => $id]);
		if ($ret)
			return $ret[0]->{'completed'};
		return false;
	}

	// static functions
	public static function emailExists($email) {
		$ret = app('db')->select('SELECT id FROM user WHERE email = :email',
		['email' => $email]);
		return $ret;
	}

	public static function loginExists($login) {
		$ret = app('db')->select('SELECT id FROM user WHERE login = :login',
		['login' => $login]);
		return $ret;
	}
}