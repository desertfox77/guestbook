<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"> </script> <script src=<?= base_url('assets/'); ?>"vendor/bootstrap/js/bootstrap.bundle.min.js"> </script>
    <!-- Core plugin JavaScript-->
        <script src = "<?= base_url('assets/'); ?> vendor/jquery-easing/jquery.easing.min.js" >
    </script>
    <script type="application/javascript">  
     /** After windod Load */  
     $(window).bind("load", function() {  
       window.setTimeout(function() {  
         $(".alert").fadeTo(500, 0).slideUp(500, function() {  
           $(this).remove();  
         });  
       }, 500);  
     });  
   </script>
    <!-- Custom scripts for all pages
        -->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"> 
    </script> 
    </body> 
    </html>

