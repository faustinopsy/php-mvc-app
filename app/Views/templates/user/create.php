<div class="container">
<h1>Criar Usuário</h1>
<?php
require_once  __DIR__."/../mensagens.php";
?>

<form action="/user/store" method="POST">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($oldInput['name'] ?? ''); ?>" required>
    <br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($oldInput['email'] ?? ''); ?>" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Criar</button>
</form>
<a href="/">Voltar</a>
</div>