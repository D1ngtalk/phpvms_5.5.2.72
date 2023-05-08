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
                <h4>新建文件夹</h4>
            </div>
            <div class="card-body">
                <div class="card-contact">
                    <form action="<?php echo url('/Mail');?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>文件夹名称</label>
                            <input type="text" class="form-control" name="folder_title"/>
                        </div>
                        
                        <input type="hidden" name="action" value="savefolder" />
                        <input type="submit" class="btn btn-primary" value="新建文件夹" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>