<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/main.css"> 

    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700" rel="stylesheet">
    
    <title>Giulia Domna - Sistema de Lojistas</title>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js" ></script>
    <script>

      var url = "<?php echo base_url()?>";
      
    
    </script>
  </head>
  <body id="home">

  <div class="wrapper container-fluid">
    <div class="row">

      <header class="col-2 sticky-top">
        <a href="<?php echo base_url();?>" class="logo row">
          <img src="<?php echo base_url(); ?>public/imgs/estrutura/logo.png" alt="Giulia Domna - Lojistas">
        </a>
        <nav id="menu-principal">
          <ul>
            <li><a href="<?php echo urlTypeUser(); ?>painel" class="dashboard">Painel</a></li>
            <?php echo ($this->session->userdata("funcao") == "user") ? '<li><a href="'.base_url().'como-funciona" class="como-funciona">Como Funciona?</a></li>' : ""?>
            <?php echo ($this->session->userdata("funcao") == "user") ? '<li><a href="'.base_url().'user/contato" class="atendimento">Entre em Contato</a></li>' : ""?> 
            <?php echo ($this->session->userdata("funcao") !== "user") ? '<li><a href="'.base_url().'admin/lojistas" class="lojistas">Lojistas</a></li>' : ""?> 
            <?php echo ($this->session->userdata("funcao") !== "user") ? '<li><a href="'.base_url().'admin/usuarios" class="usuarios">Usuários</a></li>' : ""?>
            <?php echo ($this->session->userdata("funcao") !== "user") ? '<li><a href="'.base_url().'admin/relatorios" class="usuarios">Relatórios</a></li>' : ""?>
          </ul>
        </nav>
        
        <div id="menu-secundario">
          <ul>
            <li><a href="<?php echo base_url(); ?>termos-de-uso" target="_BLANK">Termos de Uso</a></li>
            <li><a href="https://www.giuliadomna.com.br/">Site Giulia Domna</a></li>
          </ul>
        </div>
      </header>
      
      <div class="col">
        <div id="barra-superior" class="row align-items-center justify-content-between">
          
          <form action="<?php echo urlTypeUser()?>painel/" class="form-inline col-auto" method="get">
          <?php if($this->session->userdata('funcao') != 'user'){ ?>
            <input type="search" name="s" class="form-control" placeholder="Busque por pedido, status, data ou protocolo">
            <button type="submit" class="btn btn-secondary">Buscar</button>
          <?php } ?>
          </form>
         

          <div id="menu-funcional" class="col-auto row align-items-center">
            <div class="notificacoes col-auto" >
              <a href="#lista-notificacoes" class="botao-notificacoes"><?php $qtd_log = count(getNotification()); if($qtd_log > 0){ echo $qtd_log; } ?></a>
              <?php if(getNotification() != null ){?>
              <div id="lista-notificacoes" class="hide">
                <ul>
                <?php foreach(getNotification() as $log): ?>
                  <li>
                    <a href="<?php echo urlTypeUser().'solicitacao/'.$log['id_solicitacao']; ?>">
                      <span class="tipo">Nova atualização</span>
                      <span class="data"><?php echo date('d/m/Y H:m', strtotime($log['data_acesso'])); ?></span>
                      <span class="titulo"><?php echo $log['descricao']; ?>!  <strong>Solicitação #<?php echo $log['id_solicitacao']; ?></strong> </span>
                    </a>
                  </li>
                  <?php endforeach;?>
                </ul>
              </div>
              <?php } ?>
            </div><!-- /end .notificacoes -->
            <div class="user col-auto row align-items-center">
            <?php if(!is_null($this->session->userdata("logo"))): ?>
              <div class="avatar col-auto">

                <img src="<?php echo $this->session->userdata("logo"); ?>" alt="<?php echo $this->session->userdata("nome_fantasia"); ?>">

              </div>
            <?php endif ?>
              <div class="menu-usuarios col-auto">

                <a href="#opcoes-menu-usuarios" class="nome-usuario">Olá, <strong><?php echo ($this->session->userdata("nome_fantasia") !== NULL ) ? $this->session->userdata("nome_fantasia") : $this->session->userdata("razao_social"); ?></strong></a>

                <ul id="opcoes-menu-usuarios" class="hide">
                  <li><a href="<?php echo urlTypeUser()?>perfil/editar">Editar Perfil</a></li>
                  <li><a href="<?php echo base_url()?>logout">Sair</a></li>
                </ul>
              </div><!-- /end .menu-usuarios -->
            </div><!-- /end .user -->
          </div><!-- /end #menu-funcional -->

        </div><!-- /end #barra-superior -->