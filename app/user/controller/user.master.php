<?php
/*
 * Created on 2016-5-19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class action extends app
{
	public function display()
	{
		$action = $this->ev->url(3);
		$search = $this->ev->get('search');
		$this->u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$this->u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('search',$search);
		if(!method_exists($this,$action))
		$action = "index";
		$this->$action();
		exit;
	}

	private function del()
	{
		$page = $this->ev->get('page');
		$userid = $this->ev->get('userid');
		$this->user->delUserById($userid);
		$message = array(
			'statusCode' => 200,
			"message" => "操作成功",
		    "navTabId" => "",
		    "rel" => "",
		    "callbackType" => "forward",
		    "forwardUrl" => "index.php?user-master-user&page={$page}{$this->u}"
		);
		exit(json_encode($message));
	}

	private function batdel()
	{
		if($this->ev->get('action') == 'delete')
		{
			$page = $this->ev->get('page');
			$delids = $this->ev->get('delids');
			foreach($delids as $userid => $p)
			$this->user->delUserById($userid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "navTabId" => "",
			    "rel" => "",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?user-master-user&page={$page}{$this->u}"
			);
			exit(json_encode($message));
		}
	}

	private function modify()
	{
		$page = $this->ev->get('page');
		if($this->ev->get('modifyusergroup'))
		{
			$groupid = $this->ev->get('groupid');
			$userid = $this->ev->get('userid');
			$this->user->modifyUserGroup($groupid,$userid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?user-master-user&page={$page}{$this->u}"
			);
			exit(json_encode($message));
		}
		elseif($this->ev->get('modifyuserinfo'))
		{
			$args = $this->ev->get('args');
			$userid = $this->ev->get('userid');
			$user = $this->user->getUserById($userid);
			$group = $this->user->getGroupById($user['usergroupid']);
			$args = $this->module->tidyNeedFieldsPars($args,$group['groupmoduleid'],array('iscurrentuser'=> $userid == $this->_user['sessionuserid'],'group' => $group));
			$id = $this->user->modifyUserInfo($args,$userid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
			    "callbackType" => "forward",
			    "forwardUrl" => "index.php?user-master-user&page={$page}{$this->u}"
			);
			exit(json_encode($message));
		}
		elseif($this->ev->get('modifyuserpassword'))
		{
			$args = $this->ev->get('args');
			$userid = $this->ev->get('userid');
			if($args['password'] == $args['password2'] && $userid)
			{
				$id = $this->user->modifyUserPassword($args,$userid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?user-master-user&page={$page}{$this->u}"
				);
				exit(json_encode($message));
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败",
				    "navTabId" => "",
				    "rel" => ""
				);
				exit(json_encode($message));
			}
		}
		else
		{
		    $deptarray =\Model\Dept::where([])->orderBy('deptsort','desc')->get(['deptid as id', 'deptparentid as pId', 'deptname as name'])->toArray();
		    $list = array();
		    foreach ($deptarray as $k=>$v) {
		        // 设置三级目录的显示
		        if($v['pId'] == 0){
		            $list[$k]['isParent'] = true; //是否是父级
		            $list[$k]['open'] = true;//文件夹节点全部展开
		        }
		        $list[$k]['id'] = $v['id'];
		        $list[$k]['pId'] = $v['pId'];//父级id
		        $list[$k]['name'] = $v['name'];//文件名称
		        
		        
		    }
		    $deptjson=json_encode($list);
		    $this->tpl->assign('deptjson',$deptjson);
			$userid = $this->ev->get('userid');
			$user = $this->user->getUserById($userid);
			$group = $this->user->getGroupById($user['usergroupid']);
			$fields = $this->module->getMoudleFields($group['groupmoduleid'],array('iscurrentuser'=> $userid == $this->_user['sessionuserid'],'group' => $this->user->getGroupById($this->_user['sessiongroupid'])));
			$forms = $this->html->buildHtml($fields,$user);
			$this->tpl->assign('moduleid',$group['groupmoduleid']);
			$this->tpl->assign('fields',$fields);
			$this->tpl->assign('forms',$forms);
			$this->tpl->assign('user',$user);
			$this->tpl->assign('page',$page);
			$this->tpl->display('modifyuser');
		}
	}
    //批量导入用户
	private function batadd()
	{
		if($this->ev->post('insertUser'))
		{
			$uploadfile = $this->ev->get('uploadfile');
			if(!file_exists($uploadfile))
			{
				$message = array(
					'statusCode' => 300,
					"message" => "上传文件不存在"
				);
				exit(json_encode($message));
			}
			else
			{
			    //文件的扩展名
			    $ext = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
			    if($ext == 'xlsx'){
			        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
			    }elseif($ext == 'xls'){
			        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
			    }
			    
			    $reader->setReadDataOnly(TRUE);
			    $spreadsheet = $reader->load($uploadfile); //载入excel表格
			    $worksheet = $spreadsheet->getActiveSheet();
			    $highestRow = $worksheet->getHighestRow(); // 总行数
			    $highestColumn = $worksheet->getHighestColumn(); // 总列数
			    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
				$defaultgroup = $this->user->getDefaultGroup();
				$strings = $this->G->make('strings');
				for ($row = 2; $row <= $highestRow; ++$row)
				{
				    if(!empty($worksheet->getCellByColumnAndRow(1, $row)->getValue()))
				    {
					    $args = array();
					    //用户名
					    $args['username'] = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()," \n\t");
					    //验证用户名是否合法
					    if($strings->isUserName($args['username']))
					    {
						    $u = $this->user->getUserByUserName($args['username']);
						    if(!$u)
						    {
						        $args['usertruename'] = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue()," \n\t");;
						        if(empty(trim($worksheet->getCellByColumnAndRow(2, $row)->getValue()," \n\t")))
						            $args['userpassword'] = md5("123456");
						        else
						            $args['userpassword'] = md5(trim($worksheet->getCellByColumnAndRow(2, $row)->getValue()," \n\t"));
						        //性别
						        $args['usergender'] = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue()," \n\t");
						        //学历
						        $args['userdegree'] = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue()," \n\t");
						        //身份证
						        $args['userpassport'] = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue()," \n\t");
						        //部门ID
						        $args['deptid'] = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue()," \n\t");
						        //手机号
						        $args['userphone'] = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue()," \n\t");
						        $args['usergroupid'] = 8;
						        $args['useremail'] = $args['username']."@qhyhgf.com";
						       
						        $this->user->insertUser($args);
						    }
					    }
				    }
				}
				//exit(json_encode($args));
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?user-master-user"
				);
				exit(json_encode($message));
			}
		}
		else
		{
			$this->tpl->display('batadduser');
		}
	}

	private function add()
	{
		if($this->ev->post('insertUser'))
		{
			$args = $this->ev->post('args');
			if($args['userpassword'] == $args['userpassword2'])
			{
				$userbyname = $this->user->getUserByUserName($args['username']);
				$userbyemail = $this->user->getUserByEmail($args['useremail']);
				if($userbyname)
				    $errmsg = "这个用户名已经被注册了";
				if($userbyemail)
				    $errmsg = "这个邮箱已经被注册了";
				if($errmsg)
				{
					$message = array(
						'statusCode' => 300,
						"message" => "{$errmsg}",
					    "navTabId" => "",
					    "rel" => ""
					);
					exit(json_encode($message));
				}
				$args['userpassword'] = md5($args['userpassword']);
				$search = $this->ev->get('search');
				$u = '';
				if($search)
				{
					foreach($search as $key => $arg)
					{
						$u .= "&search[{$key}]={$arg}";
					}
				}
				unset($args['userpassword2']);
				$id = $this->user->insertUser($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "index.php?user-master-user&page={$page}{$this->u}"
				);
				exit(json_encode($message));
			}
		}
		else
		{
		    $deptarray =\Model\Dept::where([])->orderBy('deptsort','desc')->get(['deptid as id', 'deptparentid as pId', 'deptname as name'])->toArray();
		    $list = array();
		    foreach ($deptarray as $k=>$v) {
		        // 设置三级目录的显示
		        if($v['pId'] == 0){
		            $list[$k]['isParent'] = true; //是否是父级
		            $list[$k]['open'] = true;//文件夹节点全部展开
		        }
		        $list[$k]['id'] = $v['id'];
		        $list[$k]['pId'] = $v['pId'];//父级id
		        $list[$k]['name'] = $v['name'];//文件名称
		        
		        
		    }
		    $deptjson=json_encode($list);
		    $this->tpl->assign('deptjson',$deptjson);
			$this->tpl->display('adduser');
		}
	}

	private function index()
	{
		$page = $this->ev->get('page')?$this->ev->get('page'):1;
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$args = array();
		if($search['userid'])$args[] = array('AND',"userid = :userid",'userid',$search['userid']);
		if($search['username'])$args[] = array('AND',"username LIKE :username",'username','%'.$search['username'].'%');
		if($search['userpassport'])$args[] = array('AND',"userpassport  LIKE :userpassport",'userpassport','%'.$search['userpassport'].'%');
		if($search['usertruename'])$args[] = array('AND',"usertruename  LIKE :usertruename",'usertruename','%'.$search['usertruename'].'%');
		if($search['groupid'])$args[] = array('AND',"usergroupid = :usergroupid",'usergroupid',$search['groupid']);
		if($search['stime'] || $search['etime'])
		{
			if(!is_array($args))$args = array();
			if($search['stime']){
				$stime = strtotime($search['stime']);
				$args[] = array('AND',"userregtime >= :userregtime",'userregtime',$stime);
			}
			if($search['etime']){
				$etime = strtotime($search['etime']);
				$args[] = array('AND',"userregtime <= :userregtime",'userregtime',$etime);
			}
		}
		$users = $this->user->getUserList($page,10,$args);
		$this->tpl->assign('users',$users);
		$this->tpl->assign('search',$search);
		$this->tpl->assign('u',$u);
		$this->tpl->assign('page',$page);
		$this->tpl->display('user');
	}
}


?>
