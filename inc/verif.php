<?php
ob_start(); // Impede que qualquer conteúdo seja enviado antes do header

include ('../config/config.php');
$http = $_SERVER['SERVER_NAME'];
$mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp', 3306);

if ($mysqli->connect_error) {
    die("Erro de conexão MySQL: " . $mysqli->connect_error);
}
// Valida autenticação no AD
function valida_ldap($srv, $usr, $pwd) {
    $ldap = @ldap_connect($srv);
    if (!$ldap) return false;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    return @ldap_bind($ldap, $usr, $pwd);
}

// Busca dados do usuário no AD via conta técnica
function buscarDadosUsuarioAD($login) {
    $ldap_server = "ldap://10.100.1.10";
    $adminUser   = "servweb";
    $adminPass   = "hu@esc@gamp@web";
    $base_dn     = "dc=hmd,dc=local";

    $ldap = ldap_connect($ldap_server);
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $ldaprdn = "hmd\\" . $adminUser;
    $bind = @ldap_bind($ldap, $ldaprdn, $adminPass);
    if (!$bind) return false;

    $filtro = "(sAMAccountName=$login)";
    $busca  = ldap_search($ldap, $base_dn, $filtro);
    $info   = ldap_get_entries($ldap, $busca);

    @ldap_close($ldap);

    if ($info["count"] > 0) {
        return [
            'nome'  => $info[0]['cn'][0] ?? '',
            'setor' => $info[0]['department'][0] ?? '',
            'dn'    => $info[0]['distinguishedname'][0] ?? ''
        ];
    }

    return false;
}

// Verifica se usuário existe ou cria no banco
function verificaOuCriaUsuario($login, $dadosAD, $mysqli) {
    $sql   = "SELECT * FROM usuarios WHERE login = '$login'";
    $query = $mysqli->query($sql);

    if ($query->num_rows > 0) {
        return mysqli_fetch_assoc($query);
    }

    $nome   = $dadosAD['nome'];
    $setor  = $dadosAD['setor'];
    $deptSql   = "SELECT id FROM setores WHERE setor LIKE '%$setor%'";
    $deptQuery = $mysqli->query($deptSql);
    $deptResul = mysqli_fetch_assoc($deptQuery);
    $setor_id  = $deptResul['id'] ?? 0;

    $insert = "INSERT INTO usuarios (login, nome, setor_id, acesso)
               VALUES ('$login', '$nome', '$setor_id', 1)";
    $mysqli->query($insert);

    // Buscar novamente após inserir
    $query = $mysqli->query($sql);
    return $query->num_rows > 0 ? mysqli_fetch_assoc($query) : false;
}

// Inicia sessão e redireciona
function iniciarSessaoELogar($usuario, $http) {
    if (!isset($_SESSION)) session_start();

    $_SESSION['UsuarioID']       = $usuario['id'];
    $_SESSION['UsuarioLogin']    = $usuario['login'];
    $_SESSION['UsuarioNome']     = $usuario['nome'];
    $_SESSION['UsuarioSetorId']  = $usuario['setor_id'];
    $_SESSION['UsuarioAcesso']   = $usuario['acesso'];
    $_SESSION['UsuarioGrupo'] = 'Informatica'; // ou outro valor conforme seu critério


  header("Location: http://127.0.0.1:9008/index.php?tela=home");
    exit;
}

// --- Fluxo principal ---

$login   = trim($_REQUEST['usu'] ?? '');
$senha   = trim($_REQUEST['senha'] ?? '');
$server  = "10.100.1.10";
$dominio = "@hmd.local";
$userAD  = $login . $dominio;

if (!$login || !$senha) {
    echo "<script>alert('Campos obrigatórios ficaram vazios, tente novamente.');</script>";
    echo "<meta http-equiv='refresh' content='0.5; URL=http://$http/?tela=login' />";
    ob_end_flush();
    exit;
}

if (valida_ldap($server, $userAD, $senha)) {
    $dadosAD = buscarDadosUsuarioAD($login);
    if ($dadosAD) {
        $usuario = verificaOuCriaUsuario($login, $dadosAD, $mysqli);
        if ($usuario) {
            iniciarSessaoELogar($usuario, $http);
        } else {
            echo "<script>alert('Não foi possível salvar o usuário no banco.');</script>";
        }
    } else {
        echo "<script>alert('Não foi possível obter dados do Active Directory.');</script>";
    }
} else {
    echo "<script>alert('Usuário ou senha inválida.');</script>";
    echo "<meta http-equiv='refresh' content='0.5; URL=http://$http/?tela=login' />";
}

ob_end_flush(); // Finaliza o buffer
?>
