<?php 

namespace App\Models;

use App\Models\Interest;
use App\Models\Orientation;
use App\Models\Geolocalisation;
use App\Models\Photo;
use App\Models\Online;

class User {

	private $id;
	private $login;
	private $email;
	private $nom;
	private $prenom;
	private $password;
	private $avatar;
	private $sexe;
	private $orientation;
	private $anniversaire;
	private $age;
	private $localisation;
	private $latitude;
	private $longitude;
	private $presentation;
	private $completed;
	private $interests = array();
	private $photos = array();

	public function __construct() {
	}

	// Enregistre un nouvel utilisateur en base
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
		self::updateLastVisit();
		if ($ret)
			return Self::getUserId($this->login);
		return false;
	}

	// Connecte un utilisateur et renvoi son ID
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

	// Enregistre les informations complementaires d'un utilisateur
	public function completeProfile() {
		$ret = app('db')->update('UPDATE user SET 
			sexe_id = :sexe_id,
			orientation_sexe_id = :orientation_sexe_id,
			anniversaire = :anniversaire,
			age = :age,
			localisation = :localisation,
			latitude = :latitude,
			longitude = :longitude,
			presentation = :presentation,
			city = :city,
			completed = :completed
			WHERE id = :id',
			[
				'sexe_id' => Sexe::getId($this->sexe),
				'orientation_sexe_id' => Orientation::getId($this->orientation),
				'anniversaire' => $this->anniversaire,
				'age' => Self::calcAge($this->anniversaire),
				'localisation' => $this->localisation,
				'latitude' => $this->latitude,
				'longitude' => $this->longitude,
				'presentation' => $this->presentation,
				'city' => Geolocalisation::getCityFromLatLng($this->getLatitude(), $this->getLongitude()),
				'id' => $this->id,
				'completed' => true
			]);
		if ($ret)
			Self::saveInterests();
		return $ret;
	}

	// Enregistre les modifications du profil de l'utilisateur
	public function updateProfile() {
		$ret = app('db')->update('UPDATE user SET 
			nom = :nom,
			prenom = :prenom,
			email = :email,
			sexe_id = :sexe_id,
			orientation_sexe_id = :orientation_sexe_id,
			anniversaire = :anniversaire,
			age = :age,
			localisation = :localisation,
			latitude = :latitude,
			longitude = :longitude,
			presentation = :presentation,
			city = :city,
			completed = :completed
			WHERE id = :id',
			[
				'nom' => $this->nom,
				'prenom' => $this->prenom,
				'email' => $this->email,
				'sexe_id' => Sexe::getId($this->sexe),
				'orientation_sexe_id' => Orientation::getId($this->orientation),
				'anniversaire' => $this->anniversaire,
				'age' => Self::calcAge($this->anniversaire),
				'localisation' => $this->localisation,
				'latitude' => $this->latitude,
				'longitude' => $this->longitude,
				'presentation' => $this->presentation,
				'city' => Geolocalisation::getCityFromLatLng($this->getLatitude(), $this->getLongitude()),
				'id' => $this->id,
				'completed' => true
			]);
		if ($ret)
			Self::saveInterests();
		return $ret;
	}

	// Enregistre le tableau d'interets de l'utilisateur en base
	private function saveInterests() {
		Interest::saveInterests($this->id, $this->interests);
	}

	public function goOnline() {
		Online::goOnline($this->id);
	}

	public function goOffline() {
		Online::goOffline($this->id);
		self::updateLastVisit();
	}

	private function updateLastVisit() {
		app('db')->update('UPDATE user SET last = :last WHERE id = :id', [
			'last' => date('d/m/Y'),
			'id' => $this->id
		]);
	}

	public function getLastVisit() {
		$ret = app('db')->select('SELECT * FROM user WHERE id = :id', [
			'id' => $this->id
		]);
		if ($ret)
			return $ret[0]->{'last'};
		return false;
	}

	public function isOnline() {
		return Online::isOnline($this->id);
	}

	public function block($blocked_id) {
		$ret = app('db')->insert('INSERT INTO block_table (asking_id, blocked_id) VALUES (:asking_id, :blocked_id)', [
			'asking_id' => $this->id,
			'blocked_id' => $blocked_id
		]);
		if ($ret)
			return true;
		return false;
	}

	public function unblock($blocked_id) {
		$ret = app('db')->delete('DELETE FROM block_table WHERE asking_id = :asking_id AND blocked_id = :blocked_id', [
			'asking_id' => $this->id,
			'blocked_id' => $blocked_id
		]);
		if ($ret)
			return true;
		return false;
	}

	public function isBlocked($blocked_id) {
		$ret = app('db')->select('SELECT * FROM block_table WHERE asking_id = :asking_id AND blocked_id = :blocked_id', [
			'asking_id' => $this->id,
			'blocked_id' => $blocked_id
		]);
		if ($ret)
			return true;
		return false;
	}

	//---------------------------------------------------------//
	// STATIC FUNCTIONS
	//---------------------------------------------------------//

	// Renvoi l'ID correspondant au login de l'utilisateur
	static function getUserId($login) {
		$ret = app('db')->select('SELECT id FROM user WHERE login = :login',
		['login' => $login]);
		if ($ret)
			return $ret[0]->{'id'};
		return false;
	}

	// Renvoi true si l'utilisateur a un profil complet
	static function getUserCompleted($id) {
		$ret = app('db')->select('SELECT completed FROM user WHERE id = :id',
		['id' => $id]);
		if ($ret)
			return $ret[0]->{'completed'};
		return false;
	}

	// Renvoi true si l'email existe
	public static function emailExists($email) {
		$ret = app('db')->select('SELECT id FROM user WHERE email = :email',
		['email' => $email]);
		return $ret;
	}

	// Renvoi true si le login existe
	public static function loginExists($login) {
		$ret = app('db')->select('SELECT id FROM user WHERE login = :login',
		['login' => $login]);
		return $ret;
	}

	// Renvoi un objet User correspondant a l'ID
	public static function getUser($user_id) {
		$ret = app('db')->select('SELECT * FROM user WHERE id = :id',
		['id' => $user_id]);
		if (!$ret)
			return false;
		$user = new User();
		$user->setId($ret[0]->{'id'});
		$user->setLogin($ret[0]->{'login'});
		$user->setEmail($ret[0]->{'email'});
		$user->setNom($ret[0]->{'nom'});
		$user->setPrenom($ret[0]->{'prenom'});
		$user->setAvatar($ret[0]->{'avatar'});
		$user->setSexe(Sexe::getDesc($ret[0]->{'sexe_id'}));
		$user->setAnniversaire($ret[0]->{'anniversaire'});
		$user->setAge($ret[0]->{'age'});
		$user->setOrientation(Orientation::getDesc($ret[0]->{'orientation_sexe_id'}));
		$user->setLocalisation($ret[0]->{'localisation'});
		$user->setLatitude($ret[0]->{'latitude'});
		$user->setLongitude($ret[0]->{'longitude'});
		$user->setCompleted($ret[0]->{'completed'});
		$user->setInterests(Interest::getUserInterest($user_id));
		$user->setPresentation($ret[0]->{'presentation'});
		$user->setPhotos(Photo::getUserPhotos($user_id));
		return $user;
	}

	// Calcule l'age a partir de la date de naissance jj/mm/aaaa
	private static function calcAge($birthday) {
		date_default_timezone_set('Europe/Paris');
		return (int) ((time() - strtotime(str_replace("/", "-", $birthday))) / 3600 / 24 / 365);
	}

	//---------------------------------------------------------//
	// SET
	//---------------------------------------------------------//
	
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

	public function setAvatar($avatar) {
		$this->avatar = $avatar;
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

	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	public function setPresentation($presentation) {
		$this->presentation = $presentation;
	}

	public function setInterests(array $interests) {
		$this->interests = $interests;
	}

	public function setPhotos(array $photos) {
		$this->photos = $photos;
	}

	public function setCompleted($completed) {
		$this->completed = $completed;
	}

	//---------------------------------------------------------//
	// GET
	//---------------------------------------------------------//

	public function getId() {
		return $this->id;
	}

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

	public function getAvatar() {
		return $this->avatar;
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

	public function getLatitude() {
		return $this->latitude;
	}

	public function getLongitude() {
		return $this->longitude;
	}

	public function getCity() {
		return Geolocalisation::getCityFromLatLng($this->getLatitude(), $this->getLongitude());
	}

	public function getPhotos() {
		return $this->photos;
	}

	public function getCompleted() {
		return $this->completed;
	}
}