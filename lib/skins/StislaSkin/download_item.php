<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="alert alert-success alert-has-icon">
            <div class="alert-icon">
                <i class="far fa-lightbulb"></i>
            </div>
            <div class="alert-body">
                <div class="alert-title">重定向中</div>
                你的下载应该在几秒钟内开始，或<a href="<?php echo $download->link;?>">点击这里</a>手动开始下载
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"> 
    window.location = "<?php echo $download->link;?>";
</script>