<?php 
function atualizarStatusRamal($id, $status) {
    $mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp', 3306);
    if ($mysqli->connect_error) {
        echo "<p>❌ Erro na conexão: " . $mysqli->connect_error . "</p>";
        return false;
    }

    mysqli_set_charset($mysqli, 'utf8');

    $id     = intval($id);
    $status = $mysqli->real_escape_string($status);

    $query1 = "UPDATE ramais_sugeridos SET status = '$status' WHERE id = $id";
    if ($mysqli->query($query1)) {
        $usuario = $_SESSION['UsuarioLogin'] ?? 'desconhecido';
        $ip      = $_SERVER['REMOTE_ADDR'] ?? 'sem_ip';

        $query2 = "
            INSERT INTO log_mod_ramal (id_ramal, status_aplicado, usuario, ip_origem)
            VALUES ($id, '$status', '$usuario', '$ip')
        ";
        $mysqli->query($query2);

        $mysqli->close();
        return true;
    } else {
        echo "<p>❌ Erro MySQL: " . $mysqli->error . "</p>";
        $mysqli->close();
        return false;
    }
}

/*function funcaoPainelModeracao() {
    $mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp', 3306);
    if ($mysqli->connect_error) {
        echo "<p>❌ Erro de conexão: " . $mysqli->connect_error . "</p>";
        return;
    }

    mysqli_set_charset($mysqli, "utf8");

    $sql = "
        SELECT r.id, r.ramal, r.descricao, s.setor AS nome_setor
        FROM ramais_sugeridos r
        LEFT JOIN setores s ON r.setor_id = s.id
        WHERE r.status = 'pendente'
        ORDER BY r.id DESC
    ";

    $result = $mysqli->query($sql);

    if (!$result) {
        echo "<p>⚠️ Erro na consulta: " . $mysqli->error . "</p>";
        return;
    }

    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Ramal</th><th>Descrição</th><th>Setor</th><th>Ações</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['ramal']}</td>";
        echo "<td>{$row['descricao']}</td>";
        echo "<td>{$row['nome_setor']}</td>";
        echo "<td>
                <form method='post' action=''>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button name='aprovado' value='aprovado'>✅ Aprovar</button>
                    <button name='rejeitado' value='rejeitado'>❌ Rejeitar</button>
                </form>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
    $mysqli->close();
}*/

// ✅ Tratar ações de aprovação/rejeição FORA da função
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aprovado'])) {
        $id = intval($_POST['id']);
        if (atualizarStatusRamal($id, 'aprovado')) {
            echo "<p>✅ Ramal aprovado com sucesso!</p>";
        }
    } elseif (isset($_POST['rejeitado'])) {
        $id = intval($_POST['id']);
        if (atualizarStatusRamal($id, 'rejeitado')) {
            echo "<p>❌ Ramal rejeitado com sucesso!</p>";
        }
    }
}
?>
