<?php

define('DOMAINTYPE','off');
define('CH','exam_');
define('CDO','');
define('CP','/');
define('CRT',180);
define('CS',md5(base64_encode($_SERVER['HTTP_HOST'])));
define('HE','utf-8');
define('PN',10);
define('TIME',time());
define('DEBUG', true); //开启日志和错误调试
if(dirname($_SERVER['SCRIPT_NAME']))
define('WP','http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']));
else
define('WP','http://'.$_SERVER['SERVER_NAME'].'/');

define('DB','phpems');//MYSQL鏁版嵁搴撳悕
define('DH','127.0.0.1');//MYSQL涓绘満鍚嶏紝涓嶇敤鏀�
define('DU','root');//MYSQL鏁版嵁搴撶敤鎴峰悕
define('DP','168168');//MYSQL鏁版嵁搴撶敤鎴峰瘑鐮�
define('DTH','x2_');//绯荤粺琛ㄥ墠缂�锛屼笉鐢ㄦ敼

define('REDIS',true);
define('REDISSERVER', [
    'host' => '127.0.0.1', //Redis地址IP
    'port' => 6379, //Redis端口号
    'database' => 9, //Redis数据库索引
]);
//公众号设置
define('USEWX',false);
define('WXAPPID','wx362f9622acb2216e');
define('WXAPPSECRET','e34b10346849db507e733b7a7e3cf191');
define('WXMCHID','***');
define('WXKEY','***');
//支付宝设置
define('ALIPART','***');
define('ALIKEY','***');
define('ALIACC','i@oiuv.cn');
 
//企业微信设置
define('CorpId','wx58f12779bc0cba3a'); //企业号CorpId
define('CorpSecret','uyqisWaxr0y7orsmzLYcdl8SNb0-T0muMBP-oBdmMFrylTJAAZK7T4ow-QweJxFV'); //企业号凭证密钥
define('AppId','i@oiuv.cn'); //开放平台AppId
define('AppSecret','i@oiuv.cn'); //开放平台凭证密钥

//系统设置
define('Contact','http://www.qhyhgf.com'); //联系我们
define('CustomerCompanyName','青海盐湖工业股份有限公司'); //公司名称
define('SystemName','盐湖股份在线模拟考试系统'); //系统名称
define('SoftName','盐湖股份'); //软件名称
define('AuthorName','盐湖股份信息中心开发组'); //开发者名称
define('AuthorPhone','0979-8448118'); //开发者电话
define('Copyright','<a href="">Copyright © qhyhgf.com  2018-2023</a>'); //版权
define('PhoneCopyright','盐湖股份在线模拟系统<br />Copyright ©qhyhgf.com  2018-2023'); //版权
define('MasterLogo','<h1 style="color:#337AB7;"><img src="app/core/styles/img/logo3.png" style="height:60px;margin-top:-10px;"/>&nbsp;盐湖股份管理平台</h1>'); //后台管理logo
define('PhoneLogo','<img src="app/core/styles/img/logo3.png" style="width:6rem;">');
define('AppLogo','<h1 style="font-size:42px;color:#337AB7;"><img src="app/core/styles/img/logo3.png" style="height:60px;margin-top:-10px;">&nbsp;<b>盐湖股份</b></h1>'); //前台logo



