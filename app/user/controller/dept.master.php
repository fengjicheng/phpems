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
	private function deptuserview()
	{
	    $page = $this->ev->get('page')?$this->ev->get('page'):1;
	    $search = $this->ev->get('search');
	    $deptid= $this->ev->get("deptid");
	    if($deptid)$args[] = array('AND',"deptid = :deptid",'deptid',$deptid);
	    $users = $this->user->getUserList($page,10,$args);
	    $this->tpl->assign('users',$users);
	    $this->tpl->assign('search',$search);
	    $this->tpl->assign('u',$u);
	    $this->tpl->assign('page',$page);
	    $this->tpl->display('deptuserview');
	}
	private function index()
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
		$this->tpl->display('dept');
	}
}


?>
