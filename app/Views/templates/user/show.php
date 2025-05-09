<div class="container">
    <h1>Detalhes do Usuário</h1>
    <?php
        require_once  __DIR__."/../../components/alerta.php";
    ?>

    <p><strong>UUID:</strong> <?php echo $h($user->getUuid()); ?></p>
    <p><strong>Nome:</strong> <?php echo $h($user->getName()); ?></p>
    <p><strong>E-mail:</strong> <?php echo $h($user->getEmail()); ?></p>
    <p><strong>Criado em:</strong> <?php echo $h($user->getCreatedAt()); ?></p>

    <a href="/user/edit/<?php echo $h($user->getUuid()); ?>" class="button">Editar</a>
    <a href="/">Voltar para a Lista</a>
</div>