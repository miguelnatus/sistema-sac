<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/pdf/style.css"> 

<fieldset>
<h1>Relatório de Referência</h1>
     
<?php if(empty($data)){
     echo '<p>............................<strong>Não foram encontrados registros na data selecionada</strong>...........................</p>';
} ?>

<?php  foreach($data as $referencia){?>

 <p>Ref. <strong><?php echo $referencia->referencia;?></strong>............................<strong><?php echo($referencia->ocorrencia);?></strong> ocorrências  somando <strong><?php echo($referencia->total);?> pares</p>
 <ul>
      <li>
         Fabricação:.........................<strong><?php echo $referencia->fabricacao;?></strong>
     </li>
     <li>
         Fabricação - Não coletado: <strong><?php echo $referencia->fabricacao_coleta;?></strong>
     </li>
     <li>
         Mau uso:.............................<strong><?php echo $referencia->mau_uso;?></strong>
    </li>
    <li>
         Projeto:...............................<strong><?php echo $referencia->projeto;?></strong>
    </li>
    <li>
         Projeto - Não coletado:.......<strong><?php echo $referencia->projeto_coleta;?></strong>
    </li>
    <li>
         Material:.............................<strong><?php echo $referencia->material;?></strong>
    </li>
    <li>
         Material - Não coletado:.....<strong><?php echo $referencia->material_coleta;?></strong>
    </li>

    <br/>
    <p><?php
         
          foreach($referencia->ids as $ids){ echo '#<strong>'.$ids->id_solicitacao.'</strong> | ';
          ?><?php } ?>
     </p>
    
</ul>

-------------------------------------------------------------------------------------------------------------------
<?php } ?>

 </fieldset>
 <div class='creditos'>
<p>Relatório Giulia Domna gerado em <?php echo date('d-m-Y H:i:s');?></p>
 </div>