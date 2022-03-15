<main class="row">
        <div class="col">
        <!-- Conteúdo Página --> 
      
          <div class="titulo-internas">
            <h1>Perfil do Usuário</h1>
            <p>Mantenha seus dados atualizados para facilitar o contato com nossa equipe de atendimento.</p>
          </div>
          
          <section>

          <?php echo $this->session->flashdata('error') ?>
          <?php echo $this->session->flashdata('success') ?>

            <form action="<?php echo urlTypeUser();?>update" method="POST" class="left dados-responsavel" enctype="multipart/form-data">
              <h2>Dados de Contato</h2>
              <div class="form-group upload-logo left">
                  <p>Envie a nota: <small>PDF, JPG ou PNG - máximo 2mb</small></p>
                  <div class="custom-file left">
                    <input type="file" class="custom-file-input" name="logo" id="logo-empresa">
                    <label class="custom-file-label" for="logo-empresa">Escolha um arquivo</label>
                  </div>
              </div>
             
              <div class="logo-empresa right">
                  <img src="<?php echo $this->session->userdata("logo"); ?>" alt="<?php echo ($this->session->userdata("nome_fantasia")); ?>"> 
                </div>
              

              <div class="form-group clear">
                <label for="empresa">Empresa:</label>
                <input type="text" class="form-control" name="nome_fantasia" id="empresa" placeholder="Nome fantasia da empresa (Como você será chamado)" value="<?php echo ($this->session->userdata("nome_fantasia") == NULL) ? "" : $this->session->userdata("nome_fantasia"); ?>">
              </div>
              <div class="form-group">
                <label for="nome-responsavel">Nome do Responsável:</label>
                <input type="text" class="form-control" name="nome" id="nome-responsavel" placeholder="Nome completo" value="<?php echo $this->session->userdata("nome")?>">
              </div>
              <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="E-mail para contato com fábrica" value="<?php echo $this->session->userdata("email")?>">
              </div>
              <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone para contato com a fábrica" value="<?php echo $this->session->userdata("telefone")?>">
              </div>
              <button class="btn btn-primary atualizar-perfil">Atualizar</button>
            </form>

            <div class="dados-empresa right">
              <h2>Dados da Empresa</h2>
              <p class="statement">
                Estes são os dados da empresa que constam em nosso sistema. Caso haja alguma informação errada por 
                favor entre em contato com nosso setor comercial pelo telefone (51) 5555-5555 ou pelo e-mail email@email.com.
              </p>
              <p><strong>CNPJ:</strong> <?php echo $this->session->userdata("cnpj"); ?></p>
              <p><strong>Razão Social:</strong> <?php echo $this->session->userdata("razao_social"); ?></p>
              <p>
                <strong>Endereço:</strong><br>
                <?php echo $this->session->userdata("endereco"); ?>
              </p>
              <p><strong>Proprietário:</strong> <?php echo $this->session->userdata("nome"); ?></p>
            </div>

          </section>
          

      <!-- /end Conteúdo Página -->
        </div>
      </main>