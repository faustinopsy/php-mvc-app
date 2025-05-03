<div class="container">
<h1>Editar Usuário</h1>

<?php if ($error = \App\Core\Flash::get($_ENV['FLASH_MESSAGE_KEY'])): ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form action="/user/update/<?php echo $user['uuid']; ?>" method="POST">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
    <br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password">
    <br>
    <button type="submit">Atualizar</button>
</form>
<a href="/">Voltar</a>
</div>