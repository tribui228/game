<?php
class GroupSQL {
	public static function insertGroup($group) {
		$name = $group->getName();
		$display = $group->getDisplay();

		$sql = "INSERT INTO `group`(name, display) values('$name', '$display')";

		execute($sql);
	}

	public static function insertGroupPermission($groupPermission) {
		$group = $groupPermission->getGroup();
		$permission = $groupPermission->getPermission();
		$value = $groupPermission->getValue();

		$sql = "INSERT INTO group_permission(`group`, permission, value)
				VALUES ('$group', '$permission', '$value')";

		execute($sql);
	}

	public static function insertGroupPermissions($groupPermissions) {
		$conn = openConnect();
		
		foreach ($groupPermissions as $groupPermission) {
			$group = $groupPermission->getGroup();
			$permission = $groupPermission->getPermission();
			$value = $groupPermission->getValue();

			$sql = "INSERT INTO group_permission(`group`, permission, value)
					VALUES ('$group', '$permission', '$value')";
			$conn->query($sql);
		}
		closeConnect($conn);
	}

	public static function updateGroup($group) {
		$name = $group->getName();
		$display = $group->getDisplay();

		$sql = "UPDATE `group` SET display='$display' WHERE name='$name'";

		execute($sql);
	}

	
	public static function updateGroupPermission($groupPermission) {
		$id = $groupPermission->getId();
		$group = $groupPermission->getGroup();
		$permission = $groupPermission->getPermission();
		$value = $groupPermission->getValue();

		$sql = "UPDATE group_permission
				SET `group`='$group', permission='$permission', value=$value
				WHERE id=$id";

		execute($sql);
	}


	public static function deleteGroupByName($name) {
		$sql = "DELETE FROM `group` WHERE name='$name'";

		execute($sql);
	}

	public static function deleteGroupPermissionById($id) {
		$sql = "DELETE FROM `group_permission` WHERE id=$id";

		execute($sql);
	}

	public static function deleteGroupPermissionsByGroupName($group) {
		$sql = "DELETE FROM `group_permission` WHERE `group`='$group'";

		execute($sql);
	}

	public static function hasGroupName($name) {
		$sql = "SELECT * FROM `group` WHERE name='$name'";

		$arr = toArray(execute($sql));

		return count($arr) > 0;
	}

	public static function hasGroupPermissionByGroup($group, $permission) {
		$sql = "SELECT * FROM group_permission WHERE `group`='$group' AND permission='$permission'";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
	}

	public static function hasGroupPermissionById($id) {
		$sql = "SELECT * FROM group_permission WHERE `id`=$id";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
	}

	public static function getGroupPermissionById($id) {
		$sql = "SELECT * FROM group_permission WHERE `id`=$id";
		
		$result = execute($sql);

		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			return new GroupPermission($row['id'], $row['group'], $row['permission'], $row['value']);
		}

		return null;
	}

	public static function getGroupPermissionByGroup($group, $permission) {
		$sql = "SELECT * FROM group_permission WHERE `group`='$group' AND permission='$permission'";
		
		$result = execute($sql);

		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			return new GroupPermission($row['id'], $row['group'], $row['permission'], $row['value']);
		}

		return null;
	}

	public static function getGroupPermissionsByGroup($group) {
		$sql = "SELECT * FROM `group_permission` WHERE `group`='$group'";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new GroupPermission($row['id'], $row['group'], $row['permission'], $row['value']));
		}
		return $arr2;
	}

	public static function getGroupPermissionsByGroupAndOrder($group, $orderBy, $orderDir) {
		$sql = "SELECT * FROM `group_permission` WHERE `group`='$group' ORDER BY `$orderBy` $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new GroupPermission($row['id'], $row['group'], $row['permission'], $row['value']));
		}
		return $arr2;
	}

	public static function getGroupPermissionsByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM `group_permission` ORDER BY `$orderBy` $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new GroupPermission($row['id'], $row['group'], $row['permission'], $row['value']));
		}
		return $arr2;
	}

	public static function getGroupByName($name) {
		$sql = "SELECT * FROM `group` WHERE name='$name'";

		$arr = toArray(execute($sql));

		if (count($arr) > 0) {
			$row = $arr[0];

			return new Group($row['name'], $row['display']);
		}
		return null;
	}

	public static function getGroupsByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM `group` ORDER BY `$orderBy` $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Group($row['name'], $row['display']));
		}
		return $arr2;
	}

	public static function getGroupsByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Group($row['name'], $row['display']));
		}
		return $arr2;
	}

	public static function getGroups() {
		$sql = "SELECT * FROM `group`";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Group($row['name'], $row['display']));
		}
		return $arr2;
	}

	public static function getGroupCount() {
		$sql = "SELECT * FROM `group`";
		
		$result = execute($sql);

		return $result->num_rows;
	}
}
?>