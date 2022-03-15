    	
        </div><!-- /end .col coluna principal da direita -->
      </div><!-- /end .row inicial -->
    </div><!-- /end .wrapper -->
    
    <!-- JS -->
  
    <script src="<?php echo base_url()?>public/js/script.js" async></script>
    <script src="<?php echo base_url()?>public/js/jquery.mask.js" async></script>
    <?php if($this->session->userdata('funcao') == "admin"){  ?>
      <script src="<?php echo base_url()?>public/js/deleteMessage.js" async></script>
    
      <script src="<?php echo base_url()?>public/js/toggleList.js" async></script>
  <?php } ?>
 
  </body>
</html>