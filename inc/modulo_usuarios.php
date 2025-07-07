<?php
function painelUsuarios() {
    // Conexão com o banco
    $mysqli = new mysqli('127.0.0.1', 'dev', 'devloop356', 'intra_gamp', 3306);
    mysqli_set_charset($mysqli, 'utf8');

    // Consulta para listar usuários
    $result = $mysqli->query("SELECT id, login, nome_completo, grupo_id FROM usuarios");

    echo "<div class='container mt-4'>";
    echo "<h2 class='text-center text-info mb-4'>👥 Gestão de Usuários</h2>";

    if ($result && $result->num_rows > 0) {
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead class='thead-light'><tr>
                <th>ID</th>
                <th>Login</th>
                <th>Nome</th>
                <th>Grupo</th>
                <th>Ações</th>
              </tr></thead><tbody>";

        // Mapeia ID do grupo para nome amigável
        $grupos = [
            1 => 'Visualizador',
            2 => 'Moderador',
            3 => 'Administrador'
        ];

        while ($user = $result->fetch_assoc()) {
            $id       = $user['id'];
            $login    = htmlspecialchars($user['login']);
            $nome     = htmlspecialchars($user['nome_completo']);
            $grupo_id = (int) $user['grupo_id'];
            $grupo    = $grupos[$grupo_id] ?? 'Desconhecido';

            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$login</td>";
            echo "<td>$nome</td>";
            echo "<td>$grupo</td>";
            echo "<td>
                    <a href='?tela=editar_usuario&id=$id' class='btn btn-primary btn-sm'>✏️ Editar</a>
                    <a href='?tela=remover_usuario&id=$id' class='btn btn-danger btn-sm ml-2'>🗑️ Remover</a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-secondary text-center'>Nenhum usuário encontrado.</div>";
    }

    echo "</div>"; // container
    $mysqli->close();
}
?>
