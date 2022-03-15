<?php 
      $operador = '';
      $admin = '';
      $checked = '';
      $status = 'Desativado';
      if($profile[0]->funcao == 'admin'){
        $admin = 'selected';
      }else{
        $operador = 'selected';
      }
      if($profile[0]->status > 0){
        $checked = 'checked';
        $status = 'Ativo';
      }
  ?>
<main class="row">
        <div class="col">
        <!-- Conteúdo Página --> 
          <?php if(!empty($admin)){ ?>
          <div class="titulo-internas">
            <h1>Atualizar Dados de Usuário - Operadores e Administradores</h1>
            <p>Atualize informações dos operadores e administradores do sistema.</p>
          </div>
          <?php }else{ ?>
            <div class="titulo-internas">
            <h1>Atualizar Dados de Lojista</h1>
            <p>Atualize informações dos lojistas cadastrados no sistema.</p>
          </div>
          <?php } ?>
          
          <section>

            <?php if ($this->session->flashdata('error')) { ?>
              <?= $this->session->flashdata('error') ?>
            <?php } ?>

            <?php if ($this->session->flashdata('success')) { ?>
              <?= $this->session->flashdata('success') ?>
            <?php } ?>

            <form action="<?php echo base_url(); ?>admin/usuarios/atualizar/update" class="form-standalone" method="POST">
                <div class="form-group">
                <input type="hidden"  name="id" id="id" value="<?php echo $profile[0]->id;?>">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $profile[0]->nome ?>" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $profile[0]->email ?>" placeholder="">
                </div>
                <?php if(!empty($admin)){ ?>
                  <div class="form-group">
                    <label for="funcao">Função:</label> 
                    <select class="form-control" name="funcao" id="funcao">
                      <option value="operador" <?php echo $operador ?>>Operador</option>
                      <option value="admin" <?php echo $admin ?>>Administrador</option>
                      <option value="">Escolha uma Função</option>
                    </select>
                  </div>
                  <?php } ?>

                
                
                <div class="form-group">
                    <label for="Definir Senha">Senha:</label>
                    <input type="password" class="form-control" name="senha" id="senha" value="" placeholder="Digite se quiser mudar a senha">
                </div>

                <label for="status">Status:</label>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input"  name="status" id="statusCheck" <?php echo $checked ?>>
                  <label class="custom-control-label status" id="statuslabel" for="statusCheck" ><?php echo $status ?></label>
                  
                </div>
                <br/>
                

                <button class="btn btn-primary">Atualizar Dados</button>
            </form>
            

          </section>
          

      <!-- /end Conteúdo Página -->
        </div>
        
      </main>

    
      <script>
        $("#statusCheck").click(function() {  
          $("#statuslabel").text(this.checked ? "Ativo" : "Desativado");
        });
      </script>
    