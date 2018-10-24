{x2;if:!$userhash}
{x2;include:header}
<style>
html,body{
background-color: #ffffff;
}
</style>
<body>
	{x2;endif}
				<div class="box itembox" style="margin-bottom:0px;">
					<form action="index.php?user-master-user-batdel" method="post">
						<table class="table table-hover table-bordered">
							<thead>
								<tr class="info">
									<th>用户名</th>
									<th>姓名</th>
									<th>手机号</th>
									<th>身份证号</th>
									<th>角色</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								{x2;tree:$users['data'],user,uid}
								<tr>
									<td>{x2;v:user['username']}</td>
									<td>{x2;v:user['usertruename']}</td>
									<td>{x2;v:user['userphone']}</td>
									<td>{x2;v:user['userpassport']}</td>
									<td>{x2;$groups[v:user['usergroupid']]['groupname']}</td>
									<td>
										<div class="btn-group">
											<a target="_parent" class="btn" href="index.php?user-master-user-modify&userid={x2;v:user['userid']}&page={x2;$page}{x2;$u}"><em class="glyphicon glyphicon-edit"></em></a>
											{x2;if:v:user['userid'] != $_user['userid']}
											<a msg="删除后不能恢复，您确定要进行此操作吗？" class="btn confirm" href="index.php?user-master-user-del&userid={x2;v:user['userid']}&page={x2;$page}{x2;$u}"><em class="glyphicon glyphicon-remove"></em></a>
											{x2;endif}
										</div>
									</td>
								</tr>
								{x2;endtree}
							</tbody>
						</table>
					</form>
					<ul class="pagination pull-right">
						{x2;$users['pages']}
{x2;if:!$userhash}
</body>
</html>
{x2;endif}
