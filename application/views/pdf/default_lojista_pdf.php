<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/pdf/style.css"> 

<fieldset>
<h1>Relatório de Lojistas</h1>
     
<?php if(empty($data)){
     echo '<p>............................<strong>Não foram encontrados registros na data selecionada</strong>...........................</p>';
} ?>

<?php
$x = 0;
foreach($data as $lojista){?>
     <?php
     $x = $x+1;
     if($x>1){
          if($cnpj == $lojista->cnpj){
               if($solicitacao == $lojista->id){?>
                       <table>
              <thead>
                <tr>
                  <th scope="col" class="table-ref"></th>
                  <th scope="col" class="table-ref"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
               
               <tr>
                    <br/>
                    <th>
                    <?php echo '<strong>'.$lojista->referencia.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->quantidade.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->fabricacao.'</strong>';?>
                    </th>
                   
               </tr>
              </tbody>
      </table>
               <?php }else{
               ?>
                <table>
                    <thead>
                    <tr>
                          <th scope="col"></th>
                         <th scope="col"></th>
                          </tr>
                    </thead>
                    <tbody>
                    <br/>
                    <tr>
                    <th>
                    <?php echo 'Solicitação: <strong>#'.$lojista->id.'</strong>';?>
                    </th>
                    <th>
                    <?php echo 'Status: <strong>'.$lojista->nome.'</strong>';?>
                    </th>
                    <th>
                    <?php echo 'Criado em: <strong>'.date('d/m/Y', strtotime($lojista->data_criacao)).'</strong>';?>
                    </th>
                   
                    </tr>
                     </tbody>
                </table>
                <table>
              <thead>
                <tr>
                <th scope="col" class="table-ref">Referência</th>
                  <th scope="col" class="table-ref">Qtd Par</th>
                  <th scope="col">Tipo Problema</th>
                </tr>
              </thead>
              <tbody>
               
               <tr>
                    <br/>
                    <th>
                    <?php echo '<strong>'.$lojista->referencia.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->quantidade.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->fabricacao.'</strong>';?>
                    </th>
                   
               </tr>
              </tbody>
      </table>
             
                  
               
          <?php
          }}else{?>
          <br/>
               <p><strong><?php echo $lojista->razao_social;?></strong> (<strong><?php echo $lojista->cnpj;?>)</strong></p>

       
               <table>
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
               <br/>
               <tr>
                    <th>
                    <?php echo 'Solicitação: <strong>#'.$lojista->id.'</strong>';?>
                    </th>
                    <th>
                    <?php echo 'Status: <strong>'.$lojista->nome.'</strong>';?>
                    </th>
                    <th>
                    <?php echo 'Criado em: <strong>'.date('d/m/Y', strtotime($lojista->data_criacao)).'</strong>';?>
                    </th>
                   
               </tr>
              </tbody>
      </table>
      <table>
              <thead>
                <tr>
                <th scope="col" class="table-ref">Referência</th>
                  <th scope="col" class="table-ref">Qtd Par</th>
                  <th scope="col">Tipo Problema</th>
                </tr>
              </thead>
              <tbody>
               
               <tr>
                    <br/>
                    <th>
                    <?php echo '<strong>'.$lojista->referencia.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->quantidade.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->fabricacao.'</strong>';?>
                    </th>
                   
               </tr>
              </tbody>
      </table>
     
         <?php }
     }else{ ?>
     <br/>
     <p><strong><?php echo $lojista->razao_social;?></strong> (<strong><?php echo $lojista->cnpj;?></strong>)</p>
     <table>
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
               
               <tr>
                    <br/>
                    <th>
                    <?php echo 'Solicitação: <strong>#'.$lojista->id.'</strong>';?>
                    </th>
                    <th>
                    <?php echo 'Status: <strong>'.$lojista->nome.'</strong>';?>
                    </th>
                    <th>
                    <?php echo 'Criado em: <strong>'.date('d/m/Y', strtotime($lojista->data_criacao)).'</strong>';?>
                    </th>
                   
               </tr>
              </tbody>
      </table>
      <table>
              <thead>
                <tr>
                  <th scope="col" class="table-ref"></th>
                  <th scope="col" class="table-ref"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
               
               <tr>
                    <br/>
                    <th>
                    <?php echo '<strong>'.$lojista->referencia.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->quantidade.'</strong>';?>
                    </th>
                    <th>
                    <?php echo ' <strong>'.$lojista->fabricacao.'</strong>';?>
                    </th>
                   
               </tr>
              </tbody>
      </table>

          

     <?php }

     $cnpj = $lojista->cnpj;
     $solicitacao = $lojista->id;
      ?>

<?php 
} ?>
 </fieldset>
 <div class='creditos'>
<p>Relatório Giulia Domna gerado em <?php echo date('d-m-Y H:i:s');?></p>
 </div>