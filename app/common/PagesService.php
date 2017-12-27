<?php
namespace app\common;
use yii;
use yii\data\Pagination;

class PagesService
{

    public function show_page ($count, $page_size, $ajax = false,$show_input = true,$show_container = 'list_content')
    {
        $page = max(1, yii::$app->request->get('page'));
        $Pagination = new Pagination();
        // 搜索提交数据的基础url
        $url = $Pagination->createUrl(0, $page_size);
        $page_count = ceil($count / $page_size); // 计算得出总页数

        $init = 1;
        $page_len = 7;
        $max_p = $page_count;
        $pages = $page_count;

        // 判断当前页码
        $page = (empty($page) || $page < 0) ? 1 : $page;
        // 分页功能代码
        $page_len = ($page_len % 2) ? $page_len : $page_len + 1; // 页码个数
        $pageoffset = ($page_len - 1) / 2; // 页码个数左右偏移量
        $ajax_item = '';
        if ($ajax == true) {
            $ajax_item = 'onclick = "ticketLoadData($(this).attr(\'href\')+\'&frompage=1\',\'#'.$show_container.'\'); return false;"';
        }
        $navs = '';
        if ($pages != 0) {
            if ($page != 1) {
                // $navs .= "<a href=\"" .
                // $Pagination->createUrl(0,yii::$app->params['pageSize']) .
                // "\">首页</a> "; // 第一页
                $navs .= "<li><a $ajax_item href=\"" .
                    $Pagination->createUrl($page - 2,
                        $page_size) . "\"><<上页</a></li>"; // 上一页
            } else {
                // $navs .= "<span class='disabled'>首页</span>";
                $navs .= "<li class='prev disabled'><span class='disabled'><<上页</span></li>";
            }
            if ($pages > $page_len) {
                // 如果当前页小于等于左偏移
                if ($page <= $pageoffset) {
                    $init = 1;
                    $max_p = $page_len;
                } else                 // 如果当前页大于左偏移
                {
                    // 如果当前页码右偏移超出最大分页数
                    if ($page + $pageoffset >= $pages + 1) {
                        $init = $pages - $page_len + 1;
                    } else {
                        // 左右偏移都存在时的计算
                        $init = $page - $pageoffset;
                        $max_p = $page + $pageoffset;
                    }
                }
            }
            for ($i = $init; $i <= $max_p; $i ++) {
                if ($i == $page) {
                    $navs .= "<li class='active'><span class='current'> " . $i . ' </span></li>';
                } else {
                    $navs .= " <li><a $ajax_item href=\"" .
                        $Pagination->createUrl($i - 1,
                            $page_size) . "\">" . $i .
                        "</a></li>";
                }
            }
            if ($page != $pages) {
                $navs .= " <li><a $ajax_item href=\"" .
                    $Pagination->createUrl($page,
                        $page_size) . "\">下页>></a></li> "; // 下一页
                // $navs .= "<a href=\"" .
                // $Pagination->createUrl($page_count-1,yii::$app->params['pageSize'])
                // . "\">末页</a>"; // 最后一页
            } else {
                $navs .= "<li class='next disabled'><span class='disabled'>下页>></span></li>";
                // $navs .= "<span class='disabled'>末页</span>";
            }
            if ($show_input == true) {
                $navs .= '<li style="line-height: 25px; font-size: 12px">&nbsp;&nbsp;&nbsp;共'.$page_count.'页，到第 <input id = "topage" class="form-control" name = "topage" type = "text" style="width:80px; height:30px">&nbsp;页&nbsp;&nbsp;<input type="submit" name="Submit" class="botton" value="确认" style="height:30px;margin-top:5px" onclick="page_search(\''.str_replace('&page=1', '', $Pagination->createUrl('',$page_size)).'\')" /></li>';
            } else {
                $navs .= '<li style="line-height: 38px; font-size: 12px">&nbsp;&nbsp;&nbsp;第<small style="color: red">'.$page.'/'.$page_count.'</small>页，总计<small style="color: red">'.$count.'</small>条数</li>';
            }
            return "$navs";
        }
    }
    public function show_page2 ($count, $page_size)
    {
        $page = max(1, yii::$app->request->get('page'));
        $Pagination = new Pagination();
        // 搜索提交数据的基础url
        $url = $Pagination->createUrl(0, yii::$app->params['pageSize']);
        $page_count = ceil($count / $page_size); // 计算得出总页数

        $init = 1;
        $page_len = 7;
        $max_p = $page_count;
        $pages = $page_count;

        // 判断当前页码
        $page = (empty($page) || $page < 0) ? 1 : $page;
        // 分页功能代码
        $page_len = ($page_len % 2) ? $page_len : $page_len + 1; // 页码个数
        $pageoffset = ($page_len - 1) / 2; // 页码个数左右偏移量

        $navs = '';
        if ($pages != 0) {
            if ($page != 1) {
                // $navs .= "<a href=\"" .
                // $Pagination->createUrl(0,yii::$app->params['pageSize']) .
                // "\">首页</a> "; // 第一页
                $navs .= "<li><a href=\"" .
                    $Pagination->createUrl($page - 2,
                        yii::$app->params['pageSize']) . "\"><<上页</a></li>"; // 上一页
            } else {
                // $navs .= "<span class='disabled'>首页</span>";
                $navs .= "<li class='disabled'><a href='#' aria-label='Previous'><span aria-hidden='true'>&laquo;</span>上页</a></li>";
            }
            if ($pages > $page_len) {
                // 如果当前页小于等于左偏移
                if ($page <= $pageoffset) {
                    $init = 1;
                    $max_p = $page_len;
                } else                 // 如果当前页大于左偏移
                {
                    // 如果当前页码右偏移超出最大分页数
                    if ($page + $pageoffset >= $pages + 1) {
                        $init = $pages - $page_len + 1;
                    } else {
                        // 左右偏移都存在时的计算
                        $init = $page - $pageoffset;
                        $max_p = $page + $pageoffset;
                    }
                }
            }
            for ($i = $init; $i <= $max_p; $i ++) {
                if ($i == $page) {
                    $navs .= "<li class='active'><span class='current'> " . $i . ' </span></li>';
                } else {
                    $navs .= " <li><a href=\"" .
                        $Pagination->createUrl($i - 1,
                            yii::$app->params['pageSize']) . "\">" . $i .
                        "</a></li>";
                }
            }
            if ($page != $pages) {
                $navs .= " <li><a href=\"" .
                    $Pagination->createUrl($page,
                        yii::$app->params['pageSize']) . "\">下页>></a></li> "; // 下一页
                // $navs .= "<a href=\"" .
                // $Pagination->createUrl($page_count-1,yii::$app->params['pageSize'])
                // . "\">末页</a>"; // 最后一页
            } else {
                $navs .= "<li class='disabled'><a href='#' aria-label='Next'>下页<span aria-hidden='true'>&raquo;</span></a></li>";
                // $navs .= "<span class='disabled'>末页</span>";
            }
            $navs .= '<li>&nbsp;&nbsp;&nbsp;共'.$page_count.'页，到第 <input id = "topage" class="form-control" name = "topage" type = "text" style="width:50px; height:30px; display: inline-block;">&nbsp;页&nbsp;&nbsp;<input type="submit" name="Submit" class="botton" value="确认" style="height:30px;" onclick="window.location.href=\''.str_replace('&page=1', '', $Pagination->createUrl('',yii::$app->params['pageSize'])).'&page=\'+document.getElementById(\'topage\').value" /></li>';
            return "$navs";
        }
    }
    /**
     * @name 添加页面数据
     * @param $data 页面配置数据
     */
    public function addPages($data)
    {
        if (empty($data['exhibition_id'])) {
            return ['status'=>0,'msg'=>'展会id不能为空'];
        }
        if (empty($data['page_name'])) {
            return ['status'=>0,'msg'=>'页面名称不能为空'];
        }
        if (empty($data['page_type'])) {
            return ['status'=>0,'msg'=>'页面类型不能为空'];
        }
        $db = yii::$app->db->createCommand();
        $db->insert('zq_pages', $data)->execute();
        return $db->lastInsertID;
    }

    /**
     * @name 查找单页面数据
     * @param $exhibition_id 展会ID
     * @param $page_id 页面ID
     * @param $page_type 页面类型id
     */
    public function getPagesData($exhibition_id,$page_id,$page_type)
    {
        $cache = yii::$app->cache;
        $key = 'pages_data_'.$exhibition_id.'_'.$page_id;
        $data = $cache->get($key);
        if (empty($data)) {
            $data = Pages::find()->where(['id'=>$page_id,'exhibition_id'=>$exhibition_id])->asArray()->one();
            if (!empty($data)) {
                //缓存数据7天
                $cache->set($key, $data, 604800);
            } else {
                $pagenames = [1=>'线上预登记',2=>'线上预购票',3=>'现场购票'];
                if (!empty($pagenames[$page_type])) {
                    $page_name = $pagenames[$page_type];
                } else {
                    return false;
                }
                $id = $this->addPages(['exhibition_id'=>$exhibition_id,'page_name'=>$page_name,'page_type'=>$page_type]);
                if (isset($id['status'])) {
                    return false;
                }
                $data = ['id' => $id,'exhibition_id'=>$exhibition_id,'page_name'=>$page_name,'page_type'=>$page_type];
            }
        }
        return $data;
    }

    /**
     * @name 获取页面列表
     * @param $exhibition_id 展会ID
     */
    public function getPagesList($exhibition_id)
    {
        $data = Pages::find()->where(['exhibition_id'=>$exhibition_id])->asArray()->orderBy('id DESC')->all();
        if (empty($data)) {
            return [];
        }
        return $data;
    }

    /**
     * @name 更新页面配置数据
     * @param  $exhibition_id
     * @param  $page_id
     * @param  $data
     */
    public function updatePagesData($exhibition_id, $page_id, $data)
    {
        if (empty($exhibition_id)) {
            return ['status'=>0,'msg'=>'展会ID不能为空'];
        }
        if (empty($page_id)) {
            return ['status'=>0,'msg'=>'页面id为空'];
        }
        if (empty($data['page_name'])) {
            return ['status'=>0,'msg'=>'页面名称不能为空'];
        }
        if (empty($data['page_type'])) {
            return ['status'=>0,'msg'=>'页面类型不能为空'];
        }
        yii::$app->db->createCommand()->update('zq_pages', $data, 'id = :id AND exhibition_id = :exhibition_id',[':id' => $page_id,':exhibition_id'=>$exhibition_id])->execute();
        return true;
    }


    public function createPage($data){
        if(empty($data['page_name']) || empty($data['page_type']) || empty($data['exhibition_id']))return false;
        $formInfo = json_decode($data["formInfo"],true);
        unset($data['formInfo']);
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $db = yii::$app->db->createCommand();
            $db->insert('zq_pages', $data)->execute();
            $pid = $db->lastInsertID;
            $form = new FormInfoService();
            $form->createForm($pid,$formInfo);
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            return false;
        }
        return $pid;

    }
}