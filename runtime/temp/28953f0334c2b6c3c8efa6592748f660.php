<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"E:\htdoc\ThinkPHP5\public/../application/index\view\search\sechuser.html";i:1507713893;s:70:"E:\htdoc\ThinkPHP5\public/../application/index\view\Common\header.html";i:1506406829;s:67:"E:\htdoc\ThinkPHP5\public/../application/index\view\Common\nav.html";i:1507605447;s:68:"E:\htdoc\ThinkPHP5\public/../application/index\view\Common\left.html";i:1507710017;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <?php 
		$style = db('userinfo')->where(array('uid' => session('uid')))->value('style');
     ?>
	<title><?php echo \think\Config::get('system.WEBNAME'); ?>-微博找人</title>
	<link rel="stylesheet" href="__STATIC__/Theme/<?php echo $style; ?>/Css/nav.css" />
	<link rel="stylesheet" href="__STATIC__/Theme/<?php echo $style; ?>/Css/sech_user.css" />
	<link rel="stylesheet" href="__STATIC__/Theme/<?php echo $style; ?>/Css/bottom.css" />
	<script type="text/javascript" src='__STATIC__/Js/jquery-1.7.2.min.js'></script>
    <script type="text/javascript" src='__STATIC__/Js/nav.js'></script>
<!--==========顶部固定导行条==========-->
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
        <!--=====左侧=====-->
    <div id="left" class='fleft'>
        <ul class='left_nav'>
            <li><a href="__ROOT__"><i class='icon icon-home'></i>&nbsp;&nbsp;首页</a></li>
            <li><a href="<?php echo url('User/atme'); ?>"><i class='icon icon-at'></i>&nbsp;&nbsp;提到我的</a></li>
            <li><a href="<?php echo url('User/comment'); ?>"><i class='icon icon-comment'></i>&nbsp;&nbsp;评论</a></li>
            <li><a href="<?php echo url('User/letter'); ?>"><i class='icon icon-letter'></i>&nbsp;&nbsp;私信</a></li>
            <li><a href="<?php echo url('User/keep'); ?>"><i class='icon icon-keep'></i>&nbsp;&nbsp;收藏</a></li>
        </ul>
        <div class="group">
            <fieldset><legend>分组</legend></fieldset>
            <ul>
                <?php 
                    $group = db("group")->where(array('uid' => session('uid')))->select();
                 ?>
                <li><a href="__ROOT__"><i class='icon icon-group'></i>&nbsp;&nbsp;全部</a></li>
                <?php if(is_array($group) || $group instanceof \think\Collection || $group instanceof \think\Paginator): if( count($group)==0 ) : echo "" ;else: foreach($group as $key=>$v): ?>
                    <li>
                        <a href="<?php echo url('Index/index', array('gid' => $v['id'])); ?>"><i class='icon icon-group'></i>&nbsp;&nbsp;<?php echo $v['name']; ?></a>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <span id='create_group'>创建新分组</span>
        </div>
    </div>
    
    <!--==========创建分组==========-->
    <script type='text/javascript'>
        var addGroup = "<?php echo url('Common:addGroup'); ?>";
    </script>
    <div id='add-group'>
        <div class="group_head">
            <span class='group_text fleft'>创建好友分组</span>
        </div>
        <div class='group-name'>
            <span>分组名称：</span>
            <input type="text" name='name' id='gp-name'>
        </div>
        <div class='gp-btn-wrap'>
            <span class='add-group-sub'>添加</span>
            <span class='group-cencle'>取消</span>
        </div>
    </div>
    <!--==========创建分组==========-->
        <div id='right'>
    		<p id='sech-logo'></p>
    		<div id='sech'>
    			<div>
	    			<form action="<?php echo url('sechUser'); ?>" method='get' name='search'>
	    				<input type="text" name='keyword' id='sech-cons' value='<?php if($keyword): ?><?php echo $keyword; else: ?>搜索微博、找人<?php endif; ?>'/>
	    				<input type="submit" value='搜&nbsp;索' id='sech-sub'/>
	    			</form>
    			</div>
    			<ul>
                    <li><span class='cur sech-type' url="<?php echo url('sechUser'); ?>">找人</span></li>
    				<li><span class='sech-type' url="<?php echo url('sechWeibo'); ?>">微博</span></li>
    			</ul>
    		</div>
    		<?php if(isset($result)): ?>
    		<div id='content'>
    			<?php if($result): ?>
	    		<div class='view_line'>
	                <strong>用户</strong>
	            </div>
	            <ul>
	            	<?php if(is_array($result) || $result instanceof \think\Collection || $result instanceof \think\Paginator): if( count($result)==0 ) : echo "" ;else: foreach($result as $key=>$v): ?>
	    			<li>
						<dl class='list-left'>
							<dt>
								<img src="
								<?php if($v["face80"]): ?>
									__ROOT__/Uploads/Face/<?php echo $v['face80']; else: ?>
									__STATIC__/Images/noface.gif
								<?php endif; ?>" width='80' height='80'/>
							</dt>
							<dd>
								<a href=""><?php echo str_replace($keyword, '<font style="color:red">' . $keyword . '</font>', $v['username']); ?></a>
							</dd>
							<dd>
								<i class='icon icon-boy'></i>&nbsp;
								<span>
									<?php if($v["location"]): ?>
										<?php echo $v['location']; else: ?>
										该用户未填写所在地
									<?php endif; ?>
								</span>
							</dd>
							<dd>
								<span>关注 <a href=""><?php echo $v['follow']; ?></a></span>
								<span class='bd-l'>粉丝 <a href=""><?php echo $v['fans']; ?></a></span>
								<span class='bd-l'>微博 <a href=""><?php echo $v['weibo']; ?></a></span>
							</dd>
						</dl>
	    				<dl class='list-right'>
	    					<?php if($v["mutual"]): ?>
	    						<dt>互相关注</dt>
	    						<dd class='del-follow' uid='<?php echo $v['uid']; ?>' type='1'>移除</dd>
    						<?php elseif($v["followed"]): ?>
                            	<dt>√&nbsp;已关注</dt>
                            	<dd class='del-follow' uid='<?php echo $v['uid']; ?>' type='1'>移除</dd>
                        	<?php else: ?>
	    						<dt class='add-fl' uid='<?php echo $v['uid']; ?>'>+&nbsp;关注</dt>
	    					<?php endif; ?>
	    				</dl>
	    			</li>
	    			<?php endforeach; endif; else: echo "" ;endif; ?>
    			</ul>
    			<div style="text-align:center;padding:20px;"><?php echo $page; ?></div>
    			<?php else: ?>
    				<p style='text-indent:7em;'>未找到与<strong style='color:red'><?php echo $keyword; ?></strong>相关的用户</p>
    			<?php endif; ?>
	        </div>
	    	<?php endif; ?>
    	</div>
    </div>
<!--==========内容主体结束==========-->
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
                    版权所有：后盾网 京ICP备10027771号-1 站长统计 All rights reserved, houdunwang.com services for Beijing 2008-2012 
                </p>
            </div>
        </div>
    </div>

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