<?php

/**
 * User model
 */
class User extends BaseModel{
	
	// Define neccessary constansts so we know from which table to load data
	const tableName = 'users';
	// ClassName constant is important for find and findOne static functions to work
	const className = 'User';
	
	// Create getter functions
	
	public function getName() {
		return $this->getField('name');
	}
	
	public function getEmail() {
		return $this->getField('email');
	}
	
	public function getCity() {
		return $this->getField('city');
	}

	/**
	 * Validate current user attributes.
	 * Returns errors keyed by attribute name.
	 */
	public function validate() {
		$name = isset($this->fields['name']) ? $this->fields['name'] : '';
		$email = isset($this->fields['email']) ? $this->fields['email'] : '';
		$city = isset($this->fields['city']) ? $this->fields['city'] : '';

		$errors = array();

		if ($name === '') {
			$errors['name'] = 'Name is required.';
		} elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
			$errors['name'] = 'Name must be 2 to 100 characters.';
		}

		if ($email === '') {
			$errors['email'] = 'E-mail is required.';
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Enter a valid e-mail address.';
		} elseif (mb_strlen($email) > 255) {
			$errors['email'] = 'E-mail must be 255 characters or fewer.';
		} else {
			$existingUser = self::findFirst($this->db, '*', array('email' => $email));
			if ($existingUser && $existingUser->getId() !== $this->getId()) {
				$errors['email'] = 'This e-mail is already in use.';
			}
		}

		if ($city === '') {
			$errors['city'] = 'City is required.';
		} elseif (mb_strlen($city) < 2 || mb_strlen($city) > 100) {
			$errors['city'] = 'City must be 2 to 100 characters.';
		}

		return $errors;
	}

}