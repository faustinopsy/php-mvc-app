<div class="container">
<h1>Lista de Usuários</h1>
<?php
require_once  __DIR__."/../../components/alerta.php";
?>
<table border="10.4">
    <thead>
        <tr>
            <th>UUID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $h($user->getUuid()); ?></td>
                <td><?php echo $h($user->getName()); ?></td>
                <td><?php echo $h($user->getEmail()); ?></td>
                <td>
                    <a href="/user/view/<?php echo $h($user->getUuid()); ?>" >Ver</a>
                    <a href="/user/edit/<?php echo $h($user->getUuid()); ?>" >Editar</a>
                    <a href="/user/delete/<?php echo $h($user->getUuid()); ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="/user/create">Criar Novo Usuário</a>
</div>
