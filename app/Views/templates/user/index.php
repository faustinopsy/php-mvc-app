<div class="container">
<h1>Lista de Usuários</h1>
<?php if ($error = \App\Core\Flash::get('flash_message')): ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
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
                <td><?php echo htmlspecialchars($user['uuid']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <a href="/user/edit/<?php echo $user['uuid']; ?>" >Editar</a>
                    <a href="/user/delete/<?php echo $user['uuid']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="/user/create">Criar Novo Usuário</a>
</div>
