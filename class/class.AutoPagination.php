<?php
/**
 * Class for generating the pagination
 *
 * @package Auto Pagination
 * @author Nitesh Apte
 * @copyright 2011
 * @version 1.0
 * @access final
 * @License GPL
 */

echo '
	<style type="text/css">
	
	.pagelinks {
		display: flex;
		justify-content: center;
	}

	/*----*/
	
	.pagenumlink {
		margin: 0px 5px 0px 5px;
		color: #2196F3;
	}

	.pagenumlink:hover {
		margin: 0px 5px 0px 5px;
		color: #2196F3;
	}

	.pagenumdead {
		color: #000;
	}

	/*----*/
	
	.pagenextlink {
		color: #2196F3;
	}

	.pagenextlink:hover {
		color: #2196F3;
	}

	.pagenextdead {
		color: #000;
	}

	/*----*/

	.pageprevlink {
		color: #2196F3;
	}

	.pageprevlink:hover {
		color: #2196F3;
	}

	.pageprevdead {
		color: #000;
	}

	</style>

	 ';

define('PAGE_LIMIT', 20);
define('PAGE_RANGE', 10);

final class AutoPagination
{
	/**
	 * @var $_totalRecords Total number of records
	 */
	private $_totalRecords;
	
	/**
	 * @var $_totalPages Total number of pages
	 */
	private $_totalPages;
	
	/**
	 * @var $_pageNo Current page number
	 */
	private $_pageNo;
	
	/**
	 * @var $_currPage Current page
	 */
	private $_currPage;
	
	/**
	 * @var $_pageLinks Current page links
	 */
	private $_pageLinks;
	
	/**
	 * @var $_prevPage Previous page link
	 */
	private $_prevPage;
	
	/**
	 * @var $_nextPage Next page link
	 */
	private $_nextPage;
	
	
	/**
	 * Method to initialize total records and current page number
	 * 
	 * @param Int $_totalCount Total records
	 * @param Int $_pageNo [optional] Current page number
	 * @return none
	 */
	public function __construct($_totalCount, $_pageNo = 0)
	{		
		$this->_pageNo = $_pageNo;
		$this->_totalRecords = $_totalCount;		
	}
	
	/**
	 * Method to create page links
	 * 
	 * @param none
	 * @return none
	 */
	public function _paginateDetails()
	{
		$this->_pageLinks = "<div class=\"pagelinks\">";
		if($this->_totalRecords > PAGE_LIMIT)
		{
			if(isset($this->_pageNo))
			{
				
			}
			else
			{
				$this->_pageNo = 1;
			}
		
			$this->_currentPage();
			if($this->_pageNo == 1)
			{			
				$this->_pageLinks .= "<span class=\"pageprevdead\">‹ Anterior</span>";
			}
			else
			{
				$this->_prevPage = $this->_pageNo - 1;
				$this->_pageLinks .= "<a class=\"pageprevlink\" href=\"" . $this->_currPage ."&page=" . $this->_prevPage . "#paginacion" . "\">‹ Anterior</a>";
			}
			$this->_totalPages = ceil($this->_totalRecords/PAGE_LIMIT);
			$this->_range = PAGE_RANGE;
			if($this->_range == 0 || $this->_range == "")
			{
				$this->_range = 7;
			}
			$this->_leftRange = max(1, $this->_pageNo - (($this->_range - 1)/2));
			$this->_rightRange = min($this->_totalPages, $this->_pageNo + (($this->_range - 1)/2));
			if(($this->_rightRange - $this->_leftRange) < ($this->_range - 1))
			{
				if($this->_leftRange == 1)
				{
					$this->_rightRange = min($this->_leftRange + ($this->_rightRange - 1), $this->_totalPages);
				}
				else
				{
					$this->_leftRange = max($this->_rightRange - ($this->_range - 1), 0);
				}
			}
			if($this->_leftRange > 1)
			{
				$this->_pageLinks .= "&nbsp;...&nbsp;"; 
			}
			else
			{
				$this->_pageLinks .= "&nbsp;&nbsp;";
			}
			
			for($i=1;$i<=$this->_totalPages;$i++)
			{
				if($i == $this->_pageNo)
				{
					$this->_pageLinks .= "<span class=\"pagenumdead\">$i</span>"; 
				}
				else
				{
					if($this->_leftRange<=$i && $i<=$this->_rightRange)
					{
						$this->_pageLinks .= "<a class=\"pagenumlink\" " . "href=\"" . $this->_currPage . "&page=" . $i . "#paginacion" . "\">" . $i . "</a>";
					}
				}
			}
		
			if($this->_rightRange < $this->_totalPages)
			{
				$this->_pageLinks .= "&nbsp;...&nbsp;";
			}
			else
			{
				$this->_pageLinks .= "&nbsp;&nbsp;";
			}
		
			if(($this->_totalRecords - (PAGE_LIMIT * $this->_pageNo)) > 0)
			{
				$this->_nextPage = $this->_pageNo + 1;
				$this->_pageLinks .= "<a class=\"pagenextlink\" href=\"" . $this->_currPage . "&page=" . $this->_nextPage . "#paginacion" . "\">Siguiente ›</a>";
			}
			else
			{
				$this->_pageLinks .=  "<span class=\"pagenextdead\">Siguiente ›</span>";
			}
		}
		else
		{
			$this->_pageLinks .= "<span class=\"pageprevdead\">‹ " . "Anterior</span>&nbsp;&nbsp;";
			$this->_pageLinks .= "<span class=\"pagenextdead\"> " . "Siguiente ›</span>&nbsp;&nbsp;";
		}
		$this->_pageLinks .= "</div>";
		return $this->_pageLinks;
	}
	
	/**
	 * Method to create current page
	 * 
	 * @param none
	 * @return String $this->_currPage Current page
	 */
	public function _currentPage()
	{
		$this->_currPage = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
		return $this->_currPage = str_replace("&page=".$this->_pageNo,"",$this->_currPage);		
	}
}
?>