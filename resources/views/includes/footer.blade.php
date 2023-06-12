
<!-- jQuery -->
   <script src="{{ asset('js/jquery.min.js') }}"></script>

   <!-- Bootstrap v4.6.0 -->
   <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

   <!-- overlayScrollbars -->
   <script src="{{ asset('js/jquery.overlayScrollbars.min.js') }}"></script>
   
   <!-- AdminLTE App -->
   <script src="{{ asset('js/adminlte.min.js') }}"></script>
   
   {{-- Pushmenu --}}
   <script src="{{ asset('js/custom.js') }}"></script> 

   {{-- dataTables --}}
   <script src="{{ asset('js/dataTables.min.js') }}"></script>

   <!-- summernote -->
   {{-- <script src="{{ asset('/') }}summernote/summernote.min.js" ></script> --}}

   <!-- Datepicker -->
   <script src="{{ asset('/') }}js/datepicker.min.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   
   <script type="text/javascript">

      // if ($(window).width() > 992) {
         $(window).scroll(function(){
           if ($(this).scrollTop() > 0) { //default: 40
              $('#navbar_top').addClass("fixed-top");
              // add padding top to show content behind navbar
              $('body').css('padding-top', $('.navbar').outerHeight() + 'px');
            }else{
              $('#navbar_top').removeClass("fixed-top");
               // remove padding top from body
              $('body').css('padding-top', '0');
            }   
         });
      // } // end

      window.setTimeout(function(){
         $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
         });
      }, 5000);

      $(".datepicker").datepicker({
         format: "dd-mm-yyyy",
         // startView: "months", 
         // minViewMode: "months"
      });

      $(document).ready(function(){
         $('.table').DataTable();
      });
    
      $(document).ready(function(){
        $('.summernote').summernote();
      });    
      
      //redirect to specific tab
      $(document).ready(function(){
         $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
      });   

      $(document).on('click', '#addExtraDropdown', function (e) {
         e.preventDefault()
         var html = '<div class="row justify-content-center dropdownDelete"> <i class="fa fa-chevron-down pt-3"></i> <div class="col-8 form-group"> <input type="text" name="dropdownValue[]" class="form-control" placeholder="Value name" required/> </div><button type="button" class="btn dropdown-btn"> <i class="fa fa-trash"></i> </button> </div>'

         $('#extraDropdown').append(html)
      });

      $("body").on("click",".dropdown-btn",function(e){
          $(this).parents('.dropdownDelete').remove();
      });
      
      $(document).ready(function() {
         $('.multiple-checkboxes').multiselect({
            includeSelectAllOption: true,
         });
      });

      let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
      elems.forEach(function(html) {
          let switchery = new Switchery(html,  { size: 'small' });
      });

      // Status change
      $(document).ready(function(){
         $('.status').change(function () {

            let model = $(this).data('model');
            let field = $(this).data('field');
            let id = $(this).data('id');
            let tab = $(this).data('tab');

            $.ajax({
               type: "GET",
               dataType: "json",
               // url: '{{ Route('status') }}',
               data: {'model': model, 'field': field, 'id': id, 'tab': tab},
               success: function (data) {
                  toastr.options.closeButton = true;
                  toastr.options.closeMethod = 'fadeOut';
                  toastr.options.closeDuration = 100;
                  toastr.success(data.message);
               }
            });
         });
      });
     
   </script>
   