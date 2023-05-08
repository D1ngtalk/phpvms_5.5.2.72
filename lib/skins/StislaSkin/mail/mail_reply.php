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
                <h4>回复信息</h4>
            </div>
            <div class="card-body">
                <div class="card-contact">
                    <?php foreach($mail as $data) { ?>
                    <form action="<?php echo url('/Mail');?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="who_from" value="<?php echo Auth::$userinfo->pilotid ?>" />
                        <input type="hidden" name="who_to" value="<?php echo $data->who_from; ?>" />
                        <input type="hidden" name="oldmessage" value="<?php echo ' '.$data->thread_id.'<br /><br />'; ?>" />
                        <?php $user = PilotData::GetPilotData($data->who_from); $pilot = PilotData::GetPilotCode($user->code, $data->who_from); ?>

                        <div class="form-group">
                            <label>收件人</label>
                            <input type="text" value="<?php echo $pilot; ?>" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>主题</label>
                            <input type="text" class="form-control" name="subject" value="回复: <?php echo $data->subject;?>">
                        </div>

                        <div class="form-group">
                            <label>回复内容</label>
                            <blockquote style="height: 340px; overflow-y: auto;"><?php echo $data->message; ?></blockquote>
                        </div>

                        <div class="form-group">
                            <label>内容</label>
                            <textarea name="message" class="summernote"></textarea>
                        </div>

                        <input type="hidden" name="action" value="send" />
                        <center><input type="submit" class="btn btn-primary" value="回复"></center></td>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>