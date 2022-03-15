<main class="row">
        <div class="col">
        <!-- Conteúdo Página --> 
      
          <div class="titulo-internas">
            <h1>Cadastro de Usuários - Operadores e Administradores</h1>
            <p>Cadastre um novo administrador ou operador do sistema.</p>
          </div>
          
          <section>
          <?php if ($this->session->flashdata('error')) { ?>
            <?= $this->session->flashdata('error') ?>
          <?php } ?>

          <?php if ($this->session->flashdata('success')) { ?>
            <?= $this->session->flashdata('success') ?>
          <?php } ?>
            <form action="<?php echo base_url(); ?>admin/create" method="POST" class="form-standalone">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="">
                </div>
                <div class="form-group">
                  <label for="funcao">Função:</label> 
                  <select class="form-control" name="funcao" id="funcao">
                    <option value="operador">Operador</option>
                    <option value="admin">Administrador</option>
                    <option value="" selected="selected">Escolha uma Função</option>
                  </select>
                </div>
                <div class="form-group">
                    <label for="Definir Senha">Senha:</label>
                    <input type="password" class="form-control" name="senha" id="senha" placeholder="">
                </div>
                <div class="form-group">
                    <label for="Confirmar Senha">Confirmar senha:</label>
                    <input type="password" class="form-control" name="senha-confirmada" id="senha" placeholder="">
                </div>
                <button class="btn btn-primary">Cadastrar Usuário</button>
            </form>

          </section>
          

      <!-- /end Conteúdo Página -->
        </div>
      </main>