<?php  include_once('include/header.php'); ?>
    
    <br/>
    <br/>
    <!-- detail page start -->
    <div class="container marketing product-detail pagebg" ng-controller="ProductCTRL" 
         ng-init="item_id='<?php echo $productDetail['item_id']; ?>'"> 
        <?php
        if ($this->session->userdata('user_id') && $this->session->userdata('user_id') != $productDetail['user_id']) {
            ?>
        <span ng-init="AddToWatchList('<?php echo ITEM_WATCHING; ?>');"></span>
        <?php
        }
        ?>

        <?php 
            // print_r($productDetail);
        ?>

        <div class="row">
            <div class="col-md-8 product-summary-box">
                <div class="product-summary info-box">
                    <div class="row">
                        <div class="col-md-5 summary-box-image">
                            <div class="img-detail-featured"><a href="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'.$productDetail['cover_image'];?>" data-lightbox="product-gallery-<?php echo $productDetail['item_id']; ?>"><img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'.$productDetail['cover_image'];?>" 
                                     err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" style="width: 100%;height: 100%;"></a></div>
                        </div>

                        <div class="col-md-7 summary-box-text">
                            <div class="text-box">
                                <div class="upper-box">
                                    <a href="#" class="mark " title="Bookmark">Bookmark</a>
                                    <h1 itemprop="name"><?php echo $productDetail['title']; ?></h1>
                                    <p itemprop="description">
                                        <?php echo $productDetail['description']; ?>
                                    </p>
                                    
                                </div>

                                <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                    <div itemprop="availableAtOrFrom" itemscope="" itemtype="http://schema.org/Place">
                                        <span itemprop="address" class="location-text">
                                            Location: <span><?php echo $productDetail['location']; ?></span>
                                            &nbsp;· Category: <?php echo $productDetail['category_name']; ?> 
                                        </span>
                                        
                                    </div>
                                    <span class="price">
                                        Price:&nbsp;&nbsp;<strong><span><?php echo $productDetail['currency'].' '.$productDetail['price']; ?></span></strong>                         
                                    </span>
                                </div>

                                <div class="links">
                                    <div class="wrap">
                                        <a href="#make-offer" class="make ">Private offer</a>
                                        <a href="#ask-question" class="ask ">Ask a question</a>
                                    </div>

                                    <!-- <p class="item-date">
                                        <a href="#report-item" class="report">Report</a>
                                        <span class="item-listed-on">Item updated on <?php //echo $productDetail['last_update']; ?>.</span>
                                    </p>

                                    <div class="report-wrapper" style="display: block;">
                                        <form action="#" class="report-form" style="display: block;">
                                            <fieldset>
                                                <input type="submit" value="Item violates the Terms and conditions" data-category="product_violates_guidelines">
                                                <input type="submit" value="Price is misleading" data-category="product_price_not_realistic">
                                                <input type="submit" value="Item is no longer available" data-category="seller_not_responding">
                                                <input type="submit" value="Item is listed multiple times" data-category="duplicate_product">
                                            </fieldset>
                                        </form>
                                        <div class="clearall"></div>
                                        <div class="inner">
                                            <div class="success" style="display: none;">
                                                Thank you for your report. We will take care of it as soon as possible.
                                            </div>
                                            <div class="error" style="display: block;">You already flagged that item before.</div>
                                        </div>
                                        <div class="clearall"></div>
                                    </div> -->

                                </div>
                            </div>
                       </div>

                       <!-- map and gallery section -->
                        <div class="col-md-12 second-row-top">
                            <div class="second_row">
                                <div class="pagination col-md-6" id="sly-frame" style="overflow: hidden;">
                                    <ul class="item-gallery" style="transform: translateZ(0px);">
                                        <?php
                                        if(!empty($productImages)){
                                            //print_r($productImages);
                                            foreach($productImages as $pImage){
                                                ?>
                                                <li>
                                                    <a href="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'.$pImage['media_name'];?>" class="item-gallery-item" data-lightbox="product-gallery-<?php echo $pImage['entity_id']; ?>">
                                                        <img src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'.$pImage['media_name'];?>" width="64" height="64" alt="Liquids verschiedene Sorten 3mg">
                                                    </a>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>

                                <div class="map-box col-md-6">
                                    <div class="location-map-wrapper">
                                        <div id="location_map">
<!--                                            <img src="https://en.shpock.com/style/images/en/map_noborder.png" id="location_map_placeholder">-->
                                            <iframe src="https://www.google.com/maps?q=<?php echo $productDetail['location'];?>&daddr=<?php echo '';?>&output=embed&zoom=20" id="location_map_placeholder"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <!-- end map and gallery section -->

                       <!-- offer and comment section -->
                            <div class="columns-box product-columns">
                                <div class="col-md-6">
                                    <div class="column">
                                        <h2>Offers</h2>
                                        <div class="no-offers-yet">
                                            <p><a href="javascript:void('0');" class="make">Be the first one to make an offer and get this item!</a></p>
                                        </div>

                                        <!-- After Login  -->

                                            <div class="no-offers-yet no-offers-yet-login">
                                                <p><a href="javascript:void('0');" class="make">Be the first one to make an offer and get this item!</a></p>
                                            </div>

                                            <div class="product_offer">
                                                <ul class="actions-list">
                                                    <li class="top-level new-ag active">
                                                        <img class="activity-user-img" src="https://media.shpock.com/1.0/589da7bc75a74db5102d29ae/?aspect_width=32&amp;aspect_height=32" width="32px" height="32px">
                                                        <a href="#" class="opener">
                                                            <div class="latest-wrapper">
                                                                You offered 10
                                                            </div>
                                                        </a>

                                                        <div class="slide">
                                                            <ul class="dialog-wrapper">
                                                                <a href="#">
                                                                    <li class="activity-detail-li">
                                                                        <img class="item" src="https://media.shpock.com/1.0/56953f1668450b3470c30c29/?aspect_width=30&amp;aspect_height=30" width="30" heigth="30">
                                                                        <div class="activity">
                                                                            <p>Lena K. is selling "Perser Teppich" for € 1.900,00.</p>
                                                                            <em>29.01. · 16:23</em>
                                                                        </div>
                                                                    </li>
                                                                </a>

                                                                <a href="#" class="no-action">
                                                                    <li class="activity-detail-info">
                                                                        <div class="item info"></div>
                                                                        <div class="activity">
                                                                            <p>Offers are not binding. A legally binding agreement is entered when both sides agree. One accepts &amp; the other confirms.</p>
                                                                        </div>
                                                                    </li>
                                                                </a>

                                                                <a href="#">
                                                                    <li class="activity-detail-li">
                                                                        <img class="item" src="http://dev.crytonixsoftware.com/mobile/uploads/user/thumb/1488301672_294.png" width="30" heigth="30">
                                                                        <div class="activity">
                                                                            <p>You Offered 10.</p>
                                                                            <em>29.01. · 16:23</em>
                                                                        </div>
                                                                    </li>
                                                                </a>

                                                                <li class="buttons comment-form-wrapper">
                                                                    <form action="#" class="comment-form visible">
                                                                        <fieldset>
                                                                            <input type="text" name="offer" placeholder="0,00" maxlength="20">
                                                                            <input type="text" maxlength="500" name="message" placeholder="Comment" class="comment">
                                                                            <input type="submit" value="Offer">
                                                                        </fieldset>
                                                                    </form>
                                                                </li>

                                                                <li class="waiting-for-response">
                                                                    <span>€ 9.000,00</span> 
                                                                    was last offered by Vivek S..
                                                                </li>

                                                                <li class="buttons comment-form-wrapper accept-counter">
                                                                    <a href="#" class="accept">Accept</a>
                                                                    <a href="#" class="counteroffer">Counter offer:</a>
                                                                </li>
                                                            
                                                            </ul>


                                                            <!-- confirm and reject offer -->
                                                                <div class="dc-panel confirm-reject-box">
                    
                                                                    <div class="top-panel">
                                                                        <div class="outer-yn accepted">
                                                                            <span>Vivek S.</span>
                                                                        </div>
                                                                        <div class="inner">&nbsp;</div>
                                                                        <div class="outer-yn ">
                                                                            <span>You</span>
                                                                        </div>
                                                                        <div class="clearall"></div>
                                                                    </div>

                                                                    <div class="center-panel">
                                                                        <div class="outer-yn">
                                                                            <div class="circle-wrapper">
                                                                                <img src="https://m1.secondhandapp.com/1.0/58c7d9a470bb13d5799ee369/?aspect_width=64&amp;aspect_height=64" width="64" height="64">
                                                                            </div>
                                                                            <div class="corner-icon corner-icon-left"></div>
                                                                        </div>
                                                                        <div class="inner">
                                                                            <div class="border-wrapper"></div>
                                                                            <div class="price-wrapper">
                                                                                <span class="price-bubble">€ 9.500,00</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="outer-yn">
                                                                            <div class="circle-wrapper gray-out">
                                                                                <img src="https://m1.secondhandapp.com/1.0/589da7bc75a74db5102d29ae/?aspect_width=64&amp;aspect_height=64" width="64" height="64">
                                                                            </div>
                                                                            <div class="corner-icon corner-icon-right gray-out"></div>
                                                                        </div>
                                                                        <div class="clearall"></div>
                                                                    </div>


                                                                    <div class="bottom-panel">
                                                                        <div class="outer-yn accepted">
                                                                            <span>has accepted</span>
                                                                        </div>
                                                                        <div class="inner">&nbsp;</div>
                                                                        <div class="outer-yn ">
                                                                            <span>still has to confirm</span>
                                                                        </div>
                                                                        <div class="clearall"></div>
                                                                    </div>


                                                                    <div class="button-panel">
                                                                        <div class="outer-yn">
                                                                            <a href="javascript:void('0');" class="abort cancel">Cancel deal</a>
                                                                        </div>
                                                                        <div class="inner">&nbsp;</div>
                                                                        <div class="outer-yn">
                                                                            <a href="javascript:void('0');" class="confirm">Confirm</a>
                                                                        </div>
                                                                        <div class="clearall"></div>
                                                                    </div>

                                                                    <div class="confirm-selection-panel cancel-dc cencel-step-1">
                                                                        <div class="cancel-dc-select cencel-step-2">
                                                                            <p>Are you sure you want to cancel the deal?</p>
                                                                                <a href="javascript:void('0');" class="choice yes with-reason">Yes, with a message</a>
                                                                                <a href="javascript:void('0');" class="choice no">No, do not cancel</a>
                                                                                <a href="javascript:void('0');" class="choice yes wo-reason">Yes, without a message</a>
                                                                                <div class="clearall"></div>
                                                                        </div>

                                                                        <div class="cancel-dc-options cencel-step-3">
                                                                            <a href="javascript:void('0');" class="close-panel">Close</a>
                                                                            <form class="cancel-dc-form">
                                                                                <fieldset>
                                                                                    <p class="add-space">Choose a predefined option or write a personal message to&nbsp;Vivek S.</p>
                                                                                    <p>
                                                                                        <input type="radio" name="rb-cancel-dc" value="sse">
                                                                                        <span class="lbl">Sorry, sold to someone else</span>
                                                                                    </p>
                                                                                    <p>
                                                                                        <input type="radio" name="rb-cancel-dc" value="naa">
                                                                                        <span class="lbl">Sorry, not available anymore</span>
                                                                                    </p>
                                                                                    <p class="add-space">
                                                                                        <input checked="checked" type="radio" name="rb-cancel-dc" value="ot">
                                                                                        <span class="lbl">Other (optional personal message)</span>
                                                                                    </p>
                                                                                    <textarea maxlength="500"></textarea>
                                                                                    <input type="submit" value="Send">
                                                                                </fieldset>
                                                                            </form>
                                                                        </div>
                                                                    </div>


                                                                    <div class="confirm-selection-panel confirm-dc confirm-step-1">
                                                                        <p><strong>Confirm deal</strong></p>
                                                                        <p>Are you sure you want to sell "product 1" for € 9.500,00? (legally binding agreement)</p>
                                                                        <br>
                                                                        <a href="javascript:void('0');" class="choice no">No</a>
                                                                        <a href="javascript:void('0');" class="choice yes">Yes</a>
                                                                        <div class="clearall"></div>
                                                                    </div>

                                                                    <!-- <div class="confirm-selection-panel poke-wrapper">
                                                                        <p>Are you sure you want to remind your partner?</p>
                                                                        <a href="#poke-user-yes" class="choice yes">Yes</a> 
                                                                        <a href="#poke-user-no" class="choice no">No</a>
                                                                        <div class="clearall"></div>
                                                                    </div> -->
                                                                    
                                                                </div>
                                                            <!-- end confirm and reject offer -->


                                                            <!-- after confirm -->
                                                                <div class="after-confirm-box">
                                                                    <div class="sold-box-v2">
                                                                        <p class="congrat-top">Congrats!</p>
                                                                        <p class="congrat-bottom">Your sale was successful!</p>
                                                                        <p class="do-sth">Chat here to organise the time and place of delivery:</p>
                                                                        <p class="so-sth-sub">For tips on how to pay and deliver safely, visit our Help area.</p>
                                                                    </div>
                                                                
                                                                    <div class="chat-box">
                                                                        <ul class="chat-box-border"></ul>
                                                                        <div class="chat-box-border">
                                                                            <form action="#" class="chat-form">
                                                                                <fieldset>
                                                                                    <input type="text" maxlength="500" name="message" placeholder="Your message">
                                                                                    <input type="submit" value="Send">
                                                                                </fieldset>
                                                                            </form>
                                                                        </div>
                                                                    </div>

                                                                    <div class="dialog-ratings-box dialog-ratings-box--soon">
                                                                        <p>You will be able to review Vivek S. shortly.</p>
                                                                    </div>
                                                                </div>
                                                            <!-- end after confirm -->




                                                        </div>
                                                    </li>
                                                </ul>
                                            </div> 


                                            


                                        <!-- end after login -->


                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="column">
                                        <h2>Questions</h2>
                                        <?php
                                        if (!$this->session->userdata('user_id')) {
                                            ?>

                                            <div class="no-questions-yet">
                                                <p>
                                                    <a href="<?php echo base_url('login')?>" class="ask">Do you still have questions? Log in now and ask!</a>
                                                </p>
                                            </div> 
                                            <?php } else {
                                            ?>
                                            <!-- after login -->
                                            <div class="profile-comment" ng-init="getProductQuestion()">
                                                <div class="qanda-wrapper-v2" data-id="WI4I15BrNE4gi0XR">
                                                    <ul class="questions-list">
                                                        <li class="elem" ng-if="QuestionList.length>0" ng-repeat="Question in QuestionList"
                                                            data-id="question-{{Question.message_id}}">
                                                            
                                                            <img class="activity-user-img" 
                                                                ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/';?>{{Question.from_user_image}}?aspect_width=32&amp;aspect_height=32" 
                                                                err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=32&amp;aspect_height=32">
                                                            <div class="q-corner-icon"></div>
                                                            <div class="box">
                                                                <div class="holder">
                                                                    <div class="object"><a ng-href="<?php echo base_url('userprofile/'); ?>{{Question.from_user_guid}}" ng-bind="Question.from_user_fname+':'"></a> <span ng-bind="Question.message"></span></div>
                                                                </div>
                                                            </div>
                                                        </li>

                                                        <div class="clearing"></div>

<!--                                                        <li class="elem" data-id="1485725573_33bf571487cfc858b5c8dcb031d3bd4f">
                                                            <img class="activity-user-img" src="https://media.shpock.com/1.0/58924f64d46d0d1621979ec2/?aspect_width=32&amp;aspect_height=32" onerror="this.onerror=null;__shpock_header.handleImage404(this, true);">
                                                            <div class="q-corner-icon"></div>
                                                            <div class="box">
                                                                <div class="holder">
                                                                    <div class="object"><a href="#">Aric H.</a>: hello</div>
                                                                </div>
                                                            </div>
                                                        </li>-->

                                                        <div class="clearing"></div>

                                                    </ul>
                                                    
                                                    <div class="ask-form-wrapper">
                                                        <img class="activity-user-img" 
                                                            ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/'.$this->session->userdata('user_image');?>?aspect_width=32&amp;aspect_height=32" 
                                                            err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=32&amp;aspect_height=32">
                                                        <form class="ask-form" ng-submit="AskQuestion()">
                                                            <fieldset>
                                                                <input type="text" maxlength="500" name="message" ng-model="question_text" placeholder="Ask question">
                                                                <input type="submit" value="send">
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end after login -->

                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                       <!-- end offer and comment section -->


                    </div>    
                </div>    
            </div>
            <div class="col-md-4" style="margin-bottom:85px;">
                <div class="sidebar">
                    
                    <div class="sidebar-sec" ng-controller="SettingCTRL">
                        <div class="widget-title"></div>
                        <div class="widget-sec">
                            <div class="profile-box">
                                <div class="image-box">
                                    <a href="javascript:void(0);">
                                        <!--<img  src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=64&amp;aspect_height=64" width="64" height="64" alt="Florian K.">-->
                                        <img ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/'.$productDetail['owner_image'];?>?aspect_width=64&amp;aspect_height=64" 
                                                err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=64&amp;aspect_height=64" style="width: 100%;height: 100%;" width="64" height="64">
                                    </a>
                                </div>
                                <div class="text-box">
                                    <a href="<?php echo base_url('userprofile/'.$productDetail['user_guid']); ?>">
                                        <h3><?php echo $productDetail['owner_fname'].' '.$productDetail['owner_lname'];?></h3>
                                    </a>
                                    <span class="text"><?php echo $productDetail['sell_count']; ?> Sales · <?php echo $productDetail['buy_count']; ?> Purchases</span>
                                </div>
                            </div> 
                            <div class="registration-box" ng-init="is_follow = '<?php echo $productDetail['is_follow']; ?>'">
<!--                                <a href="#" class="follow  ">Follow</a>-->
                                <?php
                                if($this->session->userdata('user_id')){
                                    if($this->session->userdata('user_id') != $productDetail['user_id']){
                                        ?>
                                <a href="javascript:void(0);" ng-click="setFollowStatus('<?php echo $productDetail['user_id']; ?>')" class="follow btn-loadable">
                                    <span ng-if="is_follow == 1">Unfollow</span>
                                    <span ng-if="is_follow == 0">Follow</span>
                                    <span class="loader"></span>
                                </a>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <a href="<?php echo base_url('login'); ?>" class="follow">Follow </a>
                                <?php
                                }
                                ?>
                                <div class="registration-info">
                                    <span>Since <?php echo $productDetail['owner_register_date'];?></span>
                                </div>
                            </div>          
                        </div>
                    </div>                    

                    <div ng-init="getMoreOwnerProduct('<?php echo $productDetail['user_guid']; ?>', '0')" >
                        <div class="sidebar-sec" ng-if="moreOwnerProductTotal > 0">
                        
                            <div class="widget-title">More products from <a href="<?php echo base_url('userprofile/'.$productDetail['user_guid']); ?>"> <?php echo $productDetail['owner_fname'].' '.$productDetail['owner_lname'];?></a> </div>
                            <div class="widget-sec img-box-sidebar" >
                                <a ng-repeat="moreProduct in moreOwnerProductList" 
                                   ng-href="<?php echo base_url().'product/detail/'; ?>{{moreProduct.item_id}}">
                                    
                                    <img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'?>{{moreProduct.cover_image}}" 
                                         err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" 
                                         alt="{{moreProduct.title}}" title="{{moreProduct.title}}" class="img-responsive">
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div ng-init="getLatestCategoryProduct('<?php echo $productDetail['user_guid']; ?>')" >
                        <div class="sidebar-sec nearest"  ng-if="latestCatProductTotal > 1">
                            <div class="widget-title">Latest items in <a href="#"> fashion and accessories </a> </div>
                            <div class="widget-sec img-box-sidebar" >
                                    <a ng-repeat="latestCatProduct in latestCatProductList" 
                                       ng-if="latestCatProduct.item_id != '<?php echo $productDetail['item_id']; ?>'"
                                       ng-href="<?php echo base_url().'product/detail/'; ?>{{latestCatProduct.item_id}}">

                                        <img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'?>{{latestCatProduct.cover_image}}" 
                                             err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" 
                                             alt="{{latestCatProduct.title}}" title="{{latestCatProduct.title}}" class="img-responsive">
                                    </a>

                                </div>
                        </div>
                    </div>
                    
                    <div ng-init="getSimilarProduct('<?php echo $productDetail['category_id']; ?>')" >
                        <div class="sidebar-sec nearest"  ng-if="similarProductTotal > 1">
                            <div class="widget-title">Similar <a href="#">items</a></div>
                            <div class="widget-sec img-box-sidebar" >
                                    <a ng-repeat="similarProduct in similarProductList" 
                                       ng-if="similarProduct.item_id != '<?php echo $productDetail['item_id']; ?>'"
                                       ng-href="<?php echo base_url().'product/detail/'; ?>{{similarProduct.item_id}}">

                                        <img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'?>{{similarProduct.cover_image}}" 
                                             err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" 
                                             alt="{{similarProduct.title}}" title="{{similarProduct.title}}" class="img-responsive">
                                    </a>

                                </div>
                        </div>
                    </div>

                    <div class="sidebar-sec nearest hide">
                        <div class="widget-title">Items <a href="#">in your area</a></div>
                        <div class="widget-sec img-box-sidebar">
                            <a href="#"><img src="http://cdn.homedit.com/wp-content/uploads/2011/01/ylighting_2143_22227523-1.jpg" alt="ALT" class="img-responsive"></a>
                            <a href="#"><img src="http://www.ikeabrand.com/wp-content/gallery/rabochie_lampi/rabochie_lampi_ikea10.jpeg" alt="ALT" class="img-responsive"></a>
                            <a href="#"><img src="http://emaudesign.com/wp-content/uploads/2015/11/Sleek-outdoor-table-lamps-concept.jpg" alt="ALT" class="img-responsive"></a>
                            <a href="#"><img src="http://www.ikeabrand.com/wp-content/gallery/rabochie_lampi/rabochie_lampi_ikea10.jpeg" alt="ALT" class="img-responsive"></a>
                            <a href="#"><img src="http://cdn.homedit.com/wp-content/uploads/2011/01/ylighting_2143_22227523-1.jpg" alt="ALT" class="img-responsive"></a>
                            <a href="#"><img src="http://www.ikeabrand.com/wp-content/gallery/rabochie_lampi/rabochie_lampi_ikea10.jpeg" alt="ALT" class="img-responsive"></a>
                        </div>
                    </div>

                </div>
                <br/>
                <br/>
            </div>
        </div>
    </div>
    <!-- end detail page -->
    <?php  include_once('include/footer.php'); ?>