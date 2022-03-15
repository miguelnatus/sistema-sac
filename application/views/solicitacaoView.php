<main class="row">
    <div class="col">
    <!-- Conteúdo Página --> 
<!-- <?php print_r($solicitacaoStatus);?> -->
      <div class="titulo-internas">
        <h1>Nova Solicitação</h1>
        <p>Cadastre novas solicitações de devolução para a avaliação de nossa equipe.</p>
      </div>
      
      <section>

          <div class="avisos">
              <?php echo $this->session->flashdata("success"); ?>
          </div>
          <?=form_open_multipart(urlTypeUser()."solicitacao/update"); ?>
          <div class="solicitacao-infos">
            <h2>Número da Solicitação: <?php echo $id_solicitacao; ?></h2>
            <div class="status-solicitacao status left">
              <!-- <h4 class="status-flag <?php echo statusToCssClass($status_solicitacao[0]->nome);?>"><?php echo $status_solicitacao[0]->nome?></h4> -->
                <select class="form-control"  name="statusSolicitacao" <?php if($user[0]->funcao == 'user'){ echo 'disabled';} ?>>
                        
                        <?php foreach ($listaStatusSolicitacao as $value):  ?>
                        <option <?php if($solicitacaoStatus[0]->id_status_solicitacao == $value->id){ echo 'selected'; } ?> value="<?php echo $value->id; ?>"><?php echo $value->nome; ?></option>
                        <?php endforeach; ?>
                        
                  </select>
              
            </div>
            <div class="datas">
              <span>criado: <?php echo dateFormat($solicitacoesItens[0]->data_criacao); ?></span>
              <span>última atualização: <?php echo dateFormat($data_atualizacao); ?></span>
            </div>
          </div>
          
          <div class="listagem-itens">
            <input type="hidden" name="id_solicitacao" value="<?php echo $solicitacoesItens[0]->id_solicitacao; ?>">
              <ul>
                <?php foreach($solicitacoesItens as $key => $item): ?>
                <li>
                  <input type="hidden" name="itens[<?php echo $key?>][id_item]" value="<?php echo $item->id_item; ?>">
                  <span class="item-numero"><?php echo $key + 1; ?></span>
                  <div class="input-texto">
                    <div class="form-group left">
                      <label for="ref-1">Ref. do Produto:</label>
                      <input type="text" class="form-control" name="itens[<?php echo $key?>][referencia]" id="ref-<?php echo $key?>" placeholder="" value="<?php echo $item->referencia; ?>" <?php if($this->session->userdata("funcao")!=='admin'){ echo 'disabled';} ?>>
                    </div>
                    <div class="form-group left">
                      <label for="qtd-1">Quantidade:</label>
                      <input type="text" class="form-control" name="itens[<?php echo $key?>][quantidade]" id="qtd-<?php echo $key?>" placeholder="Ex.: 5" value="<?php echo $item->quantidade; ?>" <?php if($user[0]->funcao!='admin'){ echo 'disabled';} ?>>
                    </div>

                    <?php if($user[0]->funcao !=='user') : ?>
                      <div class="form-group left">
                        <label for="problema-1">Tipo de Problema:</label>
                        <select class="form-control" name="itens[<?php echo $key?>][id_tipo_problema]" id="problema-<?php echo $key?>">
                        <?php foreach ($tipoProblema as $value): ?>
                        <option value="<?php echo $value->id; ?>" <?php if($item->id_tipo_problema==$value->id){ echo 'selected'; } ?> ><?php echo $value->nome; ?></option>
                        <?php endforeach; ?>
                        </select>
                      </div>
                    <?php endif; ?> 

                    <div class="form-group clear">
                      <label for="desc-1">Descrição do Problema:</label>
                      <textarea class="form-control" name="itens[<?php echo $key?>][descricao]" id="desc-<?php echo $key?>" cols="30" rows="10" <?php if($user[0]->funcao!='admin'){ echo 'disabled';} ?>><?php echo $item->descricao; ?></textarea>
                    </div>
                  </div>
                  <div class="files">
                    <label>3 Fotos do Produto: <small>JPG ou PNG - máximo 2mb</small></label>
                    <div class="input-files">
                      <input type="file" name="foto1-1" id="foto1-1">
                      <input type="file" name="foto2-1" id="foto2-1">
                      <input type="file" name="foto3-1" id="foto3-1">
                    </div>
                    <div class="input-files-mascara">
                      <div class="input-files-mascara">
                        <?php 
                          foreach ($fotos[$key] as $foto): 
                            if($foto->id_item == $item->id_item): 
                        ?>
                              <label class="foto">
                                <a href="<?php echo $foto->url; ?>" target="_BLANK"><img src="<?php echo $foto->url; ?>" alt=""></a>
                              </label>  
                        <?php 
                            endif; 
                          endforeach; 
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="status-item status clear">
                    <div class="form-group right">
                      <label for="status-item-1">Status: </label> 
                      <select class="form-control" name="itens[<?php echo $key?>][id_status]" id="status-item-<?php echo $key?>" <?php if($user[0]->funcao!='admin'){ echo 'disabled';} ?>>
                        
                        <?php foreach ($status as $value):  ?>
                          <option value="<?php echo $value->id; ?>" <?php if($item->id_status == $value->id){ echo 'selected'; } ?> ><?php echo $value->nome; ?></option>
                        <?php endforeach; ?>
                        
                      </select>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
              </ul>
              <!-- <div class="adicionar-wrapper">
                <button id="adicionar-item" class="btn btn-info btn-lg">Adicionar Item +</button>
              </div> -->
              <?php if($user[0]->funcao=='admin'): ?>
              <div class="botao-salvar">
                <button class="btn btn-primary btn-lg btn-block">ATUALIZAR INFORMAÇÕES</button>
              </div>
            <?php endif; ?>
          </div>
            </form> 
          
          <?php if($status_solicitacao[0]->nome!=='Aberto'): ?>
            <div class="notas-fiscais">
              <?php if(!empty($notas)and$status_solicitacao[0]->nome!='Aberto'): ?>
              <h2>Notas Fiscais</h2>
              <?php endif; ?> 
              <ul class="lista-notas">
                <?php foreach ($notas as $nota): ?>
                <li class="nota-cadastrada">
                  
                  <span>Número da Nota: <strong><?php echo $nota->nota; ?></strong></span>
                  <a href="<?php echo $nota->url; ?>" target="_blank">Ver nota Cadastrada</a>
                  <a href="<?php echo base_url().'solicitacao/excluirNota/'.$id_solicitacao.'/'.$nota->id; ?>">Deletar Nota</a>
                </li>
                <?php endforeach; ?>
                  <?php if($user[0]->funcao!='admin'): ?>
                  <?=form_open_multipart("solicitacao/cadastrarNota"); ?>
                  <li>
                      <div class="form-group left">
                        <label for="numero-nota-1">Número da Nota:</label>
                        <input type="text" class="form-control" name="numero-nota-1" <?php //echo set_value('numero-nota-1'); ?> id="numero-nota-1">
                      </div>
                      
                      <div class="form-group left">
                        <p>Envie a nota: <small>PDF, JPG ou PNG - máximo 2mb</small></p>
                        <div class="form-group left">
                          <input type="file" class="form-control-file" name="arquivo-nota-1" id="exampleFormControlFile1">
                          <input type="hidden"  name="id-solicitacao" value="<?php echo $id_solicitacao; ?>" >
                        </div>
                      </div>
                  </li>
                    
                  <!-- <div class="adicionar-wrapper">
                    <button id="adicionar-item" class="btn btn-info btn-lg">+</button>
                  </div> -->

                  <div class="botao-salvar">
                    <button class="btn btn-primary btn-lg btn-block">ADICIONAR NOTA</button>
                  </div> 
                   </form>
                  <?php endif; ?>
                </ul>
              
              
            </div>
          <?php endif; ?>
                   
      
          <div id="mensagens">
            <h2>Mensagens da Solicitação</h2>
            <div class="mensagens-wrapper">
            <div class="escrever-mensagem">
                <div class="autor left">
                  <div class="avatar">
                    <?php if(!empty($this->session->userdata('logo'))) { ?>
                    
                        <img src="<?php echo $this->session->userdata('logo'); ?>" alt="<?php echo $this->session->userdata("razao_social"); ?>">

                    <?php }else{ ?>  

                        <p><?php echo $this->session->userdata("razao_social"); ?></p>

                    <?php } ?>  
                  </div>
                </div>
                <form action="<?php echo base_url('solicitacao/enviarMensagem'); ?>" method="post" class="right" enctype="multipart/form-data" >
                  
                  <div class="form-group">
                      <input type="hidden"  name="id_solicitacao" value="<?php echo $id_solicitacao; ?>" >
                      <textarea class="form-control" name="nova-mensagem" id="nova-mensagem" cols="30" rows="10"></textarea>
                      
                      <span class="btn btn-default btn-file anexo">

                        <img src="<?php echo base_url(); ?>public/imgs/estrutura/file-icon.png" alt="">Anexar
                        <input type="file" class="form-control-file" name="anexo-msg" id="exampleFormControlFile1">

                      </span>
                      <p>
                        <?php echo $this->session->flashdata('error') ?>
                        <?php echo $this->session->flashdata('success') ?>
                      </p>
                  </div>
                  <button class="btn btn-primary">Enviar</button>
                </form>
            </div>
           
            <div class="lista-mensagens">
              
              <!-- 
                IMPORTANTE
                As mensagens dos lojistas levam a classe .lojista e a da Giuila a classe .giulia-domna
                as classes são inseridas no elemento que está ao redor de cada mensagem e que contem também a classe .msg
              -->
              <?php foreach ($mensagens as $mensagem): ?>
              <?php 
                if($mensagem->id_usuario==$_SESSION['id']): 

              ?>

              <div class="msg lojista">
                
                <div class="autor">
                  <div class="avatar">
                      <?php if(!empty($this->session->userdata('logo'))) { ?>
                    
                        <img src="<?php echo $this->session->userdata('logo'); ?>" alt="<?php echo $this->session->userdata("razao_social"); ?>">

                      <?php }else{ ?>  

                        <p><?php echo $this->session->userdata("razao_social"); ?></p>

                      <?php } ?>  
                  </div>
                  <small>em <?php echo $mensagem->data; ?></small>
                </div>
                <div class="texto-mensagem" <?php if($this->session->userdata('funcao') == "admin"){ echo 'oncontextmenu="return false;"';} ?> id="<?php echo $mensagem->id; ?>">
                  <p>
                      <?php echo nl2br($mensagem->mensagem); ?><br />
                      <?php if($mensagem->anexo!=NULL): ?>
                      
                      <a href="<?php echo $mensagem->anexo; ?>" target="_BLANK"><?php echo nl2br($mensagem->anexo); ?></a>
                      <?php endif; ?>
                  </p>
                </div>
          
              </div>
              <?php else:  ?>
              <div class="msg giulia-domna">
                <div class="autor">
                  <div class="avatar">
                      <img src="<?php echo base_url(); ?>public/imgs/estrutura/logo.png" alt="Nome da marca do usuário">
                  </div>
                  <small>em <?php echo $mensagem->data; ?></small>
                </div>
                <div class="texto-mensagem" <?php if($this->session->userdata('funcao') == "admin"){ echo 'oncontextmenu="return false;"';} ?> id="<?php echo $mensagem->id; ?>">
                  <p>
                      <?php echo $mensagem->mensagem; ?><br />
                      <?php if($mensagem->anexo!=NULL): ?>
                      
                      <a href="<?php echo $mensagem->anexo; ?>" target="_BLANK"><?php echo $mensagem->anexo; ?></a>
                      <?php endif; ?>
                  </p>
                </div>
              </div>
              <?php endif; ?>
              <?php endforeach; ?>


            </div>
            </div>
          </div>

      </section>
      

  <!-- /end Conteúdo Página -->
    </div>
  </main>
 <script>
   
</script>