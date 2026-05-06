<?php

/**
 * User — maps one row in the `users` table (a single User record).
 */
class User extends BaseModel{
	
	// Table and class name used by BaseModel find / persistence helpers
	const tableName = 'users';
	const className = 'User';
	
	// User field accessors
	
	public function getName() {
		return $this->getField('name');
	}
	
	public function getEmail() {
		return $this->getField('email');
	}
	
	public function getCity() {
		return $this->getField('city');
	}

	public function getPhone() {
		return $this->getField('phone');
	}

	/**
	 * Validate this User's attributes before create or update.
	 * Returns errors keyed by attribute name.
	 */
	public function validate() {
		$name = isset($this->fields['name']) ? $this->fields['name'] : '';
		$email = isset($this->fields['email']) ? $this->fields['email'] : '';
		$city = isset($this->fields['city']) ? $this->fields['city'] : '';
		$phone = isset($this->fields['phone']) ? $this->fields['phone'] : '';

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

		if ($phone === '') {
			$errors['phone'] = 'Phone number is required.';
		} else {
			$digitCount = strlen(preg_replace('/\D/', '', $phone));
			if (mb_strlen($phone) > 20 || $digitCount < 8 || $digitCount > 15) {
				$errors['phone'] = 'Phone must be at most 20 characters and include 8 to 15 digits.';
			}
		}

		return $errors;
	}

}