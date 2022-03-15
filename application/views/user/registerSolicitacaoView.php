<main class="row">
  <div class="col">
  <!-- Conteúdo Página --> 

    <div class="titulo-internas">
      <h1>Nova Solicitação</h1>
      <p>Cadastre novas solicitações de devolução para a avaliação de nossa equipe.</p>
    </div>

    <section>

      <?php echo $this->session->flashdata("error") ?>

      <form action="<?php echo base_url()?>user/nova-solicitacao/cadastro" method="post" enctype="multipart/form-data">
        <div class="avisos">
            <!-- Possíveis alertas entrarão aqui -->
            <span class="aviso"></span>
        </div>
  
        <div class="listagem-itens">

            <ul>
              
              <?php if (!isset($forms)) : ?>
                <li>
                  <span class="item-numero">1</span>
                  <div class="input-texto">
                    <div class="form-group left">
                      <label for="ref-0">Ref. do Produto:</label>
                      <input type="text" class= " refe form-control " name="itens[0][referencia]" id="ref-0" placeholder="555.55/555">
                    </div>
                    <div class="form-group left">
                      <label for="qtd-0">Quantidade:</label>
                      <input type="number" class="form-control" name="itens[0][quantidade]" id="qtd-0" placeholder="Ex.: 5">
                    </div>
                    <div class="form-group clear">
                      <label for="desc-0">Descrição do Problema:</label>
                      <textarea class="form-control" name="itens[0][descricao]" id="desc-0" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                  <div class="files">
                    <label>3 Fotos do Produto: <small>JPG ou PNG - máximo 2mb</small></label>
                    <div class="input-files">
                      <input type="file" name="itens[0][]" id="foto1-0">
                      <input type="file" name="itens[0][]" id="foto2-0">
                      <input type="file" name="itens[0][]" id="foto3-0">
                    </div>
                    <div class="input-files-mascara">
                      <label class="foto1" for="foto1-0">
                        <img src="<?php echo base_url()?>public/imgs/temp/foto1.jpg" alt="">
                      </label>
                      <label class="foto2" for="foto2-0">
                        <img src="<?php echo base_url()?>public/imgs/temp/foto1.jpg" alt="">
                      </label>
                      <label class="foto3" for="foto3-0">
                        <img src="<?php echo base_url()?>public/imgs/temp/foto1.jpg" alt="">
                      </label>
                    </div>
                  </div>
                </li>
              <?php else: 

                    foreach ($forms as $key => $value) :
              ?>
                      <li>
                        <span class="item-numero">1</span>
                        <div class="input-texto">
                          <div class="form-group left">
                            <label for="ref-<?php echo $key?>">Ref. do Produto:</label>
                            <input type="text" class="form-control refe" name="itens[<?php echo $key?>][referencia]" id="ref-<?php echo $key?>" placeholder="" value="<?php echo set_value("itens[".$key."][referencia]") ?>">
                            <span><?php echo form_error("itens[".$key."][referencia]") ?></span>
                          </div>
                          <div class="form-group left">
                            <label for="qtd-<?php echo $key?>">Quantidade:</label>
                            <input type="number" class="form-control" name="itens[<?php echo $key?>][quantidade]" id="qtd-<?php echo $key?>" placeholder="Ex.: 5" value="<?php echo set_value("itens[".$key."][quantidade]") ?>">
                            <?php echo form_error("itens[".$key."][quantidade]") ?>
                          </div>
                          <div class="form-group clear">
                            <label for="desc-0">Descrição do Problema:</label>
                            <textarea class="form-control" name="itens[<?php echo $key?>][descricao]" id="desc-<?php echo $key?>" cols="30" rows="10"><?php echo set_value("itens[".$key."][descricao]") ?></textarea>
                            <?php echo form_error("itens[".$key."][descricao]") ?>
                          </div>
                        </div>
                        <div class="files">
                          <label>3 Fotos do Produto: <small>JPG ou PNG - máximo 2mb</small></label>
                          <div class="input-files">
                            <input type="file" name="itens[<?php echo $key?>][]" id="foto1-<?php echo $key?>" value="<?php //echo isset($images[$key][0][0]["name"]) ? "C:\\fakepath\\" . $images[$key][0][0]["name"] : "" ?>">
                            <input type="file" name="itens[<?php echo $key?>][]" id="foto2-<?php echo $key?>" value="<?php //echo isset($images[$key][1][0]["name"]) ? "C:\\fakepath\\" . $images[$key][1][0]["name"] : "" ?>">
                            <input type="file" name="itens[<?php echo $key?>][]" id="foto3-<?php echo $key?>" value="<?php //echo isset($images[$key][2][0]["name"]) ? "C:\\fakepath\\" . $images[$key][2][0]["name"] : "" ?>">
                          </div>
                          <div class="input-files-mascara">

                            <label class="foto1" for="foto1-<?php echo $key?>">

                              <?php if (isset($images[$key][0][0]["src"])) : ?>
                                <!-- <img style="display: block;" src="<?php echo $images[$key][0][0]["src"]?>" alt=""> -->
                              <?php else:  ?>
                                <img src="<?php echo base_url()?>public/imgs/temp/foto1.jpg" alt="">
                              <?php endif; ?>

                            </label>
                            <label class="foto2" for="foto2-<?php echo $key?>">
                            
                              <?php if (isset($images[$key][1][0]["src"])) : ?>
                                <!-- <img style="display: block;" src="<?php echo $images[$key][1][0]["src"]?>" alt=""> -->
                              <?php else:  ?>
                                <img src="<?php echo base_url()?>public/imgs/temp/foto1.jpg" alt="">
                              <?php endif; ?>
                              
                            </label>
                            <label class="foto3" for="foto3-<?php echo $key?>">

                              <?php if (isset($images[$key][2][0]["src"]))  : ?>
                                <!-- <img style="display: block;" src="<?php echo $images[$key][2][0]["src"]?>" alt=""> -->
                              <?php else:  ?>
                                <img src="<?php echo base_url()?>public/imgs/temp/foto1.jpg" alt="">
                              <?php endif; ?>

                            </label>
                            <?php echo $this->session->flashdata("error_image") ?>
                          </div>
                        </div>
                      </li>
              <?php              
                    endforeach;
              
                endif;
              ?>

            </ul>
            <div class="adicionar-wrapper">
              <button type="button" id="adicionar-item" class="btn btn-info btn-lg">Adicionar Item +</button>
            </div>
        </div>
        <div class="botao-salvar">
          <button type="submit" class="btn btn-primary btn-lg btn-block">SALVAR EDIÇÕES DA SOLICITAÇÃO</button>
        </div>
      </form>
    </section>
    

<!-- /end Conteúdo Página -->
  </div>
</main>