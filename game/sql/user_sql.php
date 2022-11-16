<?php
class UserSQL {
	public static function insertUser($user) {
		$username = $user->getUsername();
		$group = $user->getGroup();
		$firstname = $user->getFirstname();
		$lastname = $user->getLastname();
		$birth = $user->getBirth();
		$address = $user->getAddress();
		$phone = $user->getPhone();
		$email = $user->getEmail();

		$sql = "INSERT INTO `user`(username, `group`, firstname, lastname, birth, address, phone, email)
				VALUES ('$username', '$group', '$firstname', '$lastname', '$birth', '$address', '$phone', '$email')";

		execute($sql);
	}

	public static function insertUserPermission($userPermission) {
		$username = $userPermission->getUsername();
		$permission = $userPermission->getPermission();
		$value = $userPermission->getValue();

		$sql = "INSERT INTO user_permission(username, permission, value)
				VALUES ('$username', '$permission', '$value')";

		execute($sql);
	}

	public static function updateUser($user) {
		$username = $user->getUsername();
		$group = $user->getGroup();
		$firstname = $user->getFirstname();
		$lastname = $user->getLastname();
		$birth = $user->getBirth();
		$address = $user->getAddress();
		$phone = $user->getPhone();
		$email = $user->getEmail();

		$sql = "UPDATE user
				SET `group`='$group', firstname='$firstname', lastname='$lastname', birth='$birth', address='$address', phone='$phone', email='$email'
				WHERE username='$username'";

		execute($sql);
	}

	public static function updateUserPermission($userPermission) {
		$id = $userPermission->getId();
		$username = $userPermission->getUsername();
		$permission = $userPermission->getPermission();
		$value = $userPermission->getValue();

		$sql = "UPDATE user_permission
				SET username='$username', permission='$permission', value=$value
				WHERE id=$id";

		execute($sql);
	}

	public static function deleteUserByUsername($username) {
		$sql = "DELETE FROM user WHERE username='$username'";

		execute($sql);
	}

	public static function setUserPassword($username, $password) {
		$password = password_hash($password, PASSWORD_DEFAULT);

		$sql = "UPDATE user
				SET password='$password'
				WHERE username='$username'";

		execute($sql);
	}

	public static function hasUsername($username) {
		$sql = "SELECT * FROM user WHERE username='$username'";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
	}

	public static function deleteUserPermissionById($id) {
		$sql = "DELETE FROM user_permission WHERE id=$id";

		execute($sql);
	}

	public static function hasUserPermissionByUsername($username, $permission) {
		$sql = "SELECT * FROM user_permission WHERE username='$username' AND permission='$permission'";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
	}
	
	public static function checkUserPassword($username, $password) {
		$sql = "SELECT * FROM user WHERE username='$username'";
		
		$result = execute($sql);

		$array = toArray($result);
		
		return count($array) > 0 ? password_verify($password, $array[0]['password']) : false;
	}

	public static function getUserPermissionById($id) {
        $sql = "SELECT * FROM user_permission WHERE id=$id";
		
		$result = execute($sql);

		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			return new UserPermission($row['id'], $row['username'], $row['permission'], $row['value']);
		}

		return null;
    }

	public static function hasUserPermissionById($id) {
        $sql = "SELECT * FROM user_permission WHERE id=$id";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
    }

	public static function getUserPermissionByUsername($username, $permission) {
		$sql = "SELECT * FROM user_permission WHERE username='$username' AND permission='$permission'";
		
		$result = execute($sql);

		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			return new UserPermission($row['id'], $row['username'], $row['permission'], $row['value']);
		}

		return null;
	}

	public static function getUserByUsername($username) {
		$sql = "SELECT * FROM user WHERE username='$username'";
		
		$result = execute($sql);
		
		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			return new User($row['username'], $row['group'], $row['firstname'], $row['lastname'], $row['birth'], $row['address'], $row['phone'], $row['email']);
		}

		return null;
	}

	public static function hasUserByGroupName($group) {
		$sql = "SELECT * FROM user WHERE `group`='$group'";
		
		$result = execute($sql);
		
		$array = toArray($result);

		return count($array) > 0;
	}


	public static function getUsers() {
		$sql = "SELECT * FROM user";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new User($row['username'], $row['group'], $row['firstname'], $row['lastname'], $row['birth'], $row['address'], $row['phone'], $row['email']));
		}

		return $arr2;
	}

	public static function getUsersByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new User($row['username'], $row['group'], $row['firstname'], $row['lastname'], $row['birth'], $row['address'], $row['phone'], $row['email']));
		}

		return $arr2;
	}

	public static function getUserPermissionsByUsername($username) {
		$sql = "SELECT * FROM user_permission WHERE username='$username'";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new UserPermission($row['id'], $row['username'], $row['permission'], $row['value']));
		}

		return $arr2;
	}

	public static function getUserPermissionsByUsernameAndOrder($username, $orderBy, $orderDir) {
		$sql = "SELECT * FROM user_permission WHERE username='$username' ORDER BY `$orderBy` $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new UserPermission($row['id'], $row['username'], $row['permission'], $row['value']));
		}

		return $arr2;
	}

	public static function getUserPermissionsByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new UserPermission($row['id'], $row['username'], $row['permission'], $row['value']));
		}

		return $arr2;
	}

	public static function getUserPermissionsByOrder($orderBy, $orderDir) {
        $sql = "SELECT * FROM user_permission ORDER BY `$orderBy` $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new UserPermission($row['id'], $row['username'], $row['permission'], $row['value']));
		}
		return $arr2;
    }

	public static function getUsersByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM user ORDER BY `$orderBy` $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new User($row['username'], $row['group'], $row['firstname'], $row['lastname'], $row['birth'], $row['address'], $row['phone'], $row['email']));
		}
		return $arr2;
	}

	public static function getUsersByGroupName($group) {
		$sql = "SELECT * FROM user WHERE `group`='$group'";
		
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new User($row['username'], $row['group'], $row['firstname'], $row['lastname'], $row['birth'], $row['address'], $row['phone'], $row['email']));
		}

		return $arr2;
	}

	public static function getUserCount() {
		$sql = "SELECT * FROM user";
		
		$result = execute($sql);

		return $result->num_rows;
	}
}
?>