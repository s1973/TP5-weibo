<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:68:"E:\htdoc\ThinkPHP5\public/../application/index\view\index\index.html";i:1507599960;s:70:"E:\htdoc\ThinkPHP5\public/../application/index\view\Common\header.html";i:1506406829;s:67:"E:\htdoc\ThinkPHP5\public/../application/index\view\Common\nav.html";i:1507605447;s:69:"E:\htdoc\ThinkPHP5\public/../application/index\view\Common\right.html";i:1506404582;s:70:"E:\htdoc\ThinkPHP5\public/../application/index\view\Common\bottom.html";i:1506395608;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <?php 
		$style = db('userinfo')->where(array('uid' => session('uid')))->value('style');
     ?>
    <title><?php echo \think\Config::get('system.WEBNAME'); ?>-首页</title>
    <link rel="stylesheet" href="__STATIC__/Theme/<?php echo $style; ?>/Css/nav.css" />
    <link rel="stylesheet" href="__STATIC__/Theme/<?php echo $style; ?>/Css/index.css" />
    <link rel="stylesheet" href="__STATIC__/Theme/<?php echo $style; ?>/Css/bottom.css" />
    <link rel="stylesheet" href="__STATIC__/Uploadify/uploadify.css"/>
    <script type="text/javascript" src='__STATIC__/Js/jquery-1.7.2.min.js'></script>
    <script type="text/javascript" src='__STATIC__/Js/nav.js'></script>
    <script type="text/javascript" src='__STATIC__/Uploadify/jquery.uploadify.min.js'></script>
    <script type="text/javascript" src='__STATIC__/Js/index.js'></script>
    <script type='text/javascript'>
        var PUBLIC = '__STATIC__';
        var uploadUrl = '<?php echo url("Common/uploadPic"); ?>';
        var sid = '<?php echo session_id(); ?>';
        var ROOT = '__ROOT__';
        var commentUrl = "<?php echo url('Index/comment'); ?>";
        var getComment = '<?php echo url("Index/getComment"); ?>';
        var keepUrl = '<?php echo url("Index/keep"); ?>';
        var delWeibo = '<?php echo url("Index/delWeibo"); ?>';
    </script>
<script type='text/javascript'>
    var delFollow = "<?php echo url('Common/delFollow'); ?>";
    var editStyle = "<?php echo url('Common/editStyle'); ?>";
    var getMsgUrl = "<?php echo url('Common/getMsg'); ?>";
</script>
</head>
<body>
<!--==========顶部固定导行条==========-->
    <div id='top_wrap'>
        <div id="top">
            <div class='top_wrap'>
                <div class="logo fleft"></div>
                <ul class='top_left fleft'>
                    <li class='cur_bg'><a href='__ROOT__'>首页</a></li>
                    <li><a href="<?php echo url('User/letter'); ?>">私信</a></li>
                    <li><a href="<?php echo url('User/comment'); ?>">评论</a></li>
                    <li><a href="<?php echo url('User/atme'); ?>">@我</a></li>
                </ul>
                <div id="search" class='fleft'>
                    <form action='<?php echo url("Search/sechUser"); ?>' method='get'>
                        <input type='text' name='keyword' id='sech_text' class='fleft' value='搜索微博、找人'/>
                        <input type='submit' value='' id='sech_sub' class='fleft'/>
                    </form>
                </div>
                <div class="user fleft">
                    <a href="<?php echo url('/' . session('uid')); ?>"><?php echo (db('userinfo')->where(array('uid' => session('uid')))->value('username')); ?></a>
                </div>
                <ul class='top_right fleft'>
                    <li title='快速发微博' class='fast_send'><i class='icon icon-write'></i></li>
                    <li class='selector'><i class='icon icon-msg'></i>
                        <ul class='hidden'>
                            <li><a href="<?php echo url('User/comment'); ?>">查看评论</a></li>
                            <li><a href="<?php echo url('User/letter'); ?>">查看私信</a></li>
                            <li><a href="<?php echo url('User/keep'); ?>">查看收藏</a></li>
                            <li><a href="<?php echo url('User/atme'); ?>">查看@我</a></li>
                        </ul>
                    </li>
                    <li class='selector'><i class='icon icon-setup'></i>
                        <ul class='hidden'>
                            <li><a href="<?php echo url('UserSetting/index'); ?>">帐号设置</a></li>
                            <li><a href="" class='set_model'>模版设置</a></li>
                            <li><a href="<?php echo url('Index/loginOut'); ?>">退出登录</a></li>
                        </ul>
                    </li>
                <!--信息推送-->
                    <li id='news' class='hidden'>
                        <i class='icon icon-news'></i>
                        <ul>
                            <li class='news_comment hidden'>
                                <a href="<?php echo url('User/comment'); ?>"></a>
                            </li>
                            <li class='news_letter hidden'>
                                <a href="<?php echo url('User/letter'); ?>"></a>
                            </li>
                            <li class='news_atme hidden'>
                                <a href="<?php echo url('User/atme'); ?>"></a>
                            </li>
                        </ul>
                    </li>
                <!--信息推送-->
                </ul>
            </div>
        </div>
    </div>
<!--==========顶部固定导行条==========-->
<!--==========加关注弹出框==========-->

<?php 
    $group = db('group')->where(array('uid' => session('uid')))->select();
?>
    <script type='text/javascript'>
        var addFollow = "<?php echo url('Common/addFollow'); ?>";
    </script>
    <div id='follow'>
        <div class="follow_head">
            <span class='follow_text fleft'>关注好友</span>
        </div>
        <div class='sel-group'>
            <span>好友分组：</span>
            <select name="gid">
                <option value="0">默认分组</option>
                <?php if(is_array($group) || $group instanceof \think\Collection || $group instanceof \think\Paginator): if( count($group)==0 ) : echo "" ;else: foreach($group as $key=>$v): ?>
                    <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class='fl-btn-wrap'>
            <input type="hidden" name='follow'/>
            <span class='add-follow-sub'>关注</span>
            <span class='follow-cencle'>取消</span>
        </div>
    </div>
<!--==========加关注弹出框==========-->

<!--==========自定义模版==========-->
    <div id='model' class='hidden'>
        <div class="model_head">
            <span class="model_text">个性化设置</span>
            <span class="close fright"></span>
        </div>
        <ul>
            <li style='background:url(__STATIC__/Images/default.jpg) no-repeat;' theme='default'></li>
            <li style='background:url(__STATIC__/Images/style2.jpg) no-repeat;' theme='style2'></li>
            <li style='background:url(__STATIC__/Images/style3.jpg) no-repeat;' theme='style3'></li>
            <li style='background:url(__STATIC__/Images/style4.jpg) no-repeat;' theme='style4'></li>
        </ul>
        <div class='model_operat'>
            <span class='model_save'>保存</span>
            <span class='model_cancel'>取消</span>
        </div>
    </div>
<!--==========自定义模版==========-->
<!--==========内容主体==========-->
<div style='height:60px;opcity:10'></div>
    <div class="main">
    <!--=====左侧=====-->
    <include file='Common:left'/>
    <!--=====中部=====-->
        <div id="middle" class='fleft'>
        <!--微博发布框-->
            <div class='send_wrap'>
                <div class='send_title fleft'></div>
                <div class='send_prompt fright'>
                    <span>你还可以输入<span id='send_num'>140</span>个字</span>
                </div>
                <div class='send_write'>
                    <form action='<?php echo url("sendWeibo"); ?>' method='post' name='weibo'>
                        <textarea sign='weibo' name='content'></textarea>
                        <span class='ta_right'></span>
                        <div class='send_tool'>
                            <ul class='fleft'>
                                <li title='表情'><i class='icon icon-phiz phiz' sign='weibo'></i></li>
                                <li title='图片'><i class='icon icon-picture'></i>
                                <!--图片上传框-->
                                    <div id="upload_img" class='hidden'>
                                        <div class='upload-title'><p>本地上传</p><span class='close'></span></div>
                                        <div class='upload-btn'>
                                            <input type="hidden" name='max' value=''/>
                                            <input type="hidden" name='medium' value=''/>
                                            <input type="hidden" name='mini' value=''/>
                                            <input type="file" name='picture' id='picture'/>
                                        </div>
                                    </div>
                                <!--图片上传框-->
                                    <div id='pic-show' class='hidden'>
                                        <img src="" alt=""/>
                                    </div>
                                </li>
                            </ul>
                            <input type='submit' value='' class='send_btn fright' title='发布微博按钮'/>
                        </div>
                    </form>
                </div>
            </div>
        <!--微博发布框-->
            <div class='view_line'>
                <strong>微博</strong>
            </div>
<?php if(!$weibo): ?>
    没有发布的微博
<?php else: if(is_array($weibo) || $weibo instanceof \think\Collection || $weibo instanceof \think\Paginator): if( count($weibo)==0 ) : echo "" ;else: foreach($weibo as $key=>$v): if(!$v["isturn"]): ?>
<!--====================普通微博样式====================-->
            <div class="weibo">
                <!--头像-->
                <div class="face">
                    <a href="<?php echo url('/' . $v['uid']); ?>">
                        <img src="
                        <?php if($v["face"]): ?>
                            __ROOT__/Uploads/Face/<?php echo $v['face']; else: ?>
                            __STATIC__/Images/noface.gif
                        <?php endif; ?>" width='50' height='50'/>
                    </a>
                </div>
                <div class="wb_cons">
                    <dl>
                    <!--用户名-->
                        <dt class='author'>
                            <a href="<?php echo url('/' . $v['uid']); ?>"><?php echo $v['username']; ?></a>
                        </dt>
                    <!--发布内容-->
                        <dd class='content'>
                            <p><?php echo replace_weibo($v['content']); ?></p>
                        </dd>
                    <!--微博图片-->
                    <?php if($v['max']): ?>
                        <dd>
                            <div class='wb_img'>
                            <!--小图-->
                                <img src="__ROOT__/Uploads/Pic/<?php echo $v['mini']; ?>" class='mini_img'/>
                                <div class="img_tool hidden">
                                    <ul>
                                        <li>
                                            <i class='icon icon-packup'></i>
                                            <span class='packup'>&nbsp;收起</span>
                                        </li>
                                        <li>|</li>
                                        <li>
                                            <i class='icon icon-bigpic'></i>
                                            <a href="__ROOT__/Uploads/Pic/<?php echo $v['max']; ?>" target='_blank'>&nbsp;查看大图</a>
                                        </li>
                                    </ul>
                                <!--中图-->
                                    <div class="img_info"><img src="__ROOT__/Uploads/Pic/<?php echo $v['medium']; ?>"/></div>
                                </div>
                            </div>
                        </dd>
                    <?php endif; ?>
                    </dl>
                <!--操作-->
                    <div class="wb_tool">
                    <!--发布时间-->
                        <span class="send_time"><?php echo time_format($v['time']); ?></span>
                        <ul>
                        <?php if(session("?uid") && session("uid") == $v["uid"]): ?>
                            <li class='del-li hidden'><span class='del-weibo' wid='<?php echo $v['id']; ?>'>删除</span></li>
                            <li class='del-li hidden'>|</li>
                        <?php endif; ?>
                            <li><span class='turn' id='<?php echo $v["id"]; ?>'>转发<?php if($v["turn"]): ?>(<?php echo $v['turn']; ?>)<?php endif; ?></span></li>
                            <li>|</li>
                            <li class='keep-wrap'>
                                <span class='keep' wid='<?php echo $v['id']; ?>'>收藏<?php if($v["keep"]): ?>(<?php echo $v['keep']; ?>)<?php endif; ?></span>
                                <div class='keep-up hidden'></div>
                            </li>
                            <li>|</li>
                            <li><span class='comment' wid='<?php echo $v['id']; ?>'>评论<?php if($v["comment"]): ?>(<?php echo $v['comment']; ?>)<?php endif; ?></span></li>
                        </ul>
                    </div>
                <!--=====回复框=====-->
                    <div class='comment_load hidden'>
                        <img src="__STATIC__/Images/loading.gif">评论加载中，请稍候...
                    </div>
                    <div class='comment_list hidden'>
                        <textarea name="" sign='comment<?php echo $key; ?>'></textarea>
                        <ul>
                            <li class='phiz fleft' sign='comment<?php echo $key; ?>'></li>
                            <li class='comment_turn fleft'>
                                <label>
                                    <input type="checkbox" name=''/>同时转发到我的微博
                                </label>
                            </li>
                            <li class='comment_btn fright' wid='<?php echo $v['id']; ?>' uid='<?php echo $v['uid']; ?>'>评论</li>
                        </ul>
                    </div>
                <!--=====回复框结束=====-->
                </div>
            </div>
    <?php else: ?>
<!--====================转发样式====================-->
            <div class="weibo">
            <!--头像-->
                <div class="face">
                    <a href="<?php echo url('/' . $v['uid']); ?>">
                        <img src="
                        <?php if($v["face"]): ?>
                            __ROOT__/Uploads/Face/<?php echo $v['face']; else: ?>
                            __STATIC__/Images/noface.gif
                        <?php endif; ?>" width='50' height='50'/>
                    </a>
                </div>
                <div class="wb_cons">
                    <dl>
                    <!--用户名-->
                        <dt class='author'>
                            <a href="<?php echo url('/' . $v['uid']); ?>"><?php echo $v['username']; ?></a>
                        </dt>
                    <!--发布内容-->
                        <dd class='content'>
                            <p><?php echo replace_weibo(str_replace('//', '<span style="color:#ccc;font-weight:bold;">&nbsp;//&nbsp;</span>', $v['content'])); ?></p>
                        </dd>
                    <!--转发的微博内容-->
                    <?php if($v["isturn"] == -1): ?>
                        <dd class="wb_turn">该微博已被删除</dd>
                    <?php else: ?>
                        <dd>
                            <div class="wb_turn">
                                <dl>
                                <!--原作者-->
                                    <dt class='turn_name'>
                                        <a href="<?php echo url('/' . $v['isturn']['uid']); ?>">@<?php echo $v['isturn']['username']; ?></a>
                                    </dt>
                                <!--原微博内容-->
                                    <dd class='turn_cons'>
                                        <p><?php echo replace_weibo($v['isturn']['content']); ?></p>
                                    </dd>
                                <!--原微博图片-->
                                <?php if($v["isturn"]["max"]): ?>
                                    <dd>
                                        <div class="turn_img">
                                        <!--小图-->
                                            <img src="__ROOT__/Uploads/Pic/<?php echo $v['isturn']['mini']; ?>" class='turn_mini_img'/>
                                            <div class="turn_img_tool hidden">
                                                <ul>
                                                    <li>
                                                        <i class='icon icon-packup'></i>
                                                        <span class='packup'>&nbsp;收起</span></li>
                                                    <li>|</li>
                                                    <li>
                                                        <i class='icon icon-bigpic'></i>
                                                        <a href="__ROOT__/Uploads/Pic/<?php echo $v['isturn']['max']; ?>" target='_blank'>&nbsp;查看大图</a>
                                                    </li>
                                                </ul>
                                            <!--中图-->
                                                <div class="turn_img_info">
                                                    <img src="__ROOT__/Uploads/Pic/<?php echo $v['isturn']['medium']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </dd>
                                <?php endif; ?>
                                </dl>
                                <!--转发微博操作-->
                                <div class="turn_tool">
                                    <span class='send_time'>
                                        <?php echo time_format($v['isturn']['time']); ?>
                                    </span>
                                    <ul>
                                        <li><a href="">转发<?php if($v["isturn"]["turn"]): ?>(<?php echo $v['isturn']['turn']; ?>)<?php endif; ?></a></li>
                                        <li>|</li>
                                        <li><a href="">评论<?php if($v["isturn"]["comment"]): ?>(<?php echo $v['isturn']['comment']; ?>)<?php endif; ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </dd>
                    <?php endif; ?>
                    </dl>
                    <!--操作-->
                    <div class="wb_tool">
                        <!--发布时间-->
                        <span class="send_time">
                            <?php echo time_format($v['time']); ?>
                        </span>
                        <ul>
                        <?php if(session("?uid") && session("uid") == $v["uid"]): ?>
                            <li class='del-li hidden'><span class='del-weibo' wid='<?php echo $v['id']; ?>'>删除</span></li>
                            <li class='del-li hidden'>|</li>
                        <?php endif; ?>
                            <li><span class='turn' id='<?php echo $v['id']; ?>' tid='<?php echo $v['isturn']['id']; ?>'>转发<?php if($v["turn"]): ?>(<?php echo $v['turn']; ?>)<?php endif; ?></span></li>
                            <li>|</li>
                            <li class='keep-wrap'>
                                <span class='keep' wid='<?php echo $v['id']; ?>'>收藏<?php if($v["keep"]): ?>(<?php echo $v['keep']; ?>)<?php endif; ?></span>
                                <div class='keep-up hidden'></div>
                            </li>
                            <li>|</li>
                            <li><span class='comment' wid='<?php echo $v['id']; ?>'>评论<?php if($v["comment"]): ?>(<?php echo $v['comment']; ?>)<?php endif; ?></span></li>
                        </ul>
                    </div>
                    <!--回复框-->
                    <div class='comment_load hidden'>
                        <img src="__STATIC__/Images/loading.gif">评论加载中，请稍候...
                    </div>
                    <div class='comment_list hidden'>
                        <textarea name="" sign='comment<?php echo $key; ?>'></textarea>
                        <ul>
                            <li class='phiz fleft' sign='comment<?php echo $key; ?>'></li>
                            <li class='comment_turn fleft'>
                                <label>
                                    <input type="checkbox" name=''/>同时转发到我的微博
                                </label>
                            </li>
                            <li class='comment_btn fright' wid='<?php echo $v['id']; ?>' uid='<?php echo $v['uid']; ?>'>评论</li>
                        </ul>
                    </div>
                    <!--回复框结束-->
                </div>
            </div>
<!--====================转发样式结束====================-->
    <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
            <div id='page'><?php echo $page; ?></div>
        </div>
<!--==========右侧==========-->
        <div id="right">
    <div class="edit_tpl"><a href="" class='set_model'></a></div> 
<?php $where = array("uid" => session("uid"));$field = array("username", "face80" => "face", "follow", "fans", "weibo", "uid");$userinfo = db("userinfo")->where($where)->field($field)->find();extract($userinfo);?>
    <dl class="user_face">
        <dt>
            <a href="<?php echo url('/' . $uid); ?>">
                <img src="<?php if($face): ?>__ROOT__/Uploads/Face/<?php echo $face; else: ?>__PUBLIC__/Images/noface.gif<?php endif; ?>" width='80' height='80' alt="<?php echo $username; ?>" />
            </a>
        </dt>
        <dd>
            <a href="<?php echo url('/' . $uid); ?>"><?php echo $username; ?></a>
        </dd>
    </dl>
    <ul class='num_list'>
        <li><a href="<?php echo url('follow/' . $uid); ?>"><strong><?php echo $follow; ?></strong><span>关注</span></a></li>
        <li><a href="<?php echo url('fans/' . $uid); ?>"><strong><?php echo $fans; ?></strong><span>粉丝</span></a></li>
        <li class='noborder'>
            <a href="<?php echo url('/' . $uid); ?>"><strong><?php echo $weibo; ?></strong><span>微博</span></a>
        </li>
    </ul>

    <div class="maybe">
        <fieldset>
            
            <legend>可能感兴趣的人</legend>
            <ul>
                <?php $uid = session("uid");$db = db("follow");$where = array("fans" => $uid);$follow = $db->where($where)->field("follow")->select();foreach ($follow as $k => $v) :$follow[$k] = $v["follow"];endforeach;$sql = "SELECT `uid`,`username`,`face50` AS `face`,COUNT(f.`follow`) AS `count` FROM `hd_follow` f LEFT JOIN `hd_userinfo` u ON f.`follow` = u.`uid` WHERE f.`fans` IN ('" . implode(',', $follow) . "') AND f.`follow` NOT IN ('" . implode(',',$follow) . "') AND f.`follow` <>" . $uid . " GROUP BY f.`follow` ORDER BY `count` DESC LIMIT 4";$friend = $db->query($sql);foreach ($friend as $v) :extract($v);?>
                    <li>
                        <dl>
                            <dt>
                                <a href="<?php echo url('/' . $uid); ?>">
                                    <img src="<?php if($face): ?>__STATIC__/Uploads/Face/<?php echo $face; else: ?>__STATIC__/Images/noface.gif<?php endif; ?>" width='30' height='30'/>
                                </a>
                            </dt>
                            <dd><a href="<?php echo url('/' . $uid); ?>"><?php echo $username; ?></a></dd>
                            <dd>共<?php echo $count; ?>个共同好友</dd>
                        </dl>
                        <span class='heed_btn add-fl' uid='<?php echo $uid; ?>'><strong>+&nbsp;</strong>关注</span>
                    </li>
                <?php endforeach;?>
            </ul>
        </fieldset>
    </div>
    <div class="post">
        <div class='post_line'>
            <span>公告栏</span>
        </div>
        <ul>
            <li><a href="">后盾网DIV+CSS视频教程</a></li>
            <li><a href="">后盾网PHP视频教程</a></li>
            <li><a href="">后盾网MySQL视频教程</a></li>
        </ul>
    </div>
</div>
    </div>
<!--==========内容主体结束==========-->
<!--==========底部==========-->
<!--==========底部==========-->
    <div id="bottom">
        <div class='link'>
            <dl>
                <dt>后盾网论坛</dt>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
            </dl>
            <dl>
                <dt>后盾网论坛</dt>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
            </dl>
            <dl>
                <dt>后盾网论坛</dt>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
            </dl>
            <dl>
                <dt>后盾网论坛</dt>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
            </dl>
            <dl>
                <dt>后盾网论坛</dt>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
                <dd><a href="">后盾网免费视频教程</a></dd>
            </dl>
        </div>
        <div id="copy">
            <div>
                <p>
                    版权所有：<?php echo \think\Config::get('system.COPY'); ?> 站长统计 All rights reserved, houdunwang.com services for Beijing 2008-2012 
                </p>
            </div>
        </div>
    </div>

<!--==========转发输入框==========-->
    <div id='turn' class='hidden'>
        <div class="turn_head">
            <span class='turn_text fleft'>转发微博</span>
            <span class="close fright"></span>
        </div>
        <div class="turn_main">
            <form action='<?php echo url("Index/turn"); ?>' method='post' name='turn'>
                <p></p>
                <div class='turn_prompt'>
                    你还可以输入<span id='turn_num'>140</span>个字</span>
                </div>
                <textarea name='content' sign='turn'></textarea>
                <ul>
                    <li class='phiz fleft' sign='turn'></li>
                    <li class='turn_comment fleft'>
                        <label>
                            <input type="checkbox" name='becomment'/>同时评论给<span class='turn-cname'></span>
                        </label>
                    </li>
                    <li class='turn_btn fright'>
                        <input type="hidden" name='id' value=''/>
                        <input type="hidden" name='tid' value=''/>
                        <input type="submit" value='转发' class='turn_btn'/>
                    </li>
                </ul>
            </form>
        </div>
    </div>
<!--==========转发输入框==========-->

<!--==========表情选择框==========-->
    <div id="phiz" class='hidden'>
        <div>
            <p>常用表情</p>
            <span class='close fright'></span>
        </div>
        <ul>
            <li><img src="__STATIC__/Images/phiz/hehe.gif" alt="呵呵" title="呵呵" /></li>
            <li><img src="__STATIC__/Images/phiz/xixi.gif" alt="嘻嘻" title="嘻嘻" /></li>
            <li><img src="__STATIC__/Images/phiz/haha.gif" alt="哈哈" title="哈哈" /></li>
            <li><img src="__STATIC__/Images/phiz/keai.gif" alt="可爱" title="可爱" /></li>
            <li><img src="__STATIC__/Images/phiz/kelian.gif" alt="可怜" title="可怜" /></li>
            <li><img src="__STATIC__/Images/phiz/wabisi.gif" alt="挖鼻屎" title="挖鼻屎" /></li>
            <li><img src="__STATIC__/Images/phiz/chijing.gif" alt="吃惊" title="吃惊" /></li>
            <li><img src="__STATIC__/Images/phiz/haixiu.gif" alt="害羞" title="害羞" /></li>
            <li><img src="__STATIC__/Images/phiz/jiyan.gif" alt="挤眼" title="挤眼" /></li>
            <li><img src="__STATIC__/Images/phiz/bizui.gif" alt="闭嘴" title="闭嘴" /></li>
            <li><img src="__STATIC__/Images/phiz/bishi.gif" alt="鄙视" title="鄙视" /></li>
            <li><img src="__STATIC__/Images/phiz/aini.gif" alt="爱你" title="爱你" /></li>
            <li><img src="__STATIC__/Images/phiz/lei.gif" alt="泪" title="泪" /></li>
            <li><img src="__STATIC__/Images/phiz/touxiao.gif" alt="偷笑" title="偷笑" /></li>
            <li><img src="__STATIC__/Images/phiz/qinqin.gif" alt="亲亲" title="亲亲" /></li>
            <li><img src="__STATIC__/Images/phiz/shengbin.gif" alt="生病" title="生病" /></li>
            <li><img src="__STATIC__/Images/phiz/taikaixin.gif" alt="太开心" title="太开心" /></li>
            <li><img src="__STATIC__/Images/phiz/ldln.gif" alt="懒得理你" title="懒得理你" /></li>
            <li><img src="__STATIC__/Images/phiz/youhenhen.gif" alt="右哼哼" title="右哼哼" /></li>
            <li><img src="__STATIC__/Images/phiz/zuohenhen.gif" alt="左哼哼" title="左哼哼" /></li>
            <li><img src="__STATIC__/Images/phiz/xiu.gif" alt="嘘" title="嘘" /></li>
            <li><img src="__STATIC__/Images/phiz/shuai.gif" alt="衰" title="衰" /></li>
            <li><img src="__STATIC__/Images/phiz/weiqu.gif" alt="委屈" title="委屈" /></li>
            <li><img src="__STATIC__/Images/phiz/tu.gif" alt="吐" title="吐" /></li>
            <li><img src="__STATIC__/Images/phiz/dahaqian.gif" alt="打哈欠" title="打哈欠" /></li>
            <li><img src="__STATIC__/Images/phiz/baobao.gif" alt="抱抱" title="抱抱" /></li>
            <li><img src="__STATIC__/Images/phiz/nu.gif" alt="怒" title="怒" /></li>
            <li><img src="__STATIC__/Images/phiz/yiwen.gif" alt="疑问" title="疑问" /></li>
            <li><img src="__STATIC__/Images/phiz/canzui.gif" alt="馋嘴" title="馋嘴" /></li>
            <li><img src="__STATIC__/Images/phiz/baibai.gif" alt="拜拜" title="拜拜" /></li>
            <li><img src="__STATIC__/Images/phiz/sikao.gif" alt="思考" title="思考" /></li>
            <li><img src="__STATIC__/Images/phiz/han.gif" alt="汗" title="汗" /></li>
            <li><img src="__STATIC__/Images/phiz/kun.gif" alt="困" title="困" /></li>
            <li><img src="__STATIC__/Images/phiz/shuijiao.gif" alt="睡觉" title="睡觉" /></li>
            <li><img src="__STATIC__/Images/phiz/qian.gif" alt="钱" title="钱" /></li>
            <li><img src="__STATIC__/Images/phiz/shiwang.gif" alt="失望" title="失望" /></li>
            <li><img src="__STATIC__/Images/phiz/ku.gif" alt="酷" title="酷" /></li>
            <li><img src="__STATIC__/Images/phiz/huaxin.gif" alt="花心" title="花心" /></li>
            <li><img src="__STATIC__/Images/phiz/heng.gif" alt="哼" title="哼" /></li>
            <li><img src="__STATIC__/Images/phiz/guzhang.gif" alt="鼓掌" title="鼓掌" /></li>
            <li><img src="__STATIC__/Images/phiz/yun.gif" alt="晕" title="晕" /></li>
            <li><img src="__STATIC__/Images/phiz/beishuang.gif" alt="悲伤" title="悲伤" /></li>
            <li><img src="__STATIC__/Images/phiz/zuakuang.gif" alt="抓狂" title="抓狂" /></li>
            <li><img src="__STATIC__/Images/phiz/heixian.gif" alt="黑线" title="黑线" /></li>
            <li><img src="__STATIC__/Images/phiz/yinxian.gif" alt="阴险" title="阴险" /></li>
            <li><img src="__STATIC__/Images/phiz/numa.gif" alt="怒骂" title="怒骂" /></li>
            <li><img src="__STATIC__/Images/phiz/xin.gif" alt="心" title="心" /></li>
            <li><img src="__STATIC__/Images/phiz/shuangxin.gif" alt="伤心" title="伤心" /></li>
        </ul>
    </div>
<!--==========表情==========-->

<!--[if IE 6]>
    <script type="text/javascript" src="__STATIC__/Js/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('#top','background');
        DD_belatedPNG.fix('.logo','background');
        DD_belatedPNG.fix('#sech_text','background');
        DD_belatedPNG.fix('#sech_sub','background');
        DD_belatedPNG.fix('.send_title','background');
        DD_belatedPNG.fix('.icon','background');
        DD_belatedPNG.fix('.ta_right','background');
    </script>
<![endif]-->
</body>
</html>