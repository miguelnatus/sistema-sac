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
      
          <div class="titulo-internas">
            <h1>Atualizar Senha de Usuário - Operadores e Administradores</h1>
            <p>Atualize a senha dos operadores e administradores do sistema. Eles serão notificados da alteração</p>
          </div>
          
          <section>

            <?php if ($this->session->flashdata('error')) { ?>
              <?= $this->session->flashdata('error') ?>
            <?php } ?>

            <?php if ($this->session->flashdata('success')) { ?>
              <?= $this->session->flashdata('success') ?>
            <?php } ?>

            <form action="<?php echo base_url(); ?>admin/usuarios/atualizar/senha/update" class="form-standalone" method="POST">
                
                <div class="form-group">
                <input type="hidden"  name="id" id="id" value="<?php echo $profile[0]->id;?>">
                    <label for="email">CNPJ:</label>
                    <input type="text" class="form-control" name="cnpj" id="cnpj" value="<?php echo $profile[0]->cnpj ?>" readonly="true">
                </div>
               

                
                
                <div class="form-group">
                    <label for="Definir Senha">Senha:</label>
                    <input type="password" class="form-control" name="senha" id="senha" value="senhaficticia" disabled>
                </div>

               
                

                <button class="btn btn-primary">Atualizar Senha</button>
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
    