<?php

// Initialize session
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 28800);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);

session_start();
function authenticate($uname, $password) {
	// Active Directory server
	$ldap_host = "ldaps://auth.DOMAIN.com";

	// Active Directory DN
	$ldap_dn = "cn=users,dc=DOMAIN,dc=com";

	// user group
	$ldap_user_group = "users";

	// Supervisor group
	$ldap_super_group = "supervisors";

	// Login, for purposes of constructing $user login
	$login = "uid=$uname,cn=users,dc=DOMAIN,dc=com";

	// connect to active directory
	$ldap = ldap_connect($ldap_host);

	// verify user and password
	if($bind = @ldap_bind($ldap, $login, $password)) {
		// valid
		// check presence in groups
		$filter = "(uid=" . $uname . ")";

		// get list of groups $uname is a member of
		$attr = array("memberOf");
		$result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
		$groups = ldap_get_entries($ldap, $result);

		// get use name from ldap
		$name_attr = array("cn");
                $name_result = ldap_search($ldap, $ldap_dn, $filter, $name_attr) or exit("Unable to search LDAP server");
                $name = ldap_get_entries($ldap, $name_result);

		// check groups
		foreach($groups[0]['memberof'] as $grps) {
                        // is regular user
                        if (strpos($grps, $ldap_user_group)) $access = 1;

			// is supervisor
			if (strpos($grps, $ldap_super_group)) $access = 1;

		}

		if ($access != 0) {
			// establish session variables for user, access level, photo and name
			$_SESSION['uname'] = $uname;
			$_SESSION['access'] = $access;
			ldap_unbind($ldap);
			return true;
		} else {
			// user has no rights
			ldap_unbind($ldap);
			return false;
		}

	} else {
		// invalid name or password
		return false;
	}
}
?>
