<div class="modal fade" id="sport" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered sport_modal">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body text-center">
                <h2><?php echo direction("SELECT SPORT","إختر الرياضة") ?></h2>
                <div class="extra_scr" data-simplebar>
                    <div class="row" id="sportsData">
					<?php
					if( $sports = selectDB("sports","`hidden` = '0' AND `status` = '0' ORDER BY `order` ASC") ){
						for( $i = 0; $i < sizeof($sports); $i++){
					?>
                        <div class="col-lg-3 col-sm-4 col-4 mt_30">
                            <a href="#" id="<?php echo $sports[$i]["id"] ?>" class="selectSport">
                                <div class="sport_model">
                                    <img src="logos/<?php echo $sports[$i]["imageurl"] ?>" id="sportImage<?php echo $sports[$i]["id"] ?>" alt="<?php echo $sports[$i]["enTitle"] ?>">
                                </div>
                                <h3 id="sportTitle<?php echo $sports[$i]["id"] ?>"><?php echo direction($sports[$i]["enTitle"],$sports[$i]["arTitle"]) ?></h3>
                            </a>
                        </div>
					<?php
						}
					}
					?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>