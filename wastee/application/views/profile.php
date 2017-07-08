<?php  include_once('include/header.php'); ?>

    

    <br/>

    <br/>

    <!-- detail page start -->

    <div class="container user-profile-page" ng-controller="SettingCTRL"> 



        <div class="row">

            <div class="col-md-8" style="margin-bottom:85px;">

                <div class="image-box-profile">

                    <div class="image-box-inner-profile">

                        <img ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/'.$profileDetail['image'];?>" 

                                     err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=190&amp;aspect_height=190" width="190" height="190" alt="Nico J.">

                    </div>

                </div>



                <div class="text-box-profile">

                    <h1><?php echo $profileDetail['first_name'].' '.$profileDetail['last_name']; ?></h1>

                    <div class="ratings-box">

                        <span class="ratings--stars">

                            <img class="star" src="https://en.shpock.com/style/images/mobile/star.png" alt="Star" width="20">

                            <img class="star" src="https://en.shpock.com/style/images/mobile/star.png" alt="Star" width="20">

                            <img class="star" src="https://en.shpock.com/style/images/mobile/star.png" alt="Star" width="20">

                            <img class="star" src="https://en.shpock.com/style/images/mobile/star.png" alt="Star" width="20">

                            <img class="star" src="https://en.shpock.com/style/images/mobile/star.png" alt="Star" width="20">

                        </span>

                        <span class="ratings--count">

                            ({{total_review}} Bewertungen)

                        </span>

                    </div>

                    <div class="follow-box" ng-init="is_follow = '<?php echo $profileDetail['is_follow']; ?>'" >

                        <ul class="stats">

                            <li><?php echo $profileDetail['sell_count']; ?> Verkäufe · <?php echo $profileDetail['buy_count']; ?> Käufe</li>

                            <li>Registriert seit <?php echo $profileDetail['register_date']; ?></li>

                        </ul>

                        <?php

                        if($this->session->userdata('user_id')){

                            if($this->session->userdata('user_id') != $profileDetail['user_id']){

                                ?>

                        <a href="javascript:void(0);" ng-click="setFollowStatus('<?php echo $profileDetail['user_id']; ?>')" class="follow-link btn-loadable">

                            <span ng-if="is_follow == 1">Entfolgen</span>

                            <span ng-if="is_follow == 0">Folgen</span>

                            <span class="loader"></span>

                        </a>

                            <?php

                            }

                        } else {

                            ?>

                            <a href="<?php echo base_url('login'); ?>" class="follow-link ">Follow </a>

                        <?php

                        }

                        ?>

                    </div>

                </div>



                <div class="social-box hide">

                    <ul class="social-networks">

                        <li>

                            <span>Share&nbsp;</span>

                        </li>

                        <li>

                            <a href="#profile-share-facebook" class="facebook">Facebook</a>

                        </li>

                        <li>

                            <a href="#profile-share-google-plus" class="google-plus">Google Plus</a>

                        </li>

                        <li>

                            <a href="#profile-share-twitter" class="twitter">Twitter</a>

                        </li>

                        <li>

                            <a href="#profile-share-pinterest" class="pinterest">Pinterest</a>

                        </li>

                        <li>

                            <a href="#profile-share-email" class="email">E-mail</a>

                        </li>

                    </ul>

                    <div class="friends-box"></div>

                </div>



                <ul class="links-list">

                    <li class="list-item" data-type="items">

                        <a href="javascript:void('0');"> Items </a>

                    </li>

                    <li data-type="reviews" class="list-reviews">

                        <a href="javascript:void('0');"> Bewertungen ({{total_review}}) </a>

                    </li>

                </ul>



                <div ng-controller="ProductCTRL">

                    <div class="watchlist-wrapper watchlist-wrapper-item active" data-type="items">

                        <div class="products" ng-init="getMoreOwnerProduct('<?php echo $profileDetail['user_guid'];?>')">

                            <ul>

                                <li class="" ng-repeat="moreProduct in moreOwnerProductList">

                                    <a ng-href="<?php echo base_url().'product/detail/'; ?>{{moreProduct.item_id}}" 

                                       title="{{moreProduct.title}}">

                                        <img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'?>{{moreProduct.cover_image}}" 

                                            err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" 

                                            alt="{{moreProduct.title}}" title="{{moreProduct.title}}" 

                                            width="193" height="193" >

                                        <span ng-if="moreProduct.is_sold=='1'" class="sold">Sold</span>                                      

                                    </a>

                                </li>



                            </ul>

                        </div>

                    </div>



                    <div class="watchlist-wrapper watchlist-wrapper-review" data-type="reviews">

                        <div class="ratings" ng-init="getReviewList('<?php echo $profileDetail['user_id'];?>');">

                            <a class="ratings__entry" ng-repeat="Review in ReviewList" href="<?php echo base_url()?>userprofile/{{Review.rb_user_guid}}">

                                <div class="ratings__user-avatar">

                                    <img class="user-avatar" ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/';?>{{Review.rb_image}}?aspect_width=64&amp;aspect_height=64" 

                                                    err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=64&amp;aspect_height=64" width="64" height="64">

                                </div>

                                <div class="ratings__text-box">

                                    <b class="ratings__user-name" ng-bind="Review.rb_first_name"></b>

                                    <div class="ratings-box">

                                        <div class="ratings--stars">

                                            <img ng-repeat="rate in [1,2,3,4,5] | limitTo:Review.rating" class="star" ng-src="https://en.shpock.com/style/images/mobile/star.png" alt="Star" width="20">

                                        </div>

                                    </div>

    <!--                                <p class="ratings__item">

                                        <b>Sold</b>:

                                        apex isub mit rba

                                    </p>-->

                                    <p class="ratings__review-text">

                                        {{Review.review}}

                                    </p>

                                    <p class="ratings__date" ng-bind="Review.added_date">



                                    </p>

                                </div>

                            </a>



                        </div>

                    </div>



                </div>



            </div>

            <div class="col-md-4">

                <div class="sidebar" ng-init="getFollowsNFollower('<?php echo $profileDetail['user_guid']; ?>')">

                    

                    <div class="sidebar-sec">

                        <div class="widget-title"><?php echo $profileDetail['first_name'].' '.$profileDetail['last_name']; ?> folgt</div>

                        <div class="widget-sec img-box-sidebar img-box-circle">

                            <a ng-repeat="Follows in FollowsList" 

                               title="{{Follows.first_name}} {{Follows.last_name}}"

                               ng-href="<?php echo base_url();?>userprofile/{{Follows.user_guid}}">

                                <img ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/';?>{{Follows.image}}" 

                                        err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=64&amp;aspect_height=64" style="" class="img-responsive">

                            </a>

                        </div>

                    </div>

                    

                    <div class="sidebar-sec nearest">

                        <div class="widget-title"><?php echo $profileDetail['first_name'].' '.$profileDetail['last_name']; ?> folgen</div>

                        <div class="widget-sec img-box-sidebar img-box-circle">

                            <a ng-repeat="Follower in FollowersList" 

                               title="{{Follower.first_name}} {{Follower.last_name}}"

                               ng-href="<?php echo base_url();?>userprofile/{{Follower.user_guid}}">

                                <img ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/';?>{{Follower.image}}" 

                                        err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=64&amp;aspect_height=64" style="" class="img-responsive">

                            </a>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <!-- end detail page -->

    

    <script type="text/javascript">

        jQuery(document).ready(function(){

            

            // profile tab

            jQuery(".list-item").addClass('active');

            jQuery("li.list-item a").click(function(){

                jQuery('.links-list li').removeClass('active');

                jQuery(this).parent('li').addClass('active');

                jQuery('.watchlist-wrapper').removeClass('active');

                jQuery('.watchlist-wrapper-item').addClass('active');

            });



            jQuery("li.list-reviews a").click(function(){

                jQuery('.links-list li').removeClass('active');

                jQuery(this).parent('li').addClass('active');

                jQuery('.watchlist-wrapper').removeClass('active');

                jQuery('.watchlist-wrapper-review').addClass('active');

            });

        })

    </script>



    <?php  include_once('include/footer.php'); ?>