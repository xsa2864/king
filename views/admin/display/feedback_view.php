<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1>
            <h1></h1>
            <legend>用户反馈</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="box box-primary" style="border-color:white">
                            <div id="chat-box" class="box-body chat">
                                <?php
                                foreach($tree as $value)
                                {
                                ?>
                                <div class="item">
                                    <img class="offline" alt="user image" src="<?php echo input::imgUrl("avatar5.png"); ?>">
                                    <p class="message">
                                        <a class="name" href="#"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i><?php echo $value->ctime;?></small><?php echo $value->realName;?></a>
                                        <?php echo $value->content;?>
                                    </p>

                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="text-center">
                                <?php
                                echo $pagination->render();                                
                                ?>
                            </div>
                            <!-- /.chat -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
