 <?php
function authenticate($user, $password) {
  print 'func';
    // Active Directory server
    $ldap_host = "10.100.1.10";

    // Active Directory DN
    $ldap_dn = "DC=hmd,DC=local";

    // Active Directory user group
    $ldap_user_group = "WebUsers";

    // Active Directory manager group
    $ldap_manager_group = "WebManagers5";
   // $ldap_manager_group = "WebManagers";alterado pelo Marco

    // Domain, for purposes of constructing $user
    $ldap_usr_dom = "hmd";

// connect to active directory
$ldap = ldap_connect($ldap_host);
// verify user and password
if($bind = @ldap_bind($ldap, $user, $password)) {
// valid
// check presence in groups
    print 'ops';
    $filter = "(sAMAccountName={$user})";
    /*$filter = "(sAMAccountName= andre.dorneles )";ALTERADO PELO MARCO*/
    $attr = array("memberof","givenname");
    $result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
    $entries = ldap_get_entries($ldap, $result);
    $givenname = $entries[0]['givenname'];
    ldap_unbind($ldap);
    $_SESSION['user'] = $user;
    $_SESSION['access'] = $access;
    $_SESSION['givenname'] = $givenname;
    print 'ops';
    // check groups
    foreach($entries[0]['memberof'] as $grps) {
        // is manager, break loop
        if (strpos($grps, $ldap_manager_group)) { $access = 2; break; }

        // is user
        if (strpos($grps, $ldap_user_group)) $access = 1;
    }

    if ($access != 0) {
        // establish session variables
        $_SESSION['user'] = $user;
        $_SESSION['access'] = $access;
        $_SESSION['givenname'] = $givenname;
        print 'deu';
        return true;
    } else {
        // user has no rights
        return false;
    }

} else {
    // invalid name or password
    return false;
}
}
?>