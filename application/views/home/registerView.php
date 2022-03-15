<div class="wrapper container-fluid">
  <div class="row justify-content-center align-items-center full-height">
  
  <div class="col-4">
    <div class="login-box">
      <header>
        <img src="<?php echo base_url(); ?>./public/imgs/estrutura/logo.png" alt="Giulia Domna" class="logo">
        <h1>Cadastro</h1>
      </header>
      <div class="statement">
        <p><strong>Para criar um usuário você deve ser um lojista cliente da Giulia Domna.</strong></p>
        <p>Todos lojistas são pré-cadastrados, use os campos abaixo para completar seu cadastro e criar uma senha.</p>
      </div>
      <form action="<?php echo base_url(); ?>registrar" method="POST">
          <div class="form-group">
            <input type="text" class="form-control" name="cnpj" id="cnpj"  placeholder="CNPJ da Empresa (Será usado para login)" maxlength="18" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="email" id="email" placeholder="Seu E-mail" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="senha" id="senha" placeholder="Crie uma Senha" minlength="6" maxlength="20" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="senha-confirmada" id="confirmar-senha" placeholder="Confirmar Senha" required>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="lembrar" id="lembrar" required>
            <label for="lembrar">Aceito os <a href="<?php echo base_url(); ?>termos-de-uso" target="_BLANK">Termos de Uso</a></label>
          </div>
          
          
          <button class="btn btn-primary btn-block clear">Entrar</button>
      </form>
      <?php if ($this->session->flashdata('error')) { ?>
          <?= $this->session->flashdata('error') ?>
    <?php } ?>
    <?php if ($this->session->tempdata('error')) { ?>
          <?= $this->session->tempdata('error') ?>
    <?php } ?>
    </div>
    <p class="aviso-formulario"><a href="<?php echo base_url(); ?>">&laquo; Voltar para o Login</a></p>
  </div>
  
  </div><!-- /end .row inicial -->
  </div><!-- /end .wrapper -->
 