<?php  include_once('include/header.php'); ?>

    <!-- home page start -->

    <div id="HomeCTRL" ng-controller="HomeCTRL" ng-init="search_cat = '<?php echo $search_category; ?>'; searchtext = '<?php echo $searchtext; ?>'">

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <div class="banner"> <img src="<?php echo base_url(); ?>/assets/images/banner.png"></div>

                </div>

            </div>

        </div>



        <div class="container banner-bottom">

        <div class="row1">

            <div class="col-md-7" ng-bind="(SearchLocation!= '') ? 'Offers within 1 km of '+SearchLocation : 'Wastee - classified ads in your area'">

                Wastee - Lebensmittel in deiner Nähe

            </div>



            <div class="col-md-5">

                <div class="location">

                    <a href="#" class="location-link" title="Identify location">Location</a>

                    <form class="code-form" ng-submit="SearchByLocation()">

                        <fieldset>

                            <input type="text" placeholder="PLZ, Ort" class="loc" 

                                   id="SearchLocation" ng-model="SearchLocation">

                            <input type="submit" value="submit">

                        </fieldset>

                    </form>

                    <ul class="switch-list">

                        <li><a href="javascript:void('0');" class="link1 only-image">Regular product view</a></li>

                        <li class="active"><a href="javascript:void('0');" class="link2 only-image-text">Detailed view</a></li>

                    </ul>

                </div>

            </div>

        </div>    

    </div>



        <div class="container marketing home-pinterest" ng-init="getProductList();"> 

            <!-- <a href="javascript:void('0');" style="color:red;" class="only-image">Only Image</a> 

            <a href="javascript:void('0');" style="color:red;" class="only-image-text">Only Image With Text</a> -->



            <div class="row">

                <div class="col-md-8">



                    <img src="<?php echo base_url();?>/assets/images/index_tutorial_banner.png" alt="banner-tutorial" class="img-responsive">



                    <section id="blog-landing">

                        <article class="white-panel" ng-if="ProductList.length" ng-repeat="product in ProductList" id="item-{{product.item_id}}">

                            <div class="img-pin">

                                <a ng-href="<?php echo base_url().'product/detail/'; ?>{{product.item_id}}"> 

                                    <img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'?>{{product.cover_image}}" 

                                         err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" alt="{{product.title}}">

                                    <div class="hover-pin">

                                        <h3 ng-bind="product.title">Product title</h3>

                                        <p class="price" ng-bind="product.currency+' '+product.price">€ 400</p>

                                        <div class="readmore">

                                            <p><a href="#">Ansehen</a></p>

                                        </div>

                                    </div>

                                </a>

                            </div>

                            <div class="pin-text">

                                <h2><a ng-href="<?php echo base_url().'product/detail/'; ?>{{product.item_id}}" ng-bind="product.title"></a></h2>

                                <p ng-bind="product.description"></p>

                                <p class="price" ng-bind="'Price: '+product.currency+' '+product.price"></p>

                            </div>

                        </article>

                        

                    </section>

                    <div class=" clearall"></div>

                    <div id="load-more"><a href="javascript:void(0);" ng-click="LoadMoreHomeProduct();">Load More</a></div>

                </div>

                <div class="col-md-4">

                    <div class="sidebar">

                        <!-- <div class="vdo sidebar-sec">

                            <iframe src="https://www.youtube.com/embed/61TAqY03xwk" frameborder="0" allowfullscreen></iframe>

                        </div> -->

                        <div ng-controller="ProductCTRL" class="sidebar-sec recentadd" ng-init="getRecentProductList();">

                            <div class="widget-title">kürzlich hinzugefügt</div>

                            <div class="widget-sec">

                                <a ng-repeat="RProduct in RecentProductList" ng-href="<?php echo base_url().'product/detail/'; ?>{{RProduct.item_id}}" >

                                    <img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'?>{{RProduct.cover_image}}" 

                                         err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" alt="{{RProduct.title}}" class="img-responsive">

                                </a>

                            </div>

                        </div>

                        <div class="sidebar-sec nearest" ng-init="getNearYouProduct();">

                            <div class="widget-title">in deiner Nähe</div>

                            <div class="widget-sec">

                                <a ng-repeat="NProduct in NearYouProduct" ng-href="<?php echo base_url().'product/detail/'; ?>{{NProduct.item_id}}" >

                                    <img ng-src="<?php echo IMAGE_UPLOADS_URL.'product/thumb/'?>{{NProduct.cover_image}}" 

                                         err-src="<?php echo IMAGE_UPLOADS_URL . '/default-product.jpg'; ?>" alt="{{NProduct.title}}" class="img-responsive">

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end home page -->

    <?php include('include/footer.php'); ?>

        <script>

            jQuery(document).ready(function() {

                

                LocationInitialize('SearchLocation');

         

//                jQuery('#blog-landing').pinterest_grid({

//                    no_columns: 3,

//                    padding_x: 10,

//                    padding_y: 10,

//                    margin_bottom: 50,

//                    single_column_breakpoint: 700

//                });



                jQuery(".only-image").on("click", function() {

                    jQuery(".pin-text").hide();

                    jQuery(".switch-list li").removeClass('active');

                    jQuery(this).parent('li').addClass('active');

                });

                jQuery(".only-image-text").on("click", function() {

                    jQuery(".pin-text").show();

                    jQuery(".switch-list li").removeClass('active');

                    jQuery(this).parent('li').addClass('active');

                });

            });

        </script>