<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen'])){
        $frm_data = filteration($_GET);

        if($frm_data['seen']=='all'){
            $q ="UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            if(update($q,$values,'i')){
                alert('success','Todos Marcados como lido!!');
            }
            else{
                alert('error','Operação não realizada');
            }
        }
        else{
            $q ="UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
            $values = [1,$frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success','Marcado como lido!!');
            }
            else{
                alert('error','Operação não realizada');
            }
        }
    }

    if(isset($_GET['del'])){
        $frm_data = filteration($_GET);

        if($frm_data['del']=='all'){
            $q ="DELETE FROM `user_queries`";
            if(mysqli_query($con,$q)){
                alert('success','Todas as mensagens foram deletadas com sucesso');
            }
            else{
                alert('error','Operação não realizada');
            }
        }
        else{
            $q ="DELETE FROM `user_queries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(delete($q,$values,'i')){
                alert('success','Mensagem deletada com sucesso');
            }
            else{
                alert('error','Operação não realizada');
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato usuários </title>
    <?php require('inc/links.php'); ?> 
 
</head>
<body style="background-color: LightGrey;">
    
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Mensagens Recebidas</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                    <div class="text_end mb-4">
                        <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                            <i class="bi bi-clipboard2-check"></i> Marcar todos como lido
                        </a>
                        <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                            <i class="bi bi-trash3"></i> Deletar todos
                        </a>
                    </div>
                        <div class="table-responsive-md" style="height: 400px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col" width="15%">Nome</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width="15%">Assunto</th>
                                        <th scope="col" width="30%">Menssagem</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Conf.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $q = "SELECT * FROM `user_queries` ORDER BY `sr_no` DESC";
                                        $data = mysqli_query($con,$q);
                                        $i=1;

                                        while($row = mysqli_fetch_assoc($data)){
                                            $seen='';
                                            if($row['seen']!=1){
                                                $seen = "<a href='?seen=$row[sr_no]' style='font-size: 12px;' class='btn btn-sm rounded-pill btn-dark'>Marcar como lido</a></br>";
                                            }
                                            $seen.="<a href='?del=$row[sr_no]' style='font-size:12px;' class='btn btn-sm rounded-pill btn-danger mt-2'>Deletar Mensagem</a>";
                                            
                                            echo <<<query
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td>$row[date]</td>
                                                    <td>$seen</td>
                                                </tr>
                                            query;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
</body>
</html>