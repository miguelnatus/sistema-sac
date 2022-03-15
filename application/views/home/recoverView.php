

<div class="wrapper container-fluid">
  <div class="row justify-content-center align-items-center full-height">
  
  <div class="col-4">
    <div class="login-box">
      <header>
        <img src="<?php echo base_url(); ?>./public/imgs/estrutura/logo.png" alt="Giulia Domna" class="logo">
      </header>
      <div class="statement">
        <p>Se você tiver um cadastro de lojista na Giulia Domna, você receberá no seu email, uma nova senha para acessar a sua conta.</p>
      </div>
      <form action="<?php echo base_url(); ?>recover" method="POST">
          <div class="form-group">
            <input type="text" class="form-control" name="cnpj" id="cnpj"  placeholder="CNPJ da sua Empresa" maxlength="18" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required>
          </div>
          
          <button class="btn btn-primary btn-block clear">Enviar senha</button>
      </form>
    </div>
    <?php if ($this->session->flashdata('error')) { ?>
          <?= $this->session->flashdata('error') ?>
    <?php } ?>

     <?php if ($this->session->flashdata('success')) { ?>
          <?= $this->session->flashdata('success') ?>
    <?php } ?>
    <p class="aviso-formulario"><a href="<?php echo base_url(); ?>">&laquo; Voltar para o Login</a></p>
  </div>

  </div><!-- /end .row inicial -->
  </div><!-- /end .wrapper -->
