<?php
//AIRMail3
//simpilotgroup addon module for phpVMS virtual airline system
//
//simpilotgroup addon modules are licenced under the following license:
//Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
//To view full icense text visit http://creativecommons.org/licenses/by-nc-sa/3.0/
//
//@author David Clark (simpilot)
//@copyright Copyright (c) 2009-2011, David Clark
//@license http://creativecommons.org/licenses/by-nc-sa/3.0/
?>
<div class="row mt-2">
	<div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>删除文件夹</h4>
            </div>
            <div class="card-body">
                <div class="card-contact">
                    <?php 
                        $folders = MailData::checkforfolders(Auth::$userinfo->pilotid);
                        if(!$folders) {
                            echo '<div class="alert alert-primary">没有可删除的文件夹/div>';
                        } else {
                    ?>
                    <form action="<?php echo url('/Mail');?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>选择文件夹</label>
                            <select class="form-control" name="folder_id">
                                <?php foreach ($folders as $folder) {echo '<option value="'.$folder->id.'">'.$folder->folder_title.'</option>';}?>
                            </select>
                        </div>

                        <p><b>注意: </b>删除的文件夹内的所有信息会移动到默认收件箱中</p>
                        
                        <input type="hidden" name="action" value="confirm_delete_folder" />
                        <input type="submit" class="btn btn-primary" value="删除文件夹">
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>