

<div class="wrapper container-fluid">
  <div class="row justify-content-center align-items-center full-height">
  
  <div class="col-md-4">
    <h1 style="text-align: center; display: block; color:#fff; float:inherit;">Atenção!</h1>
    <p class="aviso-formulario">Acompanhando a movimentação mundial em relação ao controle do Covid-19 e seguindo orientações dos órgãos competentes, nosso plano de contingência afetará o atendimento de solicitações feitas em nosso painel de lojistas. Todas as avaliações e solicitações estarão suspensas por tempo indeterminado. Avisaremos a todos o reinício das operações.<br/>Agradecemos a compreensão de todos.</p>
    <div class="login-box">
      <header>
        <img src="<?php echo base_url(); ?>./public/imgs/estrutura/logo.png" alt="Giulia Domna" class="logo">
      </header>
      <form action="<?php echo base_url(); ?>login" method="POST">
          <div class="form-group">
            <input type="text" class="form-control" name="cnpj" id="email" placeholder="CNPJ" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required> 
          </div>
          
          <a href="<?php echo base_url(); ?>recuperar-senha" class="esqueceu-senha-link">Esqueceu sua senha?</a>
          <button class="btn btn-primary btn-block clear">Entrar</button>
      </form>
    </div>
    <?php if ($this->session->flashdata('error')) { ?>
          <?= $this->session->flashdata('error') ?>
    <?php } ?>

     <?php if ($this->session->flashdata('success')) { ?>
          <?= $this->session->flashdata('success') ?>
    <?php } ?>
    <p class="aviso-formulario">Ainda não está cadastrado? <a href="<?php echo base_url(); ?>home/cadastro">Crie sua conta!</a></p>
  </div>

  </div><!-- /end .row inicial -->
  </div><!-- /end .wrapper -->
