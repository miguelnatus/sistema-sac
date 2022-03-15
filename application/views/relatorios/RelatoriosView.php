
<div class="relatorios">
    <main class="row">
        <div class="col">
            <div class="titulo-internas">
                <h1>Crie seus relatórios</h1>
                <p>Pesquise com filtros e consulte ou imprima os relatórios.</p>
            </div>
            <section class="solicitacoes">
            <div class="callout relatorio">
                <h1>Tipo de Relatório</h1>
                <form method="GET" action="<?php echo base_url();?>admin/relatorios/pdf" id="formrelatorio" target="_blank">
           
                    <div class="form-group left" id="relatorio">
                
                        <select class="form-control" name="tipo" id="relatorioSelected" required onchange = "boxSelected()">   
                            <option value="" disabled="disabled"  selected>Escolha</option>
                            <option value="referencia"> Referência</option>
                            <option value="lojista"> Lojista</option>
                            <option value="problemas"> Problemas</option>
                            
                        </select>
                    
                        <div class="form-group left">
                            <label for="date-input" class="align-middle">De:</label>
                         
                            <input class="form-control" type="date" name="inicio" value="<?php echo date("Y-m-d", strtotime("-1 month"));?>" id="date-input"> 
                        </div>

                    <div class="form-group left">
                        <label for="date-input" class="align-middle">Até:</label>
                        
                        <input class="form-control" type="date" name="fim" value="<?php echo date("Y-m-d"); ?>" id="date-input">
                        
                    </div> 
                    </div>
                    </div>
                 

                </div>
                
            
               

            </div>
            <div class="container">
         
        </div>
         
            <div class="botao-salvar">
                <button type="submit" class="btn btn-primary btn-lg btn-block">GERAR RELATÓRIO</button>
            </div>
            </form>
        </div>
        


         <!-- /end Conteúdo Página -->
         </div>
      </main>
</div>


<div class="modal relatorio" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lojista</h5>
        <button type="button" class="close" data-dismiss="modal" onclick = "boxClose()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body relatorio">
      <table class="table  table-hover table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Razão social</th>
                  <th scope="col">CNPJ</th>
                  <th scope="col"><div class="form-check" ><input class="form-check-input"  type="checkbox" id="defaultCheck1" onclick="checkAll(this);"></div></th>
                </tr>
              </thead>
              <tbody>
             
              </tbody>
      </table>

                  

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick = "boxClose()">Confirmar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick = "boxClose()" >Fechar</button>
      </div>
    </div>
  </div>
</div>