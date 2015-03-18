<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<title>登录_<?php echo (C("TITLE")); ?></title>
<script src="/Public/Framework/Easyui/jquery.min.js"></script>
<script src="/Public/Framework/Easyui/jquery.easyui.min.js"></script>
<script src="/Public/Framework/Easyui/locale/easyui-lang-zh_CN.js"></script>
<link rel="stylesheet" href="/Public/Framework/Easyui/themes/default/easyui.css" id="theme">
<link rel="stylesheet" href="/Public/Framework/Easyui/themes/icon.css">
<link rel="stylesheet" href="/Public/Css/icons.css">
<script src="/Public/Js/jQuery.cookie.js"></script>
<script src="/Public/Js/jQuery.oa.js"></script>
<script type="text/javascript">
var theme = $.cookie('theme') || 'default'; //全局变量
$(document).ready(function(){
    $("#theme").attr("href","/Public/Framework/Easyui/themes/"+theme+"/easyui.css");
});
</script>
<style type="text/css">
body{background:url(/Public/Images/bg.jpg) center top;font-family:"微软雅黑"}
form{width:280px;height:120px;margin:30px auto 0;}
form div label{float:left;display:block;width:65px;font-size:16px;padding-top:6px;}
form div{margin:8px auto;}
form div.input img{cursor:pointer}
#code{width:68px}
</style>
</head>

<body>
    <div class="easyui-dialog" title="登录_<?php echo (C("TITLE")); ?>" style="width:380px;height:280px" data-options="closable:false,iconCls:'icons-lock-lock'">
        <form id='form' method="post">
            <div class="input">
                <input class="easyui-textbox easyui-validatebox" type="text" name="name" value="guest" style="width:100%;height:40px;padding:12px" data-options="missingMessage:'请输入用户名',required:true,validType:{length:[2,20]},invalidMessage:'用户名长度 2 至 20 位'"  />
            </div>
            <div class="input">
                <input class="easyui-textbox easyui-validatebox" type="password" name="pass" value="123456" style="width:100%;height:40px;padding:12px" data-options="required:true,validType:{length:[6,20]},missingMessage:'请输入密码',invalidMessage:'密码长度 6 至 20 位'" />
            </div>
            <div class="input">
                <input class="easyui-textbox easyui-validatebox" type="text" name="code" id="code" size="4" style="width:140px;height:40px;padding:12px" data-options="validType:{length:[1,4]},invalidMessage:'验证码长度 1 至 4 位'" />
                <span style="margin-left:10px"><img id="code_img" align="top" onclick="changeCode()" src="<?php echo U('Login/code');?>" title="点击切换验证码" height="37" /></span>
            </div>
            <div  id="button" class="easyui-linkbutton" data-options="onClick:login" style="padding:5px 0px;width:100%;">
                <span style="font-size:14px;">立即登录</span>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(function(){
            $('input:text:first').focus();
            $('form').keyup(function(event){
                if(event.keyCode ==13) login();
            });
        });
        function changeCode(){
            var that = document.getElementById('code_img');
            that.src = that.src + '?' + Math.random();
        }
        function login(){
            var isValid = $('form').form('validate');
            if (!isValid) return false;
            $.messager.progress({text:'登录中，请稍候...'});
            $.post('', $("form").serialize(), function(data){
                $.messager.progress('close');
                if(!data.status){
                    $.Oa.tip('提示信息', data.info,'error');
                    changeCode();
                }else{
                    window.location.href = data.url;
                }
            },'json').error(function(){
                $.messager.progress({text:"登录失败，请联系管理员！3秒后关闭..."});
                setTimeout('$.messager.progress("close")',3000);
            });
            return false;
        }
    </script>
</body>
</html>