<?php 

namespace App\Models;

use App\Models\Interest;
use App\Models\Orientation;

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
	private $age;
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

	public function setAge($age) {
		$this->age = $age;
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

	public function getSexe() {
		return $this->sexe;
	}

	public function getAnniversaire() {
		return $this->anniversaire;
	}

	public function getAnniversaireArray() {
		$newDate = str_replace("/", "-", $this->anniversaire);
		$array['jour'] = date("d", strtotime($newDate));
		$array['mois'] = date("m", strtotime($newDate));
		$array['annee'] = date("Y", strtotime($newDate));
		return $array;
	}

	public function getAge() {
		return $this->age;
	}

	public function getPresentation() {
		return $this->presentation;
	}

	public function getInterests() {
		return $this->interests;
	}

	public function getOrientation() {
		return $this->orientation;
	}

	public function getFuscNames() {
		return $this->prenom . " " . strtoupper($this->nom[0]) . ".";
	}

	public function getFullNames() {
		return $this->prenom . " " . $this->nom;
	}

	public function getLocalisation() {
		return $this->localisation;
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

	public static function getUser($user_id) {
		$ret = app('db')->select('SELECT * FROM user WHERE id = :id',
		['id' => $user_id]);
		$user = new User();
		$user->setId($ret[0]->{'id'});
		$user->setLogin($ret[0]->{'login'});
		$user->setEmail($ret[0]->{'email'});
		$user->setNom($ret[0]->{'nom'});
		$user->setPrenom($ret[0]->{'prenom'});
		$user->setSexe(Sexe::getDesc($ret[0]->{'sexe_id'}));
		$user->setAnniversaire($ret[0]->{'anniversaire'});
		$user->setAge(Self::calcAge($ret[0]->{'anniversaire'}));
		$user->setOrientation(Orientation::getDesc($ret[0]->{'orientation_sexe_id'}));
		$user->setLocalisation($ret[0]->{'localisation'});
		$user->setInterests(Interest::getUserInterest($user_id));
		$user->setPresentation($ret[0]->{'presentation'});
		if ($ret)
			return $user;
		return false;
	}

	private static function calcAge($birthday) {
		return (int) ((time() - strtotime($birthday)) / 3600 / 24 / 365);
	}
}