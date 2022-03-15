<main class="row">
        <div class="col">
        <!-- Conteúdo Página --> 
      
          <div class="titulo-internas">
            <h1>Usuários - Operadores e Administradores</h1>
            <p>Gerencie o acesso do pessoal da Giulia Domna responsável por gerenciar e operar o sistema.</p>
          </div>
          
          <section>
            <div class="section-controles">
              <p>
                  Gerencie os usuários administradores e operadores,<br>
                  atribuindo funções e mantendo a lista atualizada.
              </p>
              <a href="<?php echo base_url()?>admin/usuarios/cadastro" class="btn btn-outline-secondary">Cadastrar Novo Usuário +</a>
            </div>
            <table class="table table-striped administrativa">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">E-mail</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Função</th>
                  <th scope="col">Status</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>
             
                <!-- Início Loop -->
                <?php foreach ($users as $key=>$value) : 

                      if($users[$key]->status>0){
                        $check = 'Ativo';
                      }else{
                        $check='Desativado';
                      }  

                ?>
                      <tr>
                        <th scope="row"><?php echo $users[$key]->email; ?></th>
                        <td><?php echo $users[$key]->nome;?></td>
                        <td><?php echo $users[$key]->funcao;?></td>
                        <td>
                          <div class="form-check">

                            <div class="custom-control custom-checkbox">
                                <input data-id="<?php echo $users[$key]->id;?>" type="checkbox" class="custom-control-input" id="status-<?php echo $users[$key]->id; ?>" <?php echo ($users[$key]->status == 1) ? "checked" : ""?>>
                                <label class="custom-control-label" for="status-<?php echo $users[$key]->id; ?>">Ativo</label>
                            </div>

                          </div>
                        </td>
                        <td>
                          <a href="<?php echo base_url()?>admin/usuarios/atualizar/senha/<?php echo $users[$key]->id ?>" class="reset-password">Resetar Senha</a>
                          <a href="<?php echo base_url()?>admin/usuarios/atualizar/<?php echo $users[$key]->id ?>" class="edit">Editar</a>
                          <a href="#" class="delete">Deletar</a>
                        </td>
                      </tr>  

                <?php
                  endforeach;
                ?>
                  
                </tr>
                <!-- /END Loop -->

              
                 
              </tbody>
            </table>
            
            <p class="meta-dados-table">Mostrando 1 à 20 de 1000 solicitações</p>
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>

          </section>
          

      <!-- /end Conteúdo Página -->
        </div>
      </main>