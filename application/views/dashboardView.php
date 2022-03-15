
    <main class="row">
        <div class="col">
 
        <!-- Conteúdo Página --> 
      	  <?php //print_r($user[0]); ?>
          <div class="topo-home">

          <?php if(!is_null($this->session->userdata("logo"))): ?>

            <div class="logo-cliente-home">
                <img src="<?php echo $this->session->userdata("logo"); ?>" alt="<?php echo $this->session->userdata("nome_fantasia"); ?>"> 
            </div>
           
          
          <?php endif ?>
            
            <div class="informacoes-topo">
              <div>
                <p class="nome-cliente h1"><?php echo ($this->session->userdata("nome_fantasia") !== NULL ) ? $this->session->userdata("nome_fantasia") : $this->session->userdata("razao_social"); ?></p>
                <a href="<?php echo urlTypeUser()?>perfil/editar" class="edit-perfil btn btn-outline-light">Editar Perfil</a>
              </div>
              <div class="resumo">
                <div style="display:none;">
                <p>Solicitações em Aberto: <span>5</span></p>
                <p>Comentários: <span>5</span></p>
                <p>Notificações: <span>5</span></p>
                </div>
                <?php if($_SESSION['funcao'] == 'user'){ ?>
                  <a href="<?php echo base_url(); ?>user/nova-solicitacao" class="btn btn-primary">Nova Solicitação</a>
                <?php } ?>
              </div>
            </div>
          </div>
          <!--<div id="aviso-ferias" class="container">
            <div class="row">
              
              <div class="aviso-ferias alert alert-warning col-sm-10" role="alert">
                <div class="col-sm-1">
                  <img src="https://img.icons8.com/officel/40/000000/warning-shield.png" class="img-fluid">
                </div>
                <div class="col-sm-11">
                  Prezado Cliente, informamos que estaremos de férias coletivas entre os dias 18/12 até 07/01/2020.
                  Solicitações enviadas dentro desse período serão respondidas após o dia 08/01. Agradecemos a compreensão.
                </div>
              </div>
            </div>
          </div>-->

          <section class="solicitacoes">
            <div class="avisos">
                <!-- Possíveis alertas entrarão aqui -->
                
            </div>
            <div class="callout">
              <h1>Giulia Domna - Troca Lojistas</h1>
              <p>
                Um portal para que você, lojista, possa manter um controle preciso com nosso atendimento.<br>
                Aqui você pode monitorar o andamento e manter histórico de todas as solicitações de trocas de produtos.
              </p>
            </div>

             <?php if ($this->session->flashdata('error')) { ?>
          <?= $this->session->flashdata('error') ?>
    <?php } ?>

     <?php if ($this->session->flashdata('success')) { ?>
          <?= $this->session->flashdata('success') ?>
    <?php } ?>

    <!-- Para ORDENAÇÃO -->
    <?php

    $orderQtd = 'max';
    $orderData = 'min';
    $orderStatus = 'aberto';

    $order = $this->input->get();

    if(isset($order['qtd'])){
      $orderQtd = $order['qtd'];
      if($orderQtd == 'max'){
        $orderQtd = 'min';
      }else if($orderQtd == 'min'){
        $orderQtd = 'default';
      }else if($orderQtd == 'default'){
        $orderQtd = 'max';
      }
    }else if(isset($order['data'])){
      $orderData = $order['data'];
      if($orderData == 'min'){
        $orderData = 'default';
      }else if($orderData == 'default'){
        $orderData = 'min';
      }
    }else if(isset($order['status'])){
      $orderStatus = $order['status'];
      if($orderStatus == 'aberto'){
        $orderStatus = 'finalizado';
      }else if($orderStatus == 'finalizado'){
        $orderStatus = 'default';
      }
    }

    ?>

    <!-- Fim ORDENAÇÃO -->

            <h2>Solicitações</h2>
            <table class="table table-striped table-hover table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Solicitação</th>

                  <?php if ($this->session->userdata("funcao") !== "user") : ?>
                       <th scope="col">Cliente</th>
                  <?php endif; ?>

                  <th scope="col">Qtd de Produtos <form action="<?php echo urlTypeUser()?>painel/" method="get">
                    <button type="submit" name="qtd" value="<?php echo $orderQtd; ?>">
                      <img src="<?php echo base_url();
                        if($orderQtd == 'min'){
                          echo'public/imgs/estrutura/icones/sort-asc.png';
                        }else if($orderQtd == 'max'){
                          echo'public/imgs/estrutura/icones/sort.png';
                        }else{
                          echo'public/imgs/estrutura/icones/sort-normal.png';
                        }
                    ?>" alt="Ordenar">
                    </button>
                     
                    </form>
                  </th>
                  <th scope="col">Nota Fiscal</th>
                  <th scope="col">Data <form action="<?php echo urlTypeUser()?>painel/" method="get">
                  <button type="submit" name="data" value="<?php echo $orderData; ?>">
                  <img src="<?php echo base_url();
                      if($orderData == 'min'){
                        echo'public/imgs/estrutura/icones/sort.png';
                      }else{
                        echo'public/imgs/estrutura/icones/sort-asc.png';
                      }
                  ?>" alt="Ordenar"></button>
                     
                    </form></th>
                  <th scope="col">Ultima Atualização </th>
                  <th scope="col">Status <form action="<?php echo urlTypeUser()?>painel/" method="get">
                  <button type="submit" name="status" value="<?php echo $orderStatus; ?>">
                  <img src="<?php echo base_url();
                    if($orderStatus == 'aberto'){
                      echo'public/imgs/estrutura/icones/aberto.png';
                    }else if($orderStatus == 'finalizado'){
                      echo'public/imgs/estrutura/icones/finalizado.png';
                    }else{
                      echo'public/imgs/estrutura/icones/default.png';
                    }
                  ?>" alt="Ordenar"></button>
                     
                    </form> </th>
                </tr>
              </thead>
              <tbody>
             
                <?php foreach ($solicitacoes as $solicitacao): ?>
                
                <!-- Início Loop 1 -->
                <tr>
                    <th scope="row"><a href="<?php echo urlTypeUser(); ?>solicitacao/<?php  echo $solicitacao->id; ?>"><?php echo "#".$solicitacao->id; ?></a> 

                          <?php if(in_array($solicitacao->id, array_column(getNotification(), 'id_solicitacao'))){
                             echo '<img src="'.base_url().'public/imgs/estrutura/icones/notification.svg" alt="Nova Notificação">';
                          }?>
                          
                    </th>
                    
                    <?php if ($this->session->userdata("funcao") !== "user") : ?>
                       <td scope="col"><?php  echo $solicitacao->razao_social; ?></td>
                    <?php endif; ?>
                    
                    <td><?php echo $solicitacao->qtd_produtos; ?></td>
                    <td><?php if($solicitacao->existe_nota == 0){echo "<span class='text-danger'>Não Cadastrada</span>";} else{ echo "Cadastrada";}?></td>
                    <td><?php echo dateFormat($solicitacao->data_criacao); ?></td>
                    <td><?php echo dateFormat($solicitacao->data_atualizacao); ?></td>
                    <td><span class="status-flag <?php echo statusToCssClass($solicitacao->status)?>"><?php echo $solicitacao->status; ?></span></td>
                </tr>  
                <?php endforeach; ?>
                <!-- /END Loop 1 -->

              </tbody>
            </table>
            <!-- <p class="meta-dados-table">Mostrando 1 à 5 de 5 solicitações</p> -->
            <nav aria-label="Page navigation example">
              
              <?php if(isset($paginacao)) echo $paginacao; ?>
                
            </nav>

          </section>

      <!-- /end Conteúdo Página -->
        </div>
      </main>
