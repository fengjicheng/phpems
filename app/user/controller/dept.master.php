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
		if(!method_exists($this,$action))
		    $action = "index";
		$this->$action();
		exit;
	}

	//批量导入部门
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
	            for ($row = 2; $row <= $highestRow; ++$row)
	            {
	                if(!empty($worksheet->getCellByColumnAndRow(1, $row)->getValue()))
	                {
	                    $args = array();
	                    //验证用户名是否合法
	                    $d =\Model\Dept::find(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()," \n\t"));
	                    if(!$d)
	                    {
	                        $d = new \Model\Dept;
	                        $d->deptid=trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()," \n\t");
	                        $d->deptname=trim($worksheet->getCellByColumnAndRow(2, $row)->getValue()," \n\t");
	                        $d->deptparentid=trim($worksheet->getCellByColumnAndRow(3, $row)->getValue()," \n\t");
	                        $d->deptsort=trim($worksheet->getCellByColumnAndRow(4, $row)->getValue()," \n\t");
	                        
	                    }else{
	                        $d->deptname=trim($worksheet->getCellByColumnAndRow(2, $row)->getValue()," \n\t");
	                        $d->deptparentid=trim($worksheet->getCellByColumnAndRow(3, $row)->getValue()," \n\t");
	                        $d->deptsort=trim($worksheet->getCellByColumnAndRow(4, $row)->getValue()," \n\t");
	                    }
	                    //exit(json_encode($d));
	                    $d->save();
	                }
	            }
	            //exit(json_encode($args));
	            $message = array(
	                'statusCode' => 200,
	                "message" => "操作成功",
	                "callbackType" => "forward",
	                "forwardUrl" => "index.php?user-master-dept"
	            );
	            exit(json_encode($message));
	        }
	    }
	    else
	    {
	        $this->tpl->display('batadddept');
	    }
	}
	private function selectactor()
	{
		$groupid = $this->ev->get('groupid');
		$group = $this->user->getGroupById($groupid);
		if($group)
		{
			$this->user->selectDefaultActor($groupid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "reload"
			);
		}
		else
		$message = array(
			'statusCode' => 300,
			"message" => "操作失败，存在同名角色！"
		);
		exit(json_encode($message));
	}

	private function modifyactor()
	{
		$page = $this->ev->get('page');
		if($this->ev->get('modifyactor'))
		{
			$groupid = $this->ev->get('groupid');
			$args = $this->ev->get('args');
			$r = $this->user->modifyActor($groupid,$args);
			if($r)
			{
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?user-master-actor"
				);
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，存在同名角色！",
				    "callbackType" => ''
				);
			}
			exit(json_encode($message));
		}
		else
		{
			$groupid = $this->ev->get('groupid');
			$group = $this->user->getGroupById($groupid);
			$this->tpl->assign('group',$group);
			$this->tpl->display('modifyactor');
		}
	}

	private function delactor()
	{
		$page = intval($this->ev->get('page'));
		$groupid = $this->ev->get('groupid');
		$r = $this->user->delActorById($groupid);
		if($r)
		{
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
				"forwardUrl" => "index.php?user-master-actor&page={$page}"
			);
		}
		else
		{
			$message = array(
				'statusCode' => 300,
				"message" => "操作失败，该角色下存在用户，请删除所有用户后再删除本角色"
			);
		}
		exit(json_encode($message));
	}

	private function add()
	{
		if($this->ev->post('insertactor'))
		{
			$args = $this->ev->post('args');
			$id = $this->user->insertActor($args);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
				"forwardUrl" => "index.php?user-master-actor&moduleid={$args['groupmoduleid']}"
			);
			exit(json_encode($message));
		}
		else
		{
			$this->tpl->display('addactor');
		}
	}

	private function index()
	{
	    $deptarray =\Model\Dept::where([])->orderBy('deptsort','desc')->get(['deptid as id', 'deptparentid as pId', 'deptname as name'])->toArray();
	    $list = array();
	    foreach ($deptarray as $k=>$v) {
	        // 设置三级目录的显示
	        if($v['pId'] == 0){
	            //$list[$k]['isParent'] = true; //是否是父级
	            $list[$k]['open'] = true;//文件夹节点全部展开
	        }
	        $list[$k]['id'] = $v['id'];
	        $list[$k]['pId'] = $v['pId'];//父级id
	        $list[$k]['name'] = $v['name'];//文件名称
	        
	        
	    }
	    $deptjson=json_encode($list);
	    $this->tpl->assign('deptjson',$deptjson);
		$this->tpl->display('dept');
	}
}


?>
