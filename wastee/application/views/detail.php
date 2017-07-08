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

                                    <!--<a href="#" class="mark " title="Bookmark">Bookmark</a>-->

                                    <h1 itemprop="name"><?php echo $productDetail['title']; ?></h1>

                                    <p itemprop="description">

                                        <?php echo $productDetail['description']; ?>

                                    </p>

                                    

                                </div>



                                <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">

                                    <div itemprop="availableAtOrFrom" itemscope="" itemtype="http://schema.org/Place">

                                        <span itemprop="address" class="location-text">

                                            Ort: <span><?php echo $productDetail['location']; ?></span>

                                            &nbsp;· Kategorie: <?php echo $productDetail['category_name']; ?> 

                                        </span>

                                        

                                    </div>

                                    <span class="price">

                                        Preis:&nbsp;&nbsp;<strong><span><?php echo $productDetail['currency'].' '.$productDetail['price']; ?></span></strong>                         

                                    </span>

                                </div>



                                <div class="links">

                                    <div class="wrap">

                                        <a href="#make-offer" class="make ">Angebot machen</a>

                                        <a href="#ask-question" class="ask ">Frage stellen</a>

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

                                <h2>Angebote</h2>

                                <?php

                                if (!$this->session->userdata('user_id')){// && $this->session->userdata('user_id') != $productDetail['user_id']) {

                                    ?>

                                <div class="no-offers-yet">

                                    <p><a href="<?php echo base_url('login'); ?>" class="make">Mach das erste Angebot und schnapp es dir!</a></p>

                                </div>

                                <?php

                                } 

                                else {

                                    ?>

                                <span ng-init="getProductOffers();"></span>

                                

                                <div ng-if="ConversationList.length=='0'" class="no-offers-yet no-offers-yet-login">

                                <?php

                                if ($this->session->userdata('user_id') != $productDetail['user_id']) {

                                ?>

                                    <p><a href="javascript:void('0');" class="make">Mach das erste Angebot und schnapp es dir!</a></p>

                                <?php

                                } else {

                                    ?>

                                    <p>No offer found.</p>

                                    <?php

                                }

                                ?>

                                </div>



                                <div class="product_offer" style="display: none;">

                                    <ul class="actions-list">

                                        <li ng-if="have_you_bid == 0" class="top-level new-ag active">

                                            <img class="activity-user-img" src="https://media.shpock.com/1.0/589da7bc75a74db5102d29ae/?aspect_width=32&amp;aspect_height=32" width="32px" height="32px">

                                            <a href="javascript:void(0);" class="opener">

                                                <div class="latest-wrapper">

                                                    Du bietest...

                                                </div>

                                            </a>



                                            <div class="slide">

                                                <ul class="dialog-wrapper">

                                                    <a href="#">

                                                        <li class="activity-detail-li">

                                                            

                                                            <img class="item" ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/'.$productDetail['owner_image'];?>?aspect_width=30&amp;aspect_height=30" 

                                                                    err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=30&amp;aspect_height=30" width="30" height="30">

                                                            <div class="activity">

                                                                

                                                                <p><?php echo $productDetail['owner_fname'].' verkauft "'.$productDetail['title'].'" für '.$productDetail['currency'].' '.$productDetail['price']; ?></p>

                                                                <em><?php echo date('d.m.Y H:i', strtotime($productDetail['created_date']));?></em>

                                                            </div>

                                                        </li>

                                                    </a>



                                                    <a href="#" class="no-action">

                                                        <li class="activity-detail-info">

                                                            <div class="item info"></div>

                                                            <div class="activity">

                                                                <p>Angebote sind unverbindlich. Ein verbindlicher Kauf findet statt, wenn beide Parteien zustimmen. (Einer akzeptiert & der andere bestätigt.)</p>

                                                            </div>

                                                        </li>

                                                    </a>



                                                    <li class="buttons comment-form-wrapper">

                                                        <form class="comment-form visible" ng-submit="AddOffer()">

                                                            <fieldset ng-init="add_offer.conversation_id='0'; add_offer.owner_id='<?php echo $productDetail['user_id']; ?>'">

                                                                <input type="hidden" ng-model="add_offer.conversation_id" />

                                                                <input type="text" name="offer"  ng-model="add_offer.price" placeholder="0,00" maxlength="20">

                                                                <input type="text" maxlength="500" name="message"  ng-model="add_offer.message" placeholder="Comment" class="comment">

                                                                <input type="submit" value="Offer">

                                                            </fieldset>

                                                        </form>

                                                    </li>



                                                </ul>



                                            </div>

                                        </li>

                                        

                                        <li ng-repeat="Conversation in ConversationList" class="top-level new-ag active">

                                            <img class="activity-user-img" src="https://media.shpock.com/1.0/589da7bc75a74db5102d29ae/?aspect_width=32&amp;aspect_height=32" width="32px" height="32px">

                                            <?php 

                                            if($this->session->userdata('user_id') == $productDetail['user_id']){

                                            ?>

                                            <a href="javascript:void(0);" id="opener-{{Conversation.conversation_id}}" class="opener">

                                                <div class="latest-wrapper" ng-show="Conversation.user_id == '<?php echo $this->session->userdata('user_id'); ?>'">You Offered {{Conversation.price}}.</div>

                                                <div class="latest-wrapper" ng-show="Conversation.user_id != '<?php echo $this->session->userdata('user_id'); ?>'">{{Conversation.first_name}} Offered {{Conversation.price}}.</div>

                                            </a>

                                            <?php

                                            } else {

                                                ?>

                                            <a ng-if="Conversation.user_id != '<?php echo $this->session->userdata('user_id'); ?>'" ng-href="<?php echo base_url();?>userprofile/{{Conversation.user_guid}}" id="opener-{{Conversation.conversation_id}}" class="opener">

                                                <div class="latest-wrapper" ng-show="Conversation.user_id == '<?php echo $this->session->userdata('user_id'); ?>'">You Offered {{Conversation.price}}.</div>

                                                <div class="latest-wrapper" ng-show="Conversation.user_id != '<?php echo $this->session->userdata('user_id'); ?>'">{{Conversation.first_name}} Offered {{Conversation.price}}.</div>

                                            </a>

                                            <a ng-if="Conversation.user_id == '<?php echo $this->session->userdata('user_id'); ?>'" href="javascript:void(0);" id="opener-{{Conversation.conversation_id}}" class="opener">

                                                <div class="latest-wrapper" ng-show="Conversation.user_id == '<?php echo $this->session->userdata('user_id'); ?>'">You Offered {{Conversation.price}}.</div>

                                                <div class="latest-wrapper" ng-show="Conversation.user_id != '<?php echo $this->session->userdata('user_id'); ?>'">{{Conversation.first_name}} Offered {{Conversation.price}}.</div>

                                            </a>

                                            <?php

                                            }

                                            ?>

                                            <div class="slide" ng-if="Conversation.offers">

                                                <ul class="dialog-wrapper">

                                                    <!-- OWNER DETAIL -->

                                                    <a href="javascript:void(0);">

                                                        <li class="activity-detail-li">

                                                            <img class="item" ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/'.$productDetail['owner_image'];?>?aspect_width=30&amp;aspect_height=30" 

                                                                    err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=30&amp;aspect_height=30" width="30" height="30">

                                                            <div class="activity">

                                                                

                                                                <p><?php echo $productDetail['owner_fname'].' is selling "'.$productDetail['title'].'" for '.$productDetail['currency'].' '.$productDetail['price']; ?></p>

                                                                <em><?php echo date('d.m.Y H:i', strtotime($productDetail['created_date']));?></em>

                                                            </div>

                                                        </li>

                                                    </a>

                                                    

                                                    <!-- COMMON INFO TEXT -->

                                                    <a href="javascript:void(0);" class="no-action">

                                                        <li class="activity-detail-info">

                                                            <div class="item info"></div>

                                                            <div class="activity">

                                                                <p>Offers are not binding. A legally binding agreement is entered when both sides agree. One accepts &amp; the other confirms.</p>

                                                            </div>

                                                        </li>

                                                    </a>

                                                    <!-- OFFER REPEAT -->

                                                    <a href="javascript:void(0);" ng-repeat="Offer in Conversation.offers">

                                                        <li class="activity-detail-li">

                                                            <img class="item" 

                                                                    ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/';?>{{Offer.user_image}}?aspect_width=30&amp;aspect_height=30" 

                                                                    err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=30&amp;aspect_height=30" width="30" heigth="30">

                                                            

                                                            <div class="activity">

                                                                <p ng-show="Offer.user_id == '<?php echo $this->session->userdata('user_id'); ?>'">You Offered {{Offer.price}}.<br>{{Offer.message}}</p>

                                                                <p ng-show="Offer.user_id != '<?php echo $this->session->userdata('user_id'); ?>'">{{Offer.first_name}} Offered {{Offer.price}}.<br>{{Offer.message}}</p>

<!--                                                                <p ng-bind="Offer.message"></p>-->

                                                                <em ng-bind="Offer.added_date"></em>

                                                            </div>

                                                        </li>

                                                    </a>



                                                    <li ng-if="Conversation.confirm_offer_id == '0'" class="buttons comment-form-wrapper">

                                                        <form class="comment-form visible" ng-submit="AddOffer($index, Conversation.conversation_id)">

                                                            <fieldset ng-init="add_offer.owner_id='<?php echo $productDetail['user_id']; ?>'">

                                                                <input type="text" name="offer"  ng-model="add_offer.price" placeholder="0,00" maxlength="20">

                                                                <input type="text" maxlength="500" name="message"  ng-model="add_offer.message" placeholder="Comment" class="comment">

                                                                <input type="submit" value="Offer">

                                                            </fieldset>

                                                        </form>

                                                        </form>

                                                    </li>

                                                    

                                                    <li ng-show="Conversation.lastoffer.offer_id" class="waiting-for-response" >

                                                        <span>{{Conversation.lastoffer.price}}</span> 

                                                        was last offered by {{Conversation.lastoffer.first_name}}

                                                    </li>



                                                    <li ng-show="Conversation.lastoffer.offer_id && Conversation.confirm_offer_id == 0" class="buttons comment-form-wrapper accept-counter">

                                                        <a href="javascript:void(0);" ng-click="AcceptOffre(Conversation.lastoffer, '<?php echo $productDetail['user_id']; ?>')" class="accept">Accept</a>

                                                    </li>



                                                </ul>





                                                <!-- confirm and reject offer -->

                                                <div ng-if="Conversation.confirm_offer_id != 0" class="dc-panel confirm-reject-box">

                                                    

                                                    <div class="top-panel">

                                                        <div class="outer-yn"

                                                             ng-class="{ 'accepted': (Conversation.is_owner_confirm > 0 )}">

                                                            <span ng-if="Conversation.owner_id == '<?php echo $this->session->userdata('user_id'); ?>'">You</span>

                                                            <span ng-if="Conversation.owner_id != '<?php echo $this->session->userdata('user_id'); ?>'"><?php echo $productDetail['owner_fname']; ?></span>

                                                        </div>

                                                        <div class="inner">&nbsp;</div>

                                                        <div class="outer-yn"

                                                             ng-class="{ 'accepted': (Conversation.is_buyer_confirm > 0 )}">

                                                            <span ng-if="Conversation.user_id == '<?php echo $this->session->userdata('user_id'); ?>'">You</span>

                                                            <span ng-if="Conversation.user_id != '<?php echo $this->session->userdata('user_id'); ?>'" ng-bind="(Conversation.buyer_fname == null) ? Conversation.first_name : Conversation.buyer_fname"></span>

                                                        </div>

                                                        <div class="clearall"></div>

                                                    </div>



                                                    <div class="center-panel">

                                                        <div class="outer-yn">

                                                            <div class="circle-wrapper " ng-class="{'gray-out' :(Conversation.is_owner_confirm == '0')}">

                                                                <img src="https://m1.secondhandapp.com/1.0/589da7bc75a74db5102d29ae/?aspect_width=64&amp;aspect_height=64" width="64" height="64">

                                                            </div>

                                                            <div class="corner-icon " 

                                                                 ng-class="(Conversation.is_owner_confirm > '0') ? 'corner-icon-left': 'corner-icon-right gray-out'"></div>

                                                        </div>

                                                        <div class="inner">

                                                            <div class="border-wrapper"></div>

                                                            <div class="price-wrapper">

                                                                <span class="price-bubble" ng-bind="Conversation.currency+' '+Conversation.c_price"></span>

                                                            </div>

                                                        </div>

                                                        <div class="outer-yn">

                                                            <div class="circle-wrapper " ng-class="{'gray-out' :(Conversation.is_buyer_confirm == '0')}">

                                                                <img src="https://m1.secondhandapp.com/1.0/589da7bc75a74db5102d29ae/?aspect_width=64&amp;aspect_height=64" width="64" height="64">

                                                            </div>

                                                            <div class="corner-icon "

                                                                 ng-class="(Conversation.is_buyer_confirm > '0') ? 'corner-icon-left': 'corner-icon-right gray-out'"></div>

                                                        </div>

                                                        <div class="clearall"></div>

                                                    </div>



                                                    <div class="bottom-panel">

                                                        <div class="outer-yn " ng-class="{'accepted':(Conversation.is_owner_confirm > '0')}">

                                                            <span ng-if="Conversation.is_owner_confirm > '0'">has accepted</span>

                                                            <span ng-if="Conversation.is_owner_confirm == '0'">still has to confirm</span>

                                                        </div>

                                                        <div class="inner">&nbsp;</div>

                                                        <div class="outer-yn " ng-class="{'accepted':(Conversation.is_buyer_confirm > '0')}">

                                                            <span ng-if="Conversation.is_buyer_confirm > '0'">has accepted</span>

                                                            <span ng-if="Conversation.is_buyer_confirm == '0'">still has to confirm</span>

                                                        </div>

                                                        <div class="clearall"></div>

                                                    </div>



                                                    <div class="button-panel" ng-if="(Conversation.is_owner_confirm != '<?php echo $this->session->userdata('user_id'); ?>') && (Conversation.is_buyer_confirm != '<?php echo $this->session->userdata('user_id'); ?>')">

                                                        <div class="outer-yn">

                                                            <a href="javascript:void('0');" class="abort cancel" ng-click="CanclePopup(Conversation.conversation_id, 'show');">Cancel deal</a>

                                                        </div>

                                                        <div class="inner">&nbsp;</div>

                                                        <div class="outer-yn">

                                                            <a href="javascript:void('0');" class="confirm" ng-click="ConfirmPopup(Conversation.conversation_id, 'show');">Confirm</a>

                                                        </div>

                                                        <div class="clearall"></div>

                                                    </div>



                                                    <div id="cancle-deal-{{Conversation.conversation_id}}" style="display: none;" class="confirm-selection-panel confirm-dc confirm-step-1">

                                                        <p><strong>Cancel deal</strong></p>

                                                        <p>Are you sure you want to cancel the deal?</p>

                                                        <br>

                                                        <a href="javascript:void('0');" ng-click="CanclePopup(Conversation.conversation_id, 'hide');"class="choice no">No</a>

                                                        <a href="javascript:void('0');" ng-click="CancleDeal(Conversation.conversation_id);" class="choice yes">Yes</a>

                                                        <div class="clearall"></div>

                                                    </div>



                                                    <div id="confirm-deal-{{Conversation.conversation_id}}" style="display: none;" class="confirm-selection-panel confirm-dc confirm-step-1">

                                                        <p><strong>Confirm deal</strong></p>

                                                        <p>Are you sure you want to confirm deal for "<?php echo $productDetail['title']?>" for {{Conversation.currency}} {{Conversation.c_price}}? (legally binding agreement)</p>

                                                        <br>

                                                        <a href="javascript:void('0');" ng-click="ConfirmPopup(Conversation.conversation_id, 'hide');" class="choice no">No</a>

                                                        <a href="javascript:void('0');" ng-click="ConfirmDeal(Conversation.conversation_id);" class="choice yes">Yes</a>

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

                                                <div class="after-confirm-box" ng-if="Conversation.is_buyer_confirm > '0' && Conversation.is_owner_confirm > '0'">

                                                    <div class="sold-box-v2">

                                                        <p class="congrat-top">Congrats!</p>

                                                        <p class="congrat-bottom">Your deal was successful!</p>

                                                        <p class="do-sth">Contact details is  here to organize the time and place of delivery:</p>

                                                        <p class="so-sth-sub">For tips on how to pay and deliver safely, visit our Help area.</p>

                                                    </div>



                                                    <div class="chat-box">

                                                        <ul class="chat-box-border"></ul>

                                                        <div class="chat-box-border">



                                                            <h3 ng-if="Conversation.is_buyer_confirm != '<?php echo $this->session->userdata('user_id'); ?>'">

                                                                Buyer Email :- {{Conversation.buyer_email}}

                                                            </h3>

                                                            <h3 ng-if="Conversation.is_owner_confirm != '<?php echo $this->session->userdata('user_id'); ?>'">

                                                                Seller Email :- <?php echo $productDetail['email']; ?>

                                                            </h3>

                                                            

                                                            <div ng-if="Conversation.is_owner_confirm != '<?php echo $this->session->userdata('user_id'); ?>'">

                                                                <form id="review_form" method="post" ng-submit="AddReview()">

                                                                    <textarea rows="3" cols="30" name="review"></textarea>

                                                                    

                                                                    <input type="hidden" name="conversation_id" value="{{Conversation.conversation_id}}" />

                                                                    <input type="hidden" name="review_for" value="{{Conversation.is_owner_confirm}}" />

                                                                    <input type="hidden" name="rating" value="{{rating}}" />

                                                                    

                                                                    <div ng-init="rating = star.rating + 1"></div>

                                                                    <div class="star-rating" star-rating rating-value="rating" data-max="5" on-rating-selected="rateFunction(rating)"></div>

                                                                    

                                                                    <input type="submit" value="Submit" /> 

                                                                </form>

                                                            </div>

                                                       </div>

                                                    </div>



                                                    <div class="dialog-ratings-box dialog-ratings-box--soon">

<!--                                                        <p>You will be able to review Vivek S. shortly.</p>-->

                                                    </div>

                                                </div>

                                                <!-- end after confirm -->

                                            </div>

                                        </li>

                                    </ul>

                                </div>

                                <?php

                                }

                                ?>

                                



                            </div>

                                </div>



                                <div class="col-md-6">

                                    <div class="column">

                                        <h2>Fragen</h2>

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

                        

                            <div class="widget-title">mehr Angebote von <a href="<?php echo base_url('userprofile/'.$productDetail['user_guid']); ?>"> <?php echo $productDetail['owner_fname'].' '.$productDetail['owner_lname'];?></a> </div>

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

                            <div class="widget-title">Neuste Angebote in <a href="#"> Früchte & Gemüse </a> </div>

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

                            <div class="widget-title">Ähnliche <a href="#">Angebote</a></div>

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

    <style>

        .rating {

  color: #a9a9a9;

  margin: 0;

  padding: 0;

}



ul.rating {

    display: inline-block;

    background: none !important;

    padding: 0 !important;

    margin: 0 !important;

    border: none !important;

}



.rating li {

        background: none !important;

    list-style-type: none;

    display: table-cell;

    padding: 1px !important;

    text-align: center;

    font-weight: bold;

    cursor: pointer;

    font-size: 20px;

    width: 20px !important;

}



.rating .filled {

  color: #fd0 !important;

}

    </style>

    <!-- end detail page -->

    <?php  include_once('include/footer.php'); ?>