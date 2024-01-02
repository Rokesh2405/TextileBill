<?php

class paging {

    var $sql, $records, $pages;
    var $page_no, $total, $limit, $first, $previous, $next, $last, $start, $end;

    function paging($sql, $records = 5, $pages = 4) {
        global $db;
        if ($pages % 2 == 0)
            $pages++;
      
    //    $total = DB_NUM($sql) ;
    $totalfetcg=$db->prepare("SELECT * FROM `item_master` ");
    
    $totalfetcg->execute();
        $total =$totalfetcg->rowCount();
        $page_no = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
        $limit = ($page_no - 1) * $records;
        $sql.=" LIMIT $records OFFSET $limit ";
        $first = 1;
        $previous = $page_no > 1 ? $page_no - 1 : 1;
        $next = $page_no + 1;
        $last = ceil($total / $records);
        if ($next > $last)
            $next = $last;
        $start = $page_no;
        $end = $start + $pages - 1;
        if ($end > $last)
            $end = $last;
        if (($end - $start + 1) < $pages) {
            $start-=$pages - ($end - $start + 1);
            if ($start < 1)
                $start = 1;
        }
        if (($end - $start + 1) == $pages) {
            $start = $page_no - floor($pages / 2);
            $end = $page_no + floor($pages / 2);
            while ($start < $first) {
                $start++;
                $end++;
            }
            while ($end > $last) {
                $start--;
                $end--;
            }
        }
        $this->sql = $sql;
        $this->records = $records;
        $this->pages = $pages;
        $this->page_no = $page_no;
        $this->total = $total;
        $this->limit = $limit;
        $this->first = $first;
        $this->previous = $previous;
        $this->next = $next;
        $this->last = $last;
        $this->start = $start;
        $this->end = $end;
    }

    function show_paging($url) {
        $paging = "";
        if (isset($_REQUEST['pid'])) {
            $params = 'pid=' . $_REQUEST['pid'];
        }
        if (isset($_REQUEST['s'])) {
            $params = 's=' . $_REQUEST['s'];
        } elseif (isset($_REQUEST['rid'])) {
            $params = 'rid=' . $_REQUEST['rid'];
        } elseif (isset($_REQUEST['cid'])) {
            $params = 'cid=' . $_REQUEST['cid'];
        } elseif (isset($_REQUEST['sid'])) {
            $params = 'sid=' . $_REQUEST['sid'];
        } elseif (isset($_REQUEST['qid'])) {
            $params = 'qid=' . $_REQUEST['qid'];
        } elseif (isset($_REQUEST['ssid'])) {
            $params = 'ssid=' . $_REQUEST['ssid'];
        }elseif (isset($_REQUEST['cusid'])) {
            $params = 'cusid=' . $_REQUEST['cusid'];
        } elseif ((isset($_REQUEST['search'])) || (isset($_REQUEST['search_x']))) {
            $params = 'search=' . $_REQUEST['search'] . '&srch=' . $_REQUEST['srch'] . '&brand=' . $_REQUEST['brand'] . '&price=' . $_REQUEST['price'] . '&age=' . $_REQUEST['age'];
        } else {
            $params = '';
        }
        if ($this->total > $this->records) {
            $page_no = $this->page_no;
            $first = $this->first;
            $previous = $this->previous;
            $next = $this->next;
            $last = $this->last;
            $start = $this->start;
            $end = $this->end;
            if ($params == "")
                $params = "?p=";
            else
                $params = "?$params&p=";
            $paging.="<ul class='pagination'>";
            if ($page_no == $first)
                $paging.="<!--<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;<<&nbsp;</a></li>-->";
            else
                $paging.="<li><a href='$url$params$first'>&nbsp;<<&nbsp;</a></li>";
            if ($page_no == $previous)
                $paging.="<!--<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;<&nbsp;</a></li>-->";
            else
                $paging.="<li><a href='$url$params$previous'>&nbsp;<&nbsp;</a></li>";
            for ($p = $start; $p <= $end; $p++) {
                $paging.="<li class='page-numbers ";
                if ($page_no == $p)
                    $paging.=" active'";
                else
                    $paging.="'";
                $paging.="><a href='$url$params$p'>$p</a></span></li>";
            }
            if ($page_no == $next)
                $paging.="<!--<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;Next&nbsp;</a></li>-->";
            else
                $paging.="<li><a href='$url$params$next'>&nbsp;>&nbsp;</a></li>";
            if ($page_no == $last)
                $paging.="<!--<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;Last&nbsp;</a></li>-->";
            else
                $paging.="<li><a href='$url$params$last'>&nbsp;>>&nbsp;</a></li>";
            $paging.="</ul>";
        }
        return $paging;
    }
    
    function show_paging_ajax($url,$tab,$type) {
        $paging = "";
        if (isset($_REQUEST['pid'])) {
            $params = 'pid=' . $_REQUEST['pid'];
        }
        if (isset($_REQUEST['s'])) {
            $params = 's=' . $_REQUEST['s'];
        } elseif (isset($_REQUEST['rid'])) {
            $params = 'rid=' . $_REQUEST['rid'];
        } elseif (isset($_REQUEST['cid'])) {
            $params = 'cid=' . $_REQUEST['cid'];
        } elseif (isset($_REQUEST['sid'])) {
            $params = 'sid=' . $_REQUEST['sid'];
        } elseif (isset($_REQUEST['qid'])) {
            $params = 'qid=' . $_REQUEST['qid'];
        } elseif (isset($_REQUEST['ssid'])) {
            $params = 'ssid=' . $_REQUEST['ssid'];
        }elseif (isset($_REQUEST['cusid'])) {
            $params = 'cusid=' . $_REQUEST['cusid'];
        } elseif ((isset($_REQUEST['search'])) || (isset($_REQUEST['search_x']))) {
            $params = 'search=' . $_REQUEST['search'] . '&srch=' . $_REQUEST['srch'] . '&brand=' . $_REQUEST['brand'] . '&price=' . $_REQUEST['price'] . '&age=' . $_REQUEST['age'];
        } else {
            $params = '';
        }
        if ($this->total > $this->records) {
            $page_no = $this->page_no;
            $first = $this->first;
            $previous = $this->previous;
            $next = $this->next;
            $last = $this->last;
            $start = $this->start;
            $end = $this->end;
            if ($params == "")
                $params = "p=";
            else
                $params = "$params&p=";
                
                                                              
                                                           
                                                            
                                                            
                                                            
                                                            
            $paging.="<ul class='pagination' style='bottom:-11px;'>";
            
            if ($page_no == $first)
                $paging.="<!--<li class='paging-disabled'><a  href='javascript:void(0)'>&nbsp;<<&nbsp;</a></li>-->";
            else
             //   $paging.="<li data-href='$url$params$first' nn='1' onclick='sendpage($(this).attr(\"data-href\"),\"".$tab."\",\"".$type."\")'></li>";
                
            if ($page_no == $previous)
                $paging.="<!--<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;<&nbsp;</a></li>-->";
            else
                $paging.="<li data-href='$url$params$previous'  title='previous'  data-hh='$previous' nn='2' onclick='sendpage($(this).attr(\"data-hh\"),\"".$tab."\",\"".$type."\")'></li>";
                
            for ($p = $start; $p <= $end; $p++) {
                $paging.="<li  style='padding:3px;' class='page-numbers ";
                if ($page_no == $p)
                {
					$paging.=" active'";
					$actt='';
				}
                    
                else
                { $paging.="'";
					$actt='-o';
				}
                   
                $paging.="  data-href='$url$params$p' data-hh='$p' title='$p' onclick='sendpage($(this).attr(\"data-hh\"),\"".$tab."\",\"".$type."\")' ><i class='fa fa-circle$actt'  ></i></li>";
            }
            
            if ($page_no == $next)
                $paging.="<!--<li class='paging-disabled'></li>-->";
            else
                $paging.="<li data-href='$url$params$next'   title='next'  nn='3' onclick='sendpage($(this).attr(\"data-href\"),\"".$tab."\",\"".$type."\")' > </li>";
                
            if ($page_no == $last)
                $paging.="<!--<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;Last&nbsp;</a></li>-->";
            else
             //   $paging.="<li data-href='$url$params$last' nn='4' onclick='sendpage($(this).attr(\"data-href\"),\"".$tab."\",\"".$type."\")'></li>";
            $paging.="</ul>";
        }
        return $paging;
    }

    function show_paging_url($url, $page, $sitename) {
        $paging = "";

        if ($this->total > $this->records) {
            $page_no = $this->page_no;
            $first = $this->first;
            $previous = $this->previous;
            $next = $this->next;
            $last = $this->last;
            $start = $this->start;
            $end = $this->end;
            if ($params == "")
                $params = "?p=";
            else
                $params = "?$params&p=";
            $paging.="<ul class='paging'>";
            if ($page_no == $first)
                $paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;First&nbsp;</a></li>";
            else
                $paging.="<li><a href='$sitename$first/$url.htm'>&nbsp;First&nbsp;</a></li>";
            if ($page_no == $previous)
                $paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;Previous&nbsp;</a></li>";
            else
                $paging.="<li><a href='$sitename$previous/$url.htm'>&nbsp;Previous&nbsp;</a></li>";
            for ($p = $start; $p <= $end; $p++) {
                $paging.="<li";
                if ($page_no == $p)
                    $paging.=" class='paging-active'";
                $paging.="><a href='$sitename$p/$url.htm'>$p</a></li>";
            }
            if ($page_no == $next)
                $paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;Next&nbsp;</a></li>";
            else
                $paging.="<li><a href='$sitename$next/$url.htm'>&nbsp;Next&nbsp;</a></li>";
            if ($page_no == $last)
                $paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&nbsp;Last&nbsp;</a></li>";
            else
                $paging.="<li><a href='$sitename$last/$url.htm'>&nbsp;Last&nbsp;</a></li>";
            $paging.="</ul>";
        }
        return $paging;
    }

}
