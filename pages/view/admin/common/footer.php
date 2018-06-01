<?php echo '</div>'; ?>
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/sb-admin-2.js"></script>
<script>
    $(document).ready(function () {
        $('.btn-delete').click(
                function (event) {
                    event.preventDefault();

                    if (confirm('Please confirm to delete the record')) {
                        window.location.href = event.target.href;
                    }
                }
        );        
    });
</script>