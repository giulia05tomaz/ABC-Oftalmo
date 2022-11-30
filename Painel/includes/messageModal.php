 <!-- Modal Campos Vazio CadastroUsuario -->
 <div class="modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-notify " id="tpModal" role="document">
         <!--Content-->
         <div class="modal-content">
             <!--Header-->
             <div class="modal-header">
                 <p class="heading lead text-center">Atenção</p>

                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true" class="white-text">&times;</span>
                 </button>
             </div>

             <!--Body-->
             <div class="modal-body">
                 <div class="text-center">
                     <i class="fas fa-bell fa-4x animated rotateIn mb-4"></i>
                     <p id="messageModal">Preencha todos os campo</p>
                 </div>
             </div>

             <!--Footer-->
             <div class="modal-footer justify-content-center">

                 <a type="button" class="btn  waves-effect" id="btTpModal" data-dismiss="modal">Ok</a>
             </div>
         </div>
         <!--/.Content-->
     </div>
 </div>

 <script src="./js/ModalClosed.js"></script>