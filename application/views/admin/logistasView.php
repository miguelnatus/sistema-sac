<main class="row">
        <div class="col">
        <!-- Conteúdo Página --> 
      
          <div class="titulo-internas">
            <h1>Lista de Lojistas</h1>
            <p>Gerencie o acesso dos lojistas cadastrados ao sistema.</p>
          </div>
          
          <section>
            <div class="section-controles">
              <p>
                Gerencie os lojistas cadastrados.<br>
                O pré-cadastro não é realizado aqui,<br>
                deve ser feito manualmente pela planilha.
              </p>
              <form action="<?php echo urlTypeUser()?>lojistas/" class="busca-lojistas">
                <div class="form-group">
                  <input type="search" class="form-control" name="sl" id="busca-lojistas" placeholder="Nome, Razão Social, CNPJ ou e-mail do lojista">
                </div>
                <button class="btn btn-secondary">Buscar Lojista</button>
              </form>
            </div>
            <table class="table table-striped administrativa">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Fantasia</th>
                  <th scope="col">Razão Social</th>
                  <th scope="col">CNPJ</th>
                  <th scope="col">Proprietário</th>
                  <th scope="col">Endereço</th>
                  <th scope="col">Status</th>
                  <th scope="col">Ações</th>
                </tr>
              </thead>
              <tbody>

                <!-- Início Loop -->
                <?php foreach ($lojistas as $lojista) : ?>
                  <tr>
                    <th scope="row"><?php echo ($lojista->nome_fantasia == NULL) ? $lojista->nome : $lojista->nome_fantasia; ?></th>
                    <td><?php echo $lojista->razao_social; ?></td>
                    <td><?php echo $lojista->cnpj; ?></td>
                    <td><?php echo $lojista->nome; ?></td>
                    <td><?php echo $lojista->endereco; ?></td>
                    <td>
                        <div class="form-check">

                          <div class="custom-control custom-checkbox">
                              <input data-id="<?php echo $lojista->id;?>" type="checkbox" class="custom-control-input" id="status-<?php echo $lojista->id; ?>" <?php echo ($lojista->status == 1) ? "checked" : ""?>>
                              <label class="custom-control-label" for="status-<?php echo $lojista->id; ?>">Ativo</label>
                          </div>
                          
                        </div>
                    </td>
                    <td>
                      <a href="<?php echo base_url()?>admin/usuarios/atualizar/<?php echo $lojista->id;?>" class="edit">Editar</a>
                      <a href="#" class="delete">Deletar</a>
                    </td>
                  </tr>
                <?php endforeach; ?> 
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