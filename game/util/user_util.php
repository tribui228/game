<?php
class UserUtil{
    public static function addUser($user) {
        if (!UserUtil::hasUsername($user->getUsername())) {
            UserSQL::insertUser($user);
        }
    }

    public static function addUserPermission($userPermission) {
        if (!UserUtil::hasUserPermissionByUsername($userPermission->getUsername(), $userPermission->getPermission())) {
            UserSQL::insertUserPermission($userPermission);
        }
    }

    public static function getUsersByQuery($sql) {
        return UserSQL::getUsersByQuery($sql);
    }

    public static function deleteUserByUsername($username) {
        return UserSQL::deleteUserByUsername($username);
    }

    public static function getUserByUsername($username) {
        return UserSQL::getUserByUsername($username);
    }

    public static function getUsersByGroupName($group) {
        return UserSQL::getUsersByGroupName($group);
    }

    public static function hasUserByGroupName($group) {
        return UserSQL::hasUserByGroupName($group);
    }

    public static function getUsersByOrder($orderBy, $orderDir) {
        return UserSQL::getUsersByOrder($orderBy, $orderDir);
    }

    public static function updateUser($user) {
        return UserSQL::updateUser($user);
    }

    public static function getUserPermissionsByQuery($sql) {
        return UserSQL::getUserPermissionsByQuery($sql);
    }

    public static function updateUserPermission($userPermission) {
        return UserSQL::updateUserPermission($userPermission);
    }

    public static function getUsers() {
        return UserSQL::getUsers();
    }

    public static function hasUsername($username) {
        return UserSQL::hasUsername($username);
    }

    public static function checkUserPassword($username, $password) {
        return UserSQL::checkUserPassword($username, $password);
    }

    public static function setUserPassword($username, $password) {
        UserSQL::setUserPassword($username, $password);
    }

    public static function getUserCount() {
        return UserSQL::getUserCount();
    }

    public static function getUserPermissionsByUsername($username) {
        return UserSQL::getUserPermissionsByUsername($username);
    }

    public static function getUserPermissionById($id) {
        return UserSQL::getUserPermissionById($id);
    }

    public static function hasUserPermissionById($id) {
        return UserSQL::hasUserPermissionById($id);
    }

    public static function getUserPermissionsByUsernameAndOrder($username, $orderBy, $orderDir) {
        return UserSQL::getUserPermissionsByUsernameAndOrder($username, $orderBy, $orderDir);
    }

    public static function getUserPermissionsByOrder($orderBy, $orderDir) {
        return UserSQL::getUserPermissionsByOrder($orderBy, $orderDir);
    }

    public static function hasUserPermissionByUsername($username, $permission) {
        return UserSQL::hasUserPermissionByUsername($username, $permission);
    }

    public static function hasPermission($username, $permission) {
        if (UserSQL::hasUsername($username)) {
            $user = UserSQL::getUserByUsername($username);

            $userPermission = UserSQL::getUserPermissionByUsername($username, $permission);
            
            if (!is_null($userPermission)) {
                return $userPermission->getValue();
            }
            
            $groupPermission = GroupSQL::getGroupPermissionByGroup($user->getGroup(), $permission);

            return is_null($groupPermission) ? false : $groupPermission->getValue();
        }else {
            $groupPermission = GroupSQL::getGroupPermissionByGroup("default", $permission);

            return is_null($groupPermission) ? false : $groupPermission->getValue();
        }
        return false;
    }

    public static function deleteUserPermissionById($id) {
        UserSQL::deleteUserPermissionById($id);
    }

    public static function checkFullInformationUser($username) {
        $user = UserUtil::getUserByUsername($username);
        return !empty($user->getFirstname()) && !empty($user->getLastname()) && !empty($user->getBirth()) && !empty($user->getAddress()) && !empty($user->getPhone()) && !empty($user->getEmail());
    }
}
?>