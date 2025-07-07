<?php
//A gente pode levar o burro até a fonte, mas não pode obrigar ele a beber água
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
if (isset($_SESSION['UsuarioID'])) {
                // Destrói a sessão por segurança
                session_destroy();
                // Redireciona o visitante de volta pro login
               header("Location: ../../index.php"); exit;
            }
?>

