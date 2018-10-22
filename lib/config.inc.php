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
define('USEWX',false);
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
define('SERVER', [
    'host' => '127.0.0.1', //Redis地址IP
    'port' => 6379, //Redis端口号
    'database' => 9, //Redis数据库索引
]);
//公众号设置
define('WXAPPID','***');
define('WXAPPSECRET','***');
define('WXMCHID','***');
define('WXKEY','***');
//支付宝设置
define('ALIPART','***');
define('ALIKEY','***');
define('ALIACC','i@oiuv.cn');
 
//企业微信设置
define('CorpId','***'); //企业号CorpId
define('CorpSecret','***'); //企业号凭证密钥
define('AppId','i@oiuv.cn'); //开放平台AppId
define('AppSecret','i@oiuv.cn'); //开放平台凭证密钥

//系统设置
define('Contact','http://www.qhyhgf.com'); //联系我们
define('CustomerCompanyName','青海盐湖工业股份有限公司'); //公司名称
define('SystemName','盐湖股份在线模拟考试系统'); //系统名称
define('SoftName','盐湖股份'); //软件名称
define('Copyright','<a href="">Copyright © qhyhgf.com  2018-2023</a>'); //软件名称



