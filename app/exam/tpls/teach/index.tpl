{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10">
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-teach">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li class="active">首页</li>
			</ul>
			<div class="row-fluid">
				<div class="col-xs-12">
						<h5 class="title">
							开发者信息
						</h5>
						<p>
							开发者：{x2;c:AuthorName}
						</p>
						<p>
							 电&emsp;话：{x2;c:AuthorPhone}
						</p>
						<p>
							 版本号：{x2;c:PE_VERSION}
						</p>
					</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
