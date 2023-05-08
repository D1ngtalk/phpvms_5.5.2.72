<script>
    $(window).load(function() {
        Swal.fire({
            title: '完成', 
            html: "<?php echo $message; ?>", 
            icon: "success"
        }).then(function() {
            window.location = "<?php echo SITE_URL; ?>";
        });
    })
</script>
