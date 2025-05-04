<div class="container">
<h1>Editar Usuário</h1>

<?php if ($error = \App\Core\Flash::get($_ENV['FLASH_MESSAGE_KEY'])): ?>
    <?php foreach ($flash as $type => $message): ?>
    <div class="<?php echo $h($type); ?>">
        <?php echo $h($message); ?>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<form action="/user/update/<?php echo $h($user->getUuid()); ?>" method="POST">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="<?php echo $h($user->getName()); ?>" required>
    <br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo $h($user->getEmail()); ?>" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password">
    <br>
    <button type="submit">Atualizar</button>
</form>
<a href="/">Voltar</a>
</div>