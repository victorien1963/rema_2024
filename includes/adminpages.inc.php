<?php
class pages
{

				var $output;
				var $file;
				var $pvar = "page";
				var $psize;
				var $curr;
				var $varstr;
				var $tpage;

				function set( $pagesize = 20, $total, $current = false )
				{
								global $strPagesUp;
								global $strPagesDown;
								global $strPagesStart;
								global $strPagesEnd;
								global $strPagesDi;
								global $strPagesYe;
								$this->total = $total;
								$this->tpage = ceil( $total / $pagesize );
								if ( !$current )
								{
												$current = $_REQUEST[$this->pvar];
								}
								if ( $this->tpage < $current )
								{
												$current = $this->tpage;
								}
								if ( $current < 1 )
								{
												$current = 1;
								}
								$this->curr = $current;
								$this->psize = $pagesize;
								if ( !$this->file )
								{
												$this->file = $_SERVER['PHP_SELF'];
								}
								
								for ( $n = 1;	$n <= $this->tpage;	$n++	)
								{
												if ( $current == $n )
												{
																$optstr .= "<option value=\"".$this->file."?".$this->pvar."=".$n.$this->varstr."\" selected>".$strPagesDi.$n.$strPagesYe."</option>";
												}
												else
												{
																$optstr .= "<option value=\"".$this->file."?".$this->pvar."=".$n.$this->varstr."\">".$strPagesDi.$n.$strPagesYe."</option>";
												}
								}
								if ( $this->tpage == 0 )
								{
												$this->tpage = 1;
								}
								if ( 0 < $this->tpage )
								{
												$this->output .= "<ul class=\"pagination\"><li class=\"prev\"><a href=".$this->file."?".$this->pvar."=1".$this->varstr." title=\"".$strPagesStart."\"><i class=\"fa fa-angle-double-left icon-only\"></i></a></li>";
												if ( 1 < $current )
												{
																$this->output .= ( "<li><a href=".$this->file."?".$this->pvar."=".( $current - 1 ) ).$this->varstr." >".$strPagesUp."</a></li>";
												}
												else
												{
																$this->output .= "<li class=\"disabled\"><a>".$strPagesUp."</a></li>";
												}
												if ( 10 < $this->tpage && 6 < $current )
												{
																if ( $this->tpage < $current + 4 )
																{
																				$start = $this->tpage - 9;
																}
																else
																{
																				$start = $current - 5;
																}
												}
												else
												{
																$start = 1;
												}
												if ( $start < 1 )
												{
																$start = 1;
												}
												$end = $start + 9;
												if ( $this->tpage < $end )
												{
																$end = $this->tpage;
												}
												
												for ( $i = $start;	$i <= $end;	$i++	)
												{
																if ( $current == $i )
																{
																				$this->output .= "<li class=\"active\"><a>".$i."</a></li>";
																}
																else
																{
																				$this->output .= "<li><a href=".$this->file."?".$this->pvar."=".$i.$this->varstr.">".$i."</a></li>";
																}
												}
												if ( $current < $this->tpage )
												{
																$this->output .= ( "<li><a href=".$this->file."?".$this->pvar."=".( $current + 1 ) ).$this->varstr." >".$strPagesDown."</a></li>";
												}
												else
												{
																$this->output .= "<li class=\"disabled\"><a>".$strPagesDown."</a></li>";
												}
												$this->output .= "<li><span style=\"padding:0;\"><select onChange=\"window.location=this.options[this.selectedIndex].value\" class=\"form-control\" style=\"border:0;height:32px;\">".$optstr."</select></span></li>";
												$this->output .= "<li class=\"next\"><a href=".$this->file."?".$this->pvar."=".$this->tpage.$this->varstr." title=\"".$strPagesEnd."\"><i class=\"fa fa-angle-double-right icon-only\"></i></a></li>";
												$this->output .= "</ul>";
								}
				}

				function setvar( $data )
				{
								foreach ( $data as $k => $v )
								{
												$this->varstr .= "&amp;".$k."=".urlencode( $v );
								}
				}

				function output( $return = false )
				{
								if ( $return )
								{
												return $this->output;
								}
								else
								{
												echo $this->output;
								}
				}

				function limit( )
				{
								return ( $this->curr - 1 ) * $this->psize.",".$this->psize;
				}

				function shownow( )
				{
								$pagesinfo['total'] = $this->tpage;
								$pagesinfo['now'] = $this->curr;
								$pagesinfo['shownum'] = $this->psize;
								if ( 0 < $this->total )
								{
												if ( $this->total <= ( $this->curr - 1 ) * $this->psize + $this->psize )
												{
																$pagesinfo['from'] = ( $this->curr - 1 ) * $this->psize + 1;
																$pagesinfo['to'] = $this->total;
												}
												else
												{
																$pagesinfo['from'] = ( $this->curr - 1 ) * $this->psize + 1;
																$pagesinfo['to'] = ( $this->curr - 1 ) * $this->psize + $this->psize;
												}
								}
								else
								{
												$pagesinfo['from'] = 1;
												$pagesinfo['to'] = 1;
								}
								return $pagesinfo;
				}

}

?>