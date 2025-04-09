<?php
require_once 'Conexao.php';
require_once 'Usuario.php';
require_once 'PontosColeta.php';
require_once 'Noticias.php';

$conn = Conexao::getConexao();
$usuario = new Usuario($conn);
$ponto = new PontosColeta($conn);
$noticia = new Noticias($conn);

// Exclusão
if (isset($_GET['excluir_usuario'])) {
    $usuario->excluir($_GET['excluir_usuario']);
    header("Location: pagina_admin.php");
    exit;
}

if (isset($_GET['excluir_ponto'])) {
    $ponto->excluir($_GET['excluir_ponto']);
    header("Location: pagina_admin.php");
    exit;
}

if (isset($_GET['excluir_noticia'])) {
    $noticia->excluir($_GET['excluir_noticia']);
    header("Location: pagina_admin.php");
    exit;
}

// Edição
if (isset($_POST['editar_usuario'])) {
    $usuario->editar($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['tipo_usuario']);
    header("Location: pagina_admin.php");
    exit;
}

if (isset($_POST['editar_ponto'])) {
    $ponto->editar($_POST['id'], $_POST['nome'], $_POST['endereco'], $_POST['cidade'], $_POST['estado'], $_POST['capacidade_total'], $_POST['capacidade_disponivel'], $_POST['horario'], $_POST['contato']);
    header("Location: pagina_admin.php");
    exit;
}

if (isset($_POST['editar_noticia'])) {
    $noticia->editar($_POST['id'], $_POST['titulo'], $_POST['conteudo']);
    header("Location: pagina_admin.php");
    exit;
}

// Adição
if (isset($_POST['adicionar_usuario'])) {
    if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['tipo_usuario'])) {
        $usuario->inserir($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo_usuario']);
        header("Location: pagina_admin.php");
        exit;
    } else {
        echo "<script>alert('Preencha os campos obrigatórios.');</script>";
    }
}

if (isset($_POST['adicionar_noticia'])) {
    if (!empty($_POST['titulo']) && !empty($_POST['conteudo'])) {
        $noticia->inserir($_POST['titulo'], $_POST['conteudo']);
        header("Location: pagina_admin.php");
        exit;
    } else {
        echo "<script>alert('Preencha os campos obrigatórios.');</script>";
    }
}

if (isset($_POST['adicionar_ponto'])) {
    if (!empty($_POST['nome']) && !empty($_POST['cidade']) && !empty($_POST['estado'])) {
        $ponto->inserir($_POST['nome'], $_POST['endereco'], $_POST['cidade'], $_POST['estado'], $_POST['capacidade_total'], $_POST['capacidade_disponivel'], $_POST['horario'], $_POST['contato'], 1);
        header("Location: pagina_admin.php");
        exit;
    } else {
        echo "<script>alert('Preencha os campos obrigatórios.');</script>";
    }
}

$usuarios = $usuario->listar();
$pontos = $ponto->listar();
$noticias = $noticia->listar();

function editarAberto($tipo, $id) {
    return isset($_GET['editar']) && $_GET['editar'] === $tipo && $_GET['id'] == $id;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de dados</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #E1EED0 }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; background-color: white }
        th, td { padding: 8px; border: 1px solid #ccc; }
        .btn { padding: 6px 10px; text-decoration: none; background-color: #246600; color: white; border-radius: 4px; margin: 5 5 5 5 }
        .btn.excluir { background-color:rgb(20, 33, 13) }
        form input { width: 100%; box-sizing: border-box; }
        h2 { margin-top: 50px; }
        td.conteudo-coluna { max-width: 250px; }
    </style>
</head>
<body>
    <h1>Gerenciar Dados3</h1>

    <!-- Usuários -->
    <h2>Usuários</h2>
    <table>
        <tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Ações</th></tr>
        <?php foreach ($usuarios as $u): ?>
            <?php if (editarAberto('usuario', $u['id'])): ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><input name="nome" value="<?= $u['nome'] ?>"></td>
                        <td><input name="email" value="<?= $u['email'] ?>"></td>
                        <td><input name="tipo_usuario" value="<?= $u['tipo_usuario'] ?>"></td>
                        <td>
                            <button type="submit" name="editar_usuario" class="btn">Salvar</button>
                            <a href="gerenciar.php" class="btn">Cancelar</a>
                        </td>
                    </tr>
                </form>
            <?php else: ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= $u['nome'] ?></td>
                    <td><?= $u['email'] ?></td>
                    <td><?= $u['tipo_usuario'] ?></td>
                    <td>
                        <a href="?editar=usuario&id=<?= $u['id'] ?>" class="btn">Editar</a>
                        <a href="?excluir_usuario=<?= $u['id'] ?>" class="btn excluir" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Formulário de adicionar usuário -->
        <form method="POST">
            <tr>
                <td>+</td>
                <td><input name="nome" placeholder="Nome"></td>
                <td><input name="email" placeholder="Email"></td>
                <td><input name="tipo_usuario" placeholder="Tipo"></td>
                <input type="hidden" name="senha" value="123456">
                <td><button type="submit" name="adicionar_usuario" class="btn">Adicionar novo</button></td>
            </tr>
        </form>
    </table>

    <!-- Pontos de Coleta -->
    <h2>Pontos de Coleta</h2>
    <table>
        <tr><th>ID</th><th>Nome</th><th>Cidade</th><th>Estado</th><th>Contato</th><th>Ações</th></tr>
        <?php foreach ($pontos as $p): ?>
            <?php if (editarAberto('ponto', $p['id'])): ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><input name="nome" value="<?= $p['nome'] ?>"></td>
                        <td><input name="cidade" value="<?= $p['cidade'] ?>"></td>
                        <td><input name="estado" value="<?= $p['estado'] ?>"></td>
                        <td><input name="contato" value="<?= $p['contato'] ?>"></td>
                        <input type="hidden" name="endereco" value="<?= $p['endereco'] ?>">
                        <input type="hidden" name="capacidade_total" value="<?= $p['capacidade_total'] ?>">
                        <input type="hidden" name="capacidade_disponivel" value="<?= $p['capacidade_disponivel'] ?>">
                        <input type="hidden" name="horario" value="<?= $p['horario_funcionamento'] ?>">
                        <td>
                            <button type="submit" name="editar_ponto" class="btn">Salvar</button>
                            <a href="gerenciar.php" class="btn">Cancelar</a>
                        </td>
                    </tr>
                </form>
            <?php else: ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['nome'] ?></td>
                    <td><?= $p['cidade'] ?></td>
                    <td><?= $p['estado'] ?></td>
                    <td><?= $p['contato'] ?></td>
                    <td>
                        <a href="?editar=ponto&id=<?= $p['id'] ?>" class="btn">Editar</a>
                        <a href="?excluir_ponto=<?= $p['id'] ?>" class="btn excluir" onclick="return confirm('Excluir ponto?')">Excluir</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Formulário de adicionar ponto -->
        <form method="POST">
            <tr>
                <td>+</td>
                <td><input name="nome" placeholder="Nome"></td>
                <td><input name="cidade" placeholder="Cidade"></td>
                <td><input name="estado" placeholder="Estado"></td>
                <td><input name="contato" placeholder="Contato"></td>
                <input type="hidden" name="endereco" value="Endereço Padrão">
                <input type="hidden" name="capacidade_total" value="100">
                <input type="hidden" name="capacidade_disponivel" value="100">
                <input type="hidden" name="horario" value="08:00-18:00">
                <td><button type="submit" name="adicionar_ponto" class="btn">Adicionar novo</button></td>
            </tr>
        </form>
    </table>

    <!-- Notícias -->
    <h2>Notícias</h2>
    <table>
        <tr><th>ID</th><th>Título</th><th>Conteúdo</th><th>Ações</th></tr>
        <?php foreach ($noticias as $n): ?>
            <?php if (editarAberto('noticia', $n['id'])): ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $n['id'] ?>">
                    <tr>
                        <td><?= $n['id'] ?></td>
                        <td><input name="titulo" value="<?= $n['titulo'] ?>"></td>
                        <td><input name="conteudo" value="<?= $n['conteudo'] ?>"></td>
                        <td>
                            <button type="submit" name="editar_noticia" class="btn">Salvar</button>
                            <a href="gerenciar.php" class="btn">Cancelar</a>
                        </td>
                    </tr>
                </form>
            <?php else: ?>
                <tr>
                    <td><?= $n['id'] ?></td>
                    <td><?= $n['titulo'] ?></td>
                    <td><?= $n['conteudo'] ?></td>
                    <td>
                        <a href="?editar=noticia&id=<?= $n['id'] ?>" class="btn">Editar</a>
                        <a href="?excluir_noticia=<?= $n['id'] ?>" class="btn excluir" onclick="return confirm('Excluir notícia?')">Excluir</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Formulário de adicionar notícia -->
        <form method="POST">
            <tr>
                <td>+</td>
                <td><input name="titulo" placeholder="Título"></td>
                <td><input name="conteudo" placeholder="Conteúdo"></td>
                <td><button type="submit" name="adicionar_noticia" class="btn">Adicionar novo</button></td>
            </tr>
        </form>
    </table>
</body>
</html>
