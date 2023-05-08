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
                <h4>发件箱</h4>
            </div>
            <div class="card-body">
                <div class="card-contact">
                    <?php
                        if(!$mail) {
                            echo '<div class="alert alert-primary">You have no sent messages.</div>';
                        } else {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table-1">
                            <thead>                                 
                                <tr>
                                    <th width="5px" class="text-center">状态</th>
                                    <th width="40%">主题</th>
                                    <th>收件人</th>
                                    <th>日期</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php
                                    foreach($mail as $thread) {
                                        if($thread->read_state=='0'){
                                            if($thread->deleted_state == '0') {
                                                $status = '<div class="badge badge-info">未读</div>';
                                            } else {
                                                $status = '<div class="badge badge-danger">未读 已删除</div>';
                                            }
                                        } else {
                                            if($thread->deleted_state == '0') {
                                                $status = '<div class="badge badge-success">已读</div>';
                                            } else {
                                                $status = '<div class="badge badge-warning">已读 已删除</div>';
                                            }
                                        }
        
                                        $user = PilotData::GetPilotData($thread->who_to); 
                                        $pilot = PilotData::GetPilotCode($user->code, $thread->who_to);
                                ?>
                                <tr>
                                    <td align="center">
                                        <?php echo $status; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo SITE_URL ?>/index.php/Mail/item/<?php echo $thread->thread_id.'/'.$thread->who_to;?>"><?php echo $thread->subject; ?></a>
                                    </td>
                                    <td>
                                        <?php
                                            if ($thread->notam=='1') {
                                                echo '通告 (所有飞行员)';
                                            }
                                            else {
                                                echo '<img alt="image" src="'.PilotData::getPilotAvatar($pilot).'" class="rounded-circle" width="35" title="'.$user->firstname.' '.$user->lastname .' ('.$pilot.')" data-toggle="tooltip">';
                                            } 
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date('Y-m-d H:i:s', strtotime($thread->date)); ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="<?php echo SITE_URL ?>/index.php/Mail/sent_delete/?mailid=<?php echo $thread->id;?>">删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>

                    <center><a class="mt-3 btn btn-danger" href="<?php echo url('/mail/delete_allsent'); ?>" onclick="return confirm('确定要删除所有信息吗')">全部删除</a></center>
                </div>
            </div>
        </div>
    </div>
</div>