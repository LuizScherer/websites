<?php 
    require('inc/db_config.php'); 
    require('inc/essentials.php'); 

    session_start();
    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        redirect('dashboard.php');
     }      
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatilbe" content="IE=edge">
    <title>Login Painel Administrativo</title>
    <link rel="stylesheet" href="styles.css"> 
    <?php require('inc/links.php'); ?>
    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 400px;
        }
    </style>
</head>
<body style="background-color: LightGrey;">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="bg-dark text-white py-3">Painel de Login</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Usuário">
                </div>
                <div class="mb-4">
                    <input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Senha">
                </div>
                <a href="../index.php" class="btn btn-light" style="text-decoration: none;">Voltar</a>
                <button name="login" type="submit" class="btn text-white custom-bg shadow-none">Logar</button>
            </div>
        </form>
    </div>

    <?php

        if(isset($_POST['login']))
        {
            $frm_data =filteration($_POST);
            
            $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
            $values = [$frm_data['admin_name'],$frm_data['admin_pass']];

            $res = select($query,$values,"ss");
            if($res->num_rows==1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminId'] = $row['sr_no'];
                redirect('dashboard.php');
            }
            else{
               alert('error','Usuário/senha não encontrados!! :(');
            }
        }
    ?>

    <?php require('inc/scripts.php'); ?>  
</body>
</html>