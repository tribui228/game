<?php
class GroupUtil {
    public static function addGroup($group) {
        if (!GroupSQL::hasGroupName($group->getName())) {
            GroupSQL::insertGroup($group);
        }
    }

    public static function addGroupPermission($groupPermission) {
        if (!GroupUtil::hasGroupPermissionByGroup($groupPermission->getGroup(), $groupPermission->getPermission())) {
            GroupSQL::insertGroupPermission($groupPermission);
        }
    }

    public static function insertGroupPermissions($groupPermissions) {
        return GroupSQL::insertGroupPermissions($groupPermissions);
    }

    public static function updateGroup($group) {
        if (GroupSQL::hasGroupName($group->getName())) {
            GroupSQL::updateGroup($group);
        }
    }

    public static function getGroupsByQuery($sql) {
        return GroupSQL::getGroupsByQuery($sql);
    }

    public static function updateGroupPermission($groupPermission) {
        return GroupSQL::updateGroupPermission($groupPermission);
    }

    public static function getGroupByName($name) {
        return GroupSQL::getGroupByName($name);
    }

    public static function getGroups() {
        return GroupSQL::getGroups();
    }

    public static function getGroupsByOrder($orderBy, $orderDir) {
        return GroupSQL::getGroupsByOrder($orderBy, $orderDir);
    }

    public static function getGroupCount() {
		return GroupSQL::getGroupCount();
	}

    public static function hasGroupName($name) {
        return GroupSQL::hasGroupName($name);
    }

    public static function deleteGroupByName($name) {
        if (GroupSQL::hasGroupName($name)) {
            GroupSQL::deleteGroupByName($name);
            return 0;
        }
	}

    public static function hasGroupPermissionByGroup($group, $permission) {
        return GroupSQL::hasGroupPermissionByGroup($group, $permission);
    }

    public static function hasGroupPermissionById($id) {
        return GroupSQL::hasGroupPermissionById($id);
    }

    public static function getGroupPermissionsByGroup($group) {
        return GroupSQL::getGroupPermissionsByGroup($group);
    }

    public static function getGroupPermissionsByOrder($orderBy, $orderDir) {
        return GroupSQL::getGroupPermissionsByOrder($orderBy, $orderDir);
    }

    public static function getGroupPermissionsByGroupAndOrder($group, $orderBy, $orderDir) {
        return GroupSQL::getGroupPermissionsByGroupAndOrder($group, $orderBy, $orderDir);
    }

    public static function deleteGroupPermissionById($id) {
        return GroupSQL::deleteGroupPermissionById($id);
    }

    public static function deleteGroupPermissionsByGroupName($group) {
        return GroupSQL::deleteGroupPermissionsByGroupName($group);
    }

    public static function getGroupPermissionById($id) {
        return GroupSQL::getGroupPermissionById($id);
    }
}
?>