<div class="container">
    <h1>Detalhes do Usuário</h1>

    <?php if ($flash = \App\Core\Flash::get($_ENV['FLASH_MESSAGE_KEY'])): ?>
        <?php foreach ($flash as $type => $message): ?>
        <div class="<?php echo $h($type); ?>">
            <?php echo $h($message); ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <p><strong>UUID:</strong> <?php echo $h($user->getUuid()); ?></p>
    <p><strong>Nome:</strong> <?php echo $h($user->getName()); ?></p>
    <p><strong>E-mail:</strong> <?php echo $h($user->getEmail()); ?></p>
    <p><strong>Criado em:</strong> <?php echo $h($user->getCreatedAt()); ?></p>

    <a href="/user/edit/<?php echo $h($user->getUuid()); ?>">Editar</a>
    <a href="/">Voltar para a Lista</a>
</div>