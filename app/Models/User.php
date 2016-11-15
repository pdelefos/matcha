<?php 

namespace App\Models;

class User {

	private $login;
	private $email;
	private $nom;
	private $prenom;

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

	public function save() {
		app('db')->insert('INSERT INTO user (login, email, nom, prenom) 
			VALUES (:login, :email, :nom, :prenom)',
			[
				'login' => $this->login,
				'email' => $this->email,
				'nom' => $this->nom,
				'prenom' => $this->prenom
			]);
	}
}