<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <script src="http://api.geetest.com/get.php"></script>
    <title>极验行为式验证 php 类网站安装测试页面</title>
</head>
<body>
    <style type="text/css">

        .container{
            width: 960px;
            margin: 0 auto;
        }
        .content{
            width: 960px;
            margin: 10 auto;
            border-top: 1px solid #ccc;

        }
        .box{
            width:300px;
            margin: 30px auto; 
        }
        .header{
            margin: 80px auto 30px auto;
            text-align: center;
            font-size: 34px;
        }
        input{
            width: 200px;
            padding: 6px 9px;
        }
        button{
            cursor: pointer;
            line-height: 35px;
            width: 110px;
            margin:30px 0 0 90px;
            border: 1px solid #FFFFF0;
            background-color: #31C552;

            border-radius: 4px;
            font-size: 14px;    
            color: #FFFFF0; 
        }
        .mes-button {
            display: inline-block;
            width: 100px;
            height: 35px;
            line-height: 1em;
            margin-left: 10px;
            margin-top: 0;
        }
        .mes-input {
            width: 170px;
            margin-top: 0;  
        }
        .mes-box {
            margin: 10px auto;
        }
        .reminder {
            color: red;
        }
            </style>

    <div class="container">
        <div class="header">
            极验行为式验证 php 类网站安装测试页面
        </div>
        <div class="content">
            <form method="post" action="../msg/VerifyMsgServlet.php">
                <div class="box">
                    <label>手机：</label>
                    <input type="text" name="phone" id="phone"/>
                </div>
                <div class="box">
                    <label>密码：</label>
                    <input type="password" name="password" value="geetest"/>
                </div>
                <div class="box" id="div_id_embed">
                <script type="text/javascript">
                    //get  geetest server status, use the failback solution
                    $.ajax({
                        url : "../msg/StartMsgCapthcaServlet.php",
                        type : "get",
                        dataType : 'JSON',
                        success : function(result) {
                            console.log(result);
                            if (result.success) {
                                //1. use geetest capthca
                                window.gt_captcha_obj = new window.Geetest({
                                    gt : result.gt,
                                    challenge : result.challenge,
                                    product : 'embed'
                                });

                                gt_captcha_obj.appendTo("#div_id_embed");

                                //Ajax request demo,if you use submit form ,then ignore it 
                                // gt_captcha_obj.onSuccess(function() {
                                //     geetest_ajax_results()
                                // });

                            } else {
                                //failback :use your own captcha template
                                //Geetest Server is down,Please use your own captcha system in your web page
                                //or use the simple geetest failback solution
                                $("#div_id_embed").html('failback:gt-server is down ,please use your own captcha front');
                                //document.write('gt-server is down ,please use your own captcha')
                            }

                        }
                    })
                </script>
                </div>
                <div class="box mes-box">
                    <label>短信验证码：</label><br/>
                </div>
                <div class="box mes-box">
                    <input type="text" class="mes-input" name="code" value=""/>
                    <button type="button" class="mes-button" id="getmsg">获取验证码</button>
                </div>
                <div class="box reminder">
                </div>
                 <div class="box">
                    <button id="submit_button">提交</button>
                </div>
            </form>
            <script type="text/javascript">
                // function geetest_refresh() {
                //     console.log("you can use this api in your own js function")
                //     gt_captcha_obj.refresh();
                // }

                // function geetest_ajax_results() {
                //     value = gt_captcha_obj.getValidate();
                //     // var phone = {"phone":$("#phone").val()}
                //     value.phone = $("#phone").val()
                //     result = JSON.stringify(value);
                //     // console.log(value);
                //     console.log(result);
                //     // $.ajax({
                //     //     url : "../web/VerifyLoginServlet.php",//todo:set the servelet of your own
                //     //     type : "post",
                //     //     // dataType : 'JSON',
                //     //     data : "value="+value,
                //     //     success : function(sdk_result) {
                //     //         console.log(sdk_result);
                //     //     }
                //     // });
                // }
                $(function() {
                    $("#getmsg").click(function(){
                        value = gt_captcha_obj.getValidate();
                        value.phone = $("#phone").val()
                        result = JSON.stringify(value);
                        $.ajax({
                            type:'POST',
                            url:'../msg/VerifyGeetestServlet.php',
                            data:"value="+result,
                            success:function(result){
                                console.log(result);
                                if(result==1){
                                    $(".reminder").html('短信验证发送成功');
                                }else if(result==-6){
                                    $(".reminder").html('滑动验证未通过');
                                }else{
                                    $(".reminder").html('短信验证发送失败');
                                }
                            }
                        })
                    })
                })
            </script>
        </div>
    </div>
</body>
</html>