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
	<script type="text/javascript">
		var setting = {
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				onClick: onClick
			}
		};

		var zNodes =JSON.parse('{x2;$deptjson}');
		
		function onClick(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getSelectedNodes(),
			v = "";
			nodes.sort(function compare(a,b){return a.id-b.id;});
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].name + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			var cityObj = $("#citySel");
			cityObj.attr("value", v);
			u = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				u += nodes[i].id + ",";
			}
			if (u.length > 0 ) u = u.substring(0, u.length-1);
			var deptid = $("#deptid");
			deptid.attr("value", u);
		}

		function showMenu() {
			var cityObj = $("#citySel");
			var cityOffset = $("#citySel").offset();
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top - $("#menuContent").outerHeight() + "px"}).slideDown("fast");

			$("body").bind("mousedown", onBodyDown);
		}
		function hideMenu() {
			$("#menuContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
				hideMenu();
			}
		}

		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
		});
	</script>
<body>
<div id="menuContent" class="menuContent" style="display:none;z-index:99999; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0; width:160px;"></ul>
</div>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-2" style="padding-top:10px;margin-bottom:0px;">
				{x2;include:menu}
			</div>
			<div class="col-xs-10" id="datacontent">
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a></li>
							<li><a href="index.php?user-master-user">用户管理</a></li>
							<li class="active">修改用户</li>
						</ol>
					</div>
				</div>
				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title">{x2;$user['username']}</h4>
					<div id="tabs-694325" class="tabbable" style="margin-top:20px;">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#panel-344373" data-toggle="tab">用户资料</a>
							</li>
							<li>
								<a href="#panel-788842" data-toggle="tab">修改角色</a>
							</li>
							<li>
								<a href="#panel-788885" data-toggle="tab">修改密码</a>
							</li>
							<a class="pull-right btn btn-primary" href="index.php?user-master-user">用户列表</a>
						</ul>
						<div class="tab-content" style="margin-top:20px;">
							<div id="panel-344373" class="tab-pane active">
								<form action="index.php?user-master-user-modify" method="post" class="form-horizontal">
									<fieldset>
										{x2;tree:$forms,form,fid}
										<div class="form-group">
											<label for="{x2;v:form['id']}" class="control-label col-sm-2">{x2;v:form['title']}：</label>
											<div class="col-sm-9">
											{x2;v:form['html']}
											</div>
										</div>
										{x2;endtree}
										<div class="form-group">
											<label class="control-label col-sm-2"></label>
											<div class="col-sm-9">
												<button class="btn btn-primary" type="submit">提交</button>
												<input type="hidden" name="userid" value="{x2;$user['userid']}"/>
												<input type="hidden" name="modifyuserinfo" value="1"/>
												<input type="hidden" name="page" value="{x2;$page}"/>
                                                {x2;if:is_array($search)}
												{x2;tree:$search,arg,aid}
												<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
												{x2;endtree}
                                                {x2;endif}
											</div>
										</div>
									</fieldset>
								</form>
							</div>
							<div id="panel-788842" class="tab-pane">
								<form action="index.php?user-master-user-modify" method="post" class="form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="control-label col-sm-2">电子邮箱：</label>
											<div class="col-sm-9"><span class="help-block">{x2;$user['useremail']}</span></div>
										</div>
										<div class="form-group">
											<label for="groupid" class="control-label col-sm-2">用户角色：</label>
											<div class="col-sm-3">
												<select class="form-control" name="groupid" id="groupid">
													{x2;tree:$groups,group,gid}
													<option value="{x2;v:group['groupid']}"{x2;if:$user['usergroupid'] == v:group['groupid']}selected{x2;endif}>{x2;v:group['groupname']}</option>
													{x2;endtree}
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"></label>
											<div class="col-sm-9">
												<button class="btn btn-primary" type="submit">提交</button>
												<input type="hidden" name="userid" value="{x2;$user['userid']}"/>
												<input type="hidden" name="modifyusergroup" value="1"/>
												<input type="hidden" name="page" value="{x2;$page}"/>
                                                {x2;if:is_array($search)}
												{x2;tree:$search,arg,aid}
												<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
												{x2;endtree}
                                                {x2;endif}
											</div>
										</div>
									</fieldset>
								</form>
							</div>
							<div id="panel-788885" class="tab-pane">
								<form action="index.php?user-master-user-modify" method="post" class="form-horizontal">
									<fieldset>
										<div class="form-group">
											<label for="passowrd1" class="control-label col-sm-2">新密码：</label>
											<div class="col-sm-4">
												<input class="form-control" id="passowrd1" type="password" name="args[password]" needle="true" datatype="password" msg="密码字数必须在6位以上"/>
											</div>
										</div>
										<div class="form-group">
											<label for="password2" class="control-label col-sm-2">重复密码：</label>
											<div class="col-sm-4">
												<input class="form-control" id="password2" type="password" name="args[password2]" needle="true" equ="passowrd1" msg="前后两次密码必须一致且不能为空"/>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"></label>
											<div class="col-sm-9">
												<button class="btn btn-primary" type="submit">提交</button>
												<input type="hidden" name="userid" value="{x2;$user['userid']}"/>
												<input type="hidden" name="modifyuserpassword" value="1"/>
												<input type="hidden" name="page" value="{x2;$page}"/>
                                                {x2;if:is_array($search)}
												{x2;tree:$search,arg,aid}
												<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
												{x2;endtree}
                                                {x2;endif}
											</div>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>
