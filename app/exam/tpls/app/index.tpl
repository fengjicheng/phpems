{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="main box itembox">
			<h4 class="title" style="padding:10px;">我的考场 <!--<a href="index.php?exam-app-basics-open" class="btn btn-primary pull-right"><em class="glyphicon glyphicon-plus-sign"></em> 开通新考场</a></h4>-->
			<div class="col-xs-12" style="padding-left:0px;padding-top:40px;">
                {x2;if:is_array($basics)}
				{x2;tree:$basics,basic,bid}
				<div class="col-xs-3" style="width:20%">
					<a href="index.php?{x2;$_app}-app-index-setCurrentBasic&basicid={x2;v:basic['basicid']}" class="thumbnail ajax">
						<img src="{x2;if:v:basic['basicthumb']}{x2;v:basic['basicthumb']}{x2;else}app/core/styles/img/item.jpg{x2;endif}" alt="" width="100%">
					</a>
					<h5 class="text-center">{x2;v:basic['basic']}</h5>
				</div>
				{x2;if:v:bid % 5 == 0}
				<div class="col-xs-12"><hr /></div>
				{x2;endif}
				{x2;endtree}
                {x2;endif}
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-4 box itembox">
				<h4 class="title">公告</h4>
				<ul class="list-unstyled">
					<li><a href="">……</a></li>
					<li><a href="">……</a></li>
					<li><a href="">……</a></li>
				</ul>
			</div>
			<div class="col-xs-4 box itembox split">
				<h4 class="title">新闻</h4>
				<ul class="list-unstyled">
                    <li><a href="">……</a></li>
                    <li><a href="">……</a></li>
                    <li><a href="">……</a></li>
				</ul>
			</div>
			<div class="col-xs-4 box itembox">
				<h4 class="title">帮助</h4>
				<ul class="list-unstyled">
                    <li><a href="">……</a></li>
                    <li><a href="">……</a></li>
                    <li><a href="">……</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>
