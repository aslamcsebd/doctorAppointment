
<!-- jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

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
<script src="{{ asset('/') }}summernote/summernote.min.js"></script>

<!-- Datepicker -->
{{-- <script src="{{ asset('/') }}js/datepicker.min.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
    // if ($(window).width() > 992) {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 0) { //default: 40
            $('#navbar_top').addClass("fixed-top");
            // add padding top to show content behind navbar
            $('body').css('padding-top', $('.navbar').outerHeight() + 'px');
        } else {
            $('#navbar_top').removeClass("fixed-top");
            // remove padding top from body
            $('body').css('padding-top', '0');
        }
    });
    // } // end

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);

	$(".datepicker").datepicker({
		dateFormat: "dd-mm-yy",
		// minDate: new Date(),
		minDate: 0, 
    });

    $(".datepicker3").datepicker({
		dateFormat: "dd-mm-yy",
    });

	$(".datepicker2").datepicker({
		dateFormat: "dd-mm-yy",
		// maxDate: "+20D" // Now to next 20 day enable
		//minDate: -20,  // Now to before 20 day enable
		 minDate: +20
	});	

    $(".datepicker, .datepicker2, .datepicker3").attr("autocomplete", "off");

    $(document).ready(function() {
        $('.table').DataTable();
    });

    $(document).ready(function() {
        $('.summernote').summernote();
    });

    //redirect to specific tab
    $(document).ready(function() {
        $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');
    });

    $(document).on('click', '#addRoom', function(e) {
        e.preventDefault()
        var html =
            '<div class="row justify-content-center roomDelete"> <i class="fa fa-chevron-down pt-3"></i> <div class="col-8 form-group"> <input type="text" name="room[]" class="form-control" placeholder="Ex: 101, 102..." required/> </div><button type="button" class="btn dropdown-btn"> <i class="fa fa-trash"></i> </button> </div>'

        $('#roomRow').append(html)
    });

    $("body").on("click", ".dropdown-btn", function(e) {
        $(this).parents('.roomDelete').remove();
    });

    $(document).ready(function() {
        $('.multiple-checkboxes').multiselect({
            includeSelectAllOption: true,
        });
    });

    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elems.forEach(function(html) {
        let switchery = new Switchery(html, {
            size: 'small'
        });
    });

    // Status change
    $(document).ready(function() {
        $('.status').change(function() {

            let model = $(this).data('model');
            let field = $(this).data('field');
            let id = $(this).data('id');
            let tab = $(this).data('tab');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('status') }}',
                data: {
                    'model': model,
                    'field': field,
                    'id': id,
                    'tab': tab
                },
                success: function(data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
        });
    });

    // Room status
    $("#cabin").click(function() {
        var chkFormationDept = document.getElementById("cabin").checked;
        if (chkFormationDept) {
            $('#roomStatus [data_id="roomAction"]').parent().removeClass('active').css('display', 'none');
        }
    })
    $("#ward").click(function() {
        var chkFormationDept = document.getElementById("ward").checked;
        if (chkFormationDept) {
            $('#roomStatus [data_id="roomAction"]').parent().removeClass('active').css('display', 'block');
        }
    })
</script>


<!-- For Sandbox -->
<script>
    (function(window, document) {
        var loader = function() {
            var script = document.createElement("script"),
                tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(
                7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
            loader);
    })(window, document);
</script>

<!-- For Live -->
<script>
    (function(window, document) {
        var loader = function() {
            var script = document.createElement("script"),
                tag = document.getElementsByTagName("script")[0];
            script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36)
                .substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
            loader);
    })(window, document);
</script>
