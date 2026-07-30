<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar" style="background-color: #000d2c !important;">
		<li class="navigation-header">
			<span><?php echo direction("Dashboard","لوحة التحكم")?></span> 
			<i class="zmdi zmdi-more"></i>
		</li>
<?php 
if( $pages = selectDB("pages","`status` = '0' AND `hidden` = '0' AND `section` = '0' ORDER BY `order` ASC") ){
	$listOfAllowedPages = "";
	if( $roles = selectDB("roles","`id` = '{$userType}'") ){
		$list = json_decode($roles[0]["pages"],true);
		for( $i = 0; $i < sizeof($list); $i++ ){
			$listOfAllowedPages .= "'{$list[$i]}'";
			if( isset($list[$i+1]) && !empty($list[$i+1]) ){
				$listOfAllowedPages .= ",";
			}
		}
		if( selectDB("pages","`fileName` LIKE '?v={$_GET["v"]}' AND `id` IN ({$listOfAllowedPages})") ){
		}else{
			header("LOCATION: ?v=Home");die();
		}
	}else{
		$list = array();
	}
	for( $i = 0; $i < sizeof($pages); $i++ ){
		$currentPage = isset($_GET["v"]) ? strtolower(str_replace(array(" ","_"),"",$_GET["v"])) : "";
		$pageTitle = strtolower(str_replace(array(" ","_"),"",$pages[$i]["enTitle"]));
		$active = ( $currentPage && $pageTitle == $currentPage ) ? "activeSidebar" : "";
		if ( $userType == '0' || in_array($pages[$i]["id"],$list) ){
			if( $sections = selectDB("pages","`section` = '{$pages[$i]["id"]}' AND `status` != '1'") ){
				// Check if any subsection is currently active OR if parent itself is active
				$isSubActive = false;
				foreach($sections as $section){
					// Check if fileName matches (e.g., ?v=Tournaments)
					if( isset($_GET["v"]) && $section["fileName"] == "?v={$_GET["v"]}" ){
						$isSubActive = true;
						$active = "activeSidebar";
						break;
					}
				}
				// Also check if the parent page itself is being viewed
				if( $currentPage && $pageTitle == $currentPage ){
					$isSubActive = true;
				}
				$collapseClass = $isSubActive ? "" : "collapsed";
				$ariaExpanded = $isSubActive ? "true" : "false";
				$anchor = "href='javascript:void(0);' data-toggle='collapse' data-target='#".str_replace(" ","_",$pages[$i]["enTitle"])."' class='{$collapseClass} {$active}' aria-expanded='{$ariaExpanded}'";
				$arrowDown = "<i class='zmdi zmdi-caret-down'></i>";
			}else{
				$anchor = "href='{$pages[$i]["fileName"]}' class='{$active}'";
				$arrowDown = '';
			}
			?>
			<li>
				<a <?php echo $anchor ?> >
					<div class="pull-left">
						<i class="<?php echo $pages[$i]["icon"] ?> mr-20"></i>
						<span class="right-nav-text"><?php echo direction($pages[$i]["enTitle"],$pages[$i]["arTitle"]) ?></span>
					</div>
					<div class="pull-right">
						<?php echo $arrowDown ?>
					</div>
					<div class="clearfix"></div>
				</a>
			<?php
			if ( $subSections = selectDB("pages","`section` = '{$pages[$i]["id"]}' AND `status` != '1' ORDER BY `order` ASC") ){
				// Check if any subsection is active to keep parent expanded
				$subActive = false;
				foreach($subSections as $subSection){
					// Check if fileName matches (e.g., ?v=Tournaments)
					if( isset($_GET["v"]) && $subSection["fileName"] == "?v={$_GET["v"]}" ){
						$subActive = true;
						break;
					}
				}
				$expandClass = $subActive ? "in" : "";
				?>
				<ul id="<?php echo str_replace(" ","_",$pages[$i]["enTitle"]) ?>" class="collapse-level-1 collapse <?php echo $expandClass ?>" aria-expanded="<?php echo $subActive ? 'true' : 'false' ?>">
				<?php
				for( $y = 0; $y < sizeof($subSections); $y++ ){
					$active = "";
					// Check if fileName matches current URL
					if( isset($_GET["v"]) && $subSections[$y]["fileName"] == "?v={$_GET["v"]}" ){
						$active = "activeSidebar";
					}
					?>
						<li>
							<a href="<?php echo $subSections[$y]["fileName"] ?>" class="<?php echo $active ?>">
								<div class="pull-left">
									<i class="<?php echo $subSections[$y]["icon"] ?> mr-20"></i>
									<span class="right-nav-text"><?php echo direction($subSections[$y]["enTitle"],$subSections[$y]["arTitle"]) ?></span>
								</div>
								<div class="pull-right"></div>
								<div class="clearfix"></div>
							</a>
						</li>
					<?php
				}
				?>
				</ul>
				<?php
			}
		}
		?>
		</li>
		<?php
	}
}
?>
	</ul>
</div>