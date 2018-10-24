{x2;if:!$userhash}
{x2;include:header}
    <style>
   	    div.content_wrap {width: 600px;height:380px;}
		div.content_wrap div.left{float: left;width: 250px;}
		div.content_wrap div.right{float: right;width: 340px;}
		div.zTreeDemoBackground {width:250px;height:362px;text-align:left;}
		
		ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}
		ul.log {border: 1px solid #617775;background: #f0f6e4;width:300px;height:170px;overflow: hidden;}
		ul.log.small {height:45px;}
		ul.log li {color: #666666;list-style: none;padding-left: 10px;}
		ul.log li.dark {background-color: #E3E3E3;}
		
		/* ruler */
		div.ruler {height:20px; width:220px; background-color:#f0f6e4;border: 1px solid #333; margin-bottom: 5px; cursor: pointer}
		div.ruler div.cursor {height:20px; width:30px; background-color:#3C6E31; color:white; text-align: right; padding-right: 5px; cursor: pointer}
    
    </style>
	<link rel="stylesheet" href="app/user/styles/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="app/user/styles/zTree/js/jquery.ztree.core.js"></script>
	<script type="text/javascript" src="app/user/styles/zTree/js/jquery.ztree.excheck.js"></script>
	<script type="text/javascript">
		var setting = {
				check: {
					enable: true,
					chkboxType: {"Y":"s", "N":"s"}
				},
				view: {
					dblClickExpand: false
				},
				data: {
					simpleData: {
						enable: true
					}
				},
				callback: {
					beforeClick: beforeClick,
					onCheck: onCheck
				}
		};
	    var zNodes =JSON.parse('{x2;$deptjson}');

		function beforeClick(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheck(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getCheckedNodes(true),
			v = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].id + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			var cityObj = $("#deptids");
			cityObj.val(v);
		}

		function showMenu() {
			var cityObj = $("#deptids");
			var cityOffset = $("#deptids").offset();
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");

			$("body").bind("mousedown", onBodyDown);
		}
		function hideMenu() {
			$("#menuContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "citySel" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
				hideMenu();
			}
		}

		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
		});
	</script>
<body>
<div id="menuContent" class="menuContent" style="display:none;z-index:99999; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; height: 300px;"></ul>
</div>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-2" style="padding-top:10px;margin-bottom:0px;">
				{x2;include:menu}
			</div>
			<div class="col-xs-10" id="datacontent">
{x2;endif}
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a></li>
							<li class="active">批量开通课程</li>
						</ol>
					</div>
				</div>
				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						批量开通课程
					</h4>
					<div id="tabs-260773" class="tabbable">
						<ul class="nav nav-tabs" style="margin-bottom:20px;">
							<li class="active">
								<a href="#panel-65699" data-toggle="tab">用户名列表开通</a>
							</li>
							<li>
								<a href="#panel-880294" data-toggle="tab">用户ID列表开通</a>
							</li>
							<li>
								<a href="#panel-888294" data-toggle="tab">用户组开通</a>
							</li>
							<li>
								<a href="#panel-888295" data-toggle="tab">组织机构开通</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="panel-65699" class="tab-pane active">
								<form action="index.php?exam-master-users-batopen" method="post" class="form-horizontal">
									<div class="form-group">
										<label class="control-label col-sm-2">用户名：</label>
									  	<div class="col-sm-9">
									  		<textarea class="form-control" rows="4" needle="needle" min="1" msg="您最少需要填写一个用户" name="usernames"></textarea>
									  		<span class="help-block">每个用户名请使用英文逗号隔开</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">考场ID：</label>
									  	<div class="col-sm-9">
										  	<textarea class="form-control" rows="4" needle="needle" msg="您最少需要填写一个考场" name="basics">{x2;$basicid}</textarea>
									  		<span class="help-block">每个考场ID请使用英文逗号隔开</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">时长：</label>
									  	<div class="col-sm-9 form-inline">
										  	<input size="5" name="days" class="form-control" type="text" needle="needle" msg="您最少需要填写一天" value="1"/> 天
										</div>
									</div>
									<div class="form-group">
									  	<label class="control-label col-sm-2"></label>
									  	<div class="col-sm-9">
										  	<button class="btn btn-primary" type="submit">提交</button>
										  	<input type="hidden" name="page" value="{x2;$page}"/>
										  	<input type="hidden" name="batopen" value="1"/>
										</div>
									</div>
								</form>
							</div>
							<div id="panel-880294" class="tab-pane">
								<form action="index.php?exam-master-users-batopen" method="post" class="form-horizontal">
									<div class="form-group">
										<label class="control-label col-sm-2">用户ID：</label>
									  	<div class="col-sm-9">
									  		<textarea class="form-control" rows="4" needle="needle" min="1" msg="您最少需要填写一个用户" name="userids"></textarea>
									  		<span class="help-block">每个ID请使用英文逗号隔开</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">考场ID：</label>
									  	<div class="col-sm-9">
										  	<textarea class="form-control" rows="4" needle="needle" msg="您最少需要填写一个考场" name="basics">{x2;$basicid}</textarea>
									  		<span class="help-block">每个考场ID请使用英文逗号隔开</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">时长：</label>
									  	<div class="col-sm-9 form-inline">
										  	<input size="5" name="days" class="form-control" type="text" needle="needle" msg="您最少需要填写一天" value="1"/> 天
										</div>
									</div>
									<div class="form-group">
									  	<label class="control-label col-sm-2"></label>
									  	<div class="col-sm-9">
										  	<button class="btn btn-primary" type="submit">提交</button>
										  	<input type="hidden" name="page" value="{x2;$page}"/>
										  	<input type="hidden" name="batopen" value="1"/>
										</div>
									</div>
								</form>
							</div>
							<div id="panel-888294" class="tab-pane">
								<form action="index.php?exam-master-users-batopen" method="post" class="form-horizontal">
									<div class="form-group">
										<label class="control-label col-sm-2">用户组ID：</label>
									  	<div class="col-sm-9">
									  		<textarea class="form-control" rows="4" needle="needle" min="1" msg="您最少需要填写一个用户组" name="usergroupids"></textarea>
									  		<span class="help-block">每个ID请使用英文逗号隔开</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">考场ID：</label>
									  	<div class="col-sm-9">
										  	<textarea class="form-control" rows="4" needle="needle" msg="您最少需要填写一个考场" name="basics">{x2;$basicid}</textarea>
									  		<span class="help-block">每个考场ID请使用英文逗号隔开</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">时长：</label>
									  	<div class="col-sm-9 form-inline">
										  	<input size="5" name="days" class="form-control" type="text" needle="needle" msg="您最少需要填写一天" value="1"/> 天
										</div>
									</div>
									<div class="form-group">
									  	<label class="control-label col-sm-2"></label>
									  	<div class="col-sm-9">
										  	<button class="btn btn-primary" type="submit">提交</button>
										  	<input type="hidden" name="page" value="{x2;$page}"/>
										  	<input type="hidden" name="batopen" value="1"/>
										</div>
									</div>
								</form>
							</div>
							<div id="panel-888295" class="tab-pane">
								<form action="index.php?exam-master-users-batopen" method="post" class="form-horizontal">
									<div class="form-group">
										<label class="control-label col-sm-2">部门id：</label>
									  	<div class="col-sm-9">
									  		<textarea class="form-control"  readonly rows="4" needle="needle" min="1" msg="您最少需要选择一个组织" id="deptids" name="deptids"></textarea>
									  		<span class="help-block"><a id="menuBtn" style="color:#337AB7;" href="#" onclick="showMenu(); return false;">点击选择</a></span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">考场ID：</label>
									  	<div class="col-sm-9">
										  	<textarea class="form-control" rows="4" needle="needle" msg="您最少需要填写一个考场" name="basics">{x2;$basicid}</textarea>
									  		<span class="help-block">每个考场ID请使用英文逗号隔开</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2">时长：</label>
									  	<div class="col-sm-9 form-inline">
										  	<input size="5" name="days" class="form-control" type="text" needle="needle" msg="您最少需要填写一天" value="1"/> 天
										</div>
									</div>
									<div class="form-group">
									  	<label class="control-label col-sm-2"></label>
									  	<div class="col-sm-9">
										  	<button class="btn btn-primary" type="submit">提交</button>
										  	<input type="hidden" name="page" value="{x2;$page}"/>
										  	<input type="hidden" name="batopen" value="1"/>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>
{x2;endif}