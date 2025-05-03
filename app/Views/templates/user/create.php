<div class="container">
<h1>Criar Usuário</h1>

<?php if ($error = \App\Core\Flash::get($_ENV['FLASH_MESSAGE_KEY'])): ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form action="/user/store" method="POST">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Criar</button>
</form>
<a href="/">Voltar</a>
</div>