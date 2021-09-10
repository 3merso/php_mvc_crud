<div class="container">
    <h1>Contatos</h1><hr>
    <table class="table table-bordered table-striped" style="top:40px;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Email</th>
                <th><a href="?controller=ContactsController&method=create" class="btn btn-success btn-sm">Novo</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($contacts) {
                foreach ($contacts as $contact) {
                    ?>
                    <tr>
                        <td><?php echo $contact->nome; ?></td>
                        <td><?php echo $contact->telefone; ?></td>
                        <td><?php echo $contact->email; ?></td>
                        <td>
                            <a href="?controller=ContactsController&method=edit&id=<?php echo $contact->id; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="?controller=ContactsController&method=destroy&id=<?php echo $contact->id; ?>" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">Nenhum registro encontrado</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>