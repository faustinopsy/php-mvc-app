<div class="container">
<h1>Lista de Usuários</h1>
<?php
require_once  __DIR__."/../../components/alerta.php";
?>
<table border="10.4" id="userTable">
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
                <td id="actions" >
                    <a href="/user/view/<?php echo $h($user->getUuid()); ?>" class="button secondary">Ver</a>
                    <a href="/user/edit/<?php echo $h($user->getUuid()); ?>" class="button primary">Editar</a>
                    <form id="deleteForm"  action="/user/delete/<?php echo $h($user->getUuid()); ?>" method="POST" style="display:block;" >
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?php echo $h($user->getUuid()); ?>">
                            <button type="submit" class="button error delete-button">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="/user/create" class="button success">Criar Novo Usuário</a>
</div>
<script>
document.addEventListener('DOMContentLoaded', ()=>{
    const userTable = document.getElementById('userTable');
    if (userTable) {
        userTable.addEventListener('click', function(event) {
        const target = event.target;

            if (target.tagName === 'BUTTON' && target.type === 'submit' && target.classList.contains('delete-button')) {
                const form = target.closest('form');

                if (form) {
                    event.preventDefault();
                    const confirmed = confirm("Tem certeza que deseja excluir este usuário?");
                    if (confirmed) {
                        form.submit();
                    }
                }
            }
        });
    } else {
        console.error("Elemento #userTable não encontrado. O script de confirmação não foi aplicado.");
    }
});
</script>