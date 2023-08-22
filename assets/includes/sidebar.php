<?php
    $url = $_SERVER['PHP_SELF'];

    if(strstr($url, "parceiros")) {
        $page = 'parceiros';
    } else if(strstr($url, "usuarios")) {
        $page = 'usuarios';
    } else if(strstr($url, "perfil")) {
        $page = 'perfil';
    } else {
        $page = 'home';
    }
?>

<!-- data-color: white || black / data-active-color: primary || info || success || warning || danger -->
<div class="sidebar" data-color="black" data-active-color="info"> 
    <div class="logo" style="display:flex; justify-content: center;">
        <a href="home.php" class="simple-text logo-normal bg-light" style="border-radius: 150px; padding: 15px; width: 150px; height: 150px; display: flex; justify-content: center; align-items: center;">
            <div class="logo-image-big" style="width: auto;">
                <img src="assets/img/logo_color_01.png" width="100%">
            </div>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if($page == 'home') { ?>class="active"<?php } ?>>
                <a href="home.php">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>Viagens</p>
                </a>
            </li>

            <li <?php if($page == 'parceiros') { ?>class="active"<?php } ?>>
                <a href="parceiros.php">
                    <i class="nc-icon nc-delivery-fast"></i>
                    <p>Parceiros</p>
                </a>
            </li>

            <li <?php if($page == 'usuarios') { ?>class="active"<?php } ?>>
                <a href="usuarios.php">
                    <i class="nc-icon nc-circle-10"></i>
                    <p>Usuários</p>
                </a>
            </li>

            <li <?php if($page == 'perfil') { ?>class="active"<?php } ?>>
                <a href="perfil.php">
                    <i class="nc-icon nc-touch-id"></i>
                    <p>Perfil</p>
                </a>
            </li>          
            
            <li>
                <a href="desconectar.php">
                    <i class="nc-icon nc-button-power"></i>
                    <p>Sair</p>
                </a>
            </li>
        </ul>
    </div>
</div>