<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<meta charset="UTF-8">

	<title>mobile</title>
        
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/angular.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/alertify/alertify.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/ajaxupload.3.5.js"></script>
        <script src="<?php echo base_url();?>assets/js/custom.js"></script>
        <script src="<?php echo base_url();?>assets/js/pinterest_grid.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/controller.js?ver=1.2"></script>
        <script src="<?php echo base_url(); ?>assets/js/lightbox.js"></script>
        
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/lightbox.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/alertify/alertify.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/responsive.css">

	<!-- <link rel="stylesheet" type="text/css" href="assets/css/responsive.css"> -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet"> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Owl Stylesheets -->
<!--    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owlcarousel/owl.theme.default.min.css">-->


    <!-- javascript -->
<!--    <script src="<?php echo base_url();?>assets/js/owlcarousel/jquery.min.js"></script>-->
<!--    <script src="<?php echo base_url();?>assets/js/owlcarousel/owl.carousel.js"></script>-->

	
        <?php 
        
        include_once 'global_script_var.php';
        ?>
	
</head>

<body ng-app="App" ng-controller="RootCTRL">
    

    <header class="outer">
        <div class="header_outer">
            <div class="container">
                <div class="row">
                    <div class="logo col-md-4 col-xs-12 col-sm-3 display-table">
                        <div class="display-table-cell">	
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/logonew.png" width="150"></a>
                        </div>	
                    </div>

                    <div class="navigation col-md-4 col-xs-12 col-sm-6 text-center display-table">
                        <nav class="display-table-cell">
                            <ul>
                                <li><a href="<?php echo base_url(); ?>faq">So funktioniert's</a></li>
                                <li><span> &nbsp; · &nbsp; </span><a href="javascript:void('0');">Blog</a></li>
                                <li><span> &nbsp; · &nbsp; </span><a href="javascript:void('0');">Jobs</a></li>
                            </ul>
                        </nav>	
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-3 log-reg text-right display-table">
                        <div class="display-table-cell">	
                            <?php if ($this->session->userdata('user_id') == '') { ?>
                                <div class="hdr-reg"><a href="<?php echo base_url(); ?>login">Register</a></div>
                                <div class="hdr-login"><a href="<?php echo base_url(); ?>login">Login</a></div>
                                <?php
                            } else {
                                ?>
                                <div  ng-controller="logoutCtrl"  class="hdr-login"><a ng-click="logout();">Abmelden</a></div>
                                <div class="hdr-login"><a href="<?php echo base_url('myprofile'); ?>">Mein Profil</a></div>

                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <?php if ($this->session->userdata('user_id')) { ?>
                    <div class="col-md-2 col-xs-12 text-center profile-avatar">
                        <img class="avatarimg" ng-click="getNotification()"
                             ng-src="<?php echo IMAGE_UPLOADS_URL.'user/thumb/'.$this->session->userdata('user_image');?>?aspect_width=50&amp;aspect_height=50" 
                             err-src="https://media.shpock.com/1.0/default_avatar_f_3/?aspect_width=50&amp;aspect_height=50">
                        <div class="notification-box">
                            
                            <ul class="notification-ul" >
                                
                                <li ng-if="load_notification == true">
                                    Notification Loading....
                                </li>
                                
                                <li ng-if="NotificationTotal==0 && load_notification == false">
                                    Keine neuen Nachrichten
                                </li>
                                
                                <li ng-if="NotificationTotal>0" ng-repeat="Notification in NotificationList ">
                                    <a href="#">
                                        <img src="<?php echo base_url(); ?>/assets/images/cat5.jpg"> 
                                        <span ng-bind-html="trustAsHtml(Notification.notification_text)"></span>
                                    </a>
                                </li>
<!--                                <li>
                                    <a href="#">
                                        <img src="<?php echo base_url(); ?>/assets/images/search_alert.png"> 
                                        Your alert "bag" has found new items! Check it out!
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo base_url(); ?>/assets/images/search_alert.png"> 
                                        Your alert "bag" has found new items! Check it out!
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo base_url(); ?>/assets/images/search_alert.png"> 
                                        Your alert "bag" has found new items! Check it out!
                                    </a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    
                </div>
            </div>	
        </div>

        <div class="">
            
            <div class="container">
                <div class="row1">
                    <div class="header_btm">
                    <div class="col-md-8">
                        
                        <?php 
                        $this->db->select('category_id,category_name, category_class');
                        $this->db->from(CATEGORY);
                        $this->db->where('status_id', 2);
                        $this->db->order_by('order', 'ASC');

                        $cat_query = $this->db->get();

                        $categoryList = $cat_query->result_array();
                        //print_r($categoryList);
                        ?>

                        <!-- ++++++++ -->
                        <div class="categories">
                            <a class="opener cat-opener" href="#">Kategorien</a>
                            <div class="slide cat-header-sec">
                                <span class="arrow"></span>
                                <ul>
                                    <?php
                                    if(!empty($categoryList)){
                                        foreach($categoryList as $cat){
                                            ?>
                                            <li>
                                                <a href="<?php echo base_url('?category='.$cat['category_id']); ?>" class="f_cat " data-key="fa">
                                                    <span class="cat <?php echo $cat['category_class']; ?>"></span><div class="text">
                                                        <span><?php echo $cat['category_name']; ?></span></div>
                                                </a>
                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>

                                </ul>
                                <a href="javascript:void('0');" class="pull opener">Pull</a>
                            </div>
                        </div>
                        <!-- ====== -->

                        <!-- add section before login -->

                        <?php
                        if($this->session->userdata('search_tag')){
                            $search_tags = $this->session->userdata('search_tag');
                        } else {
                            $search_tags = json_encode(array());
                        }
                        ?>
                        <div class="add-box" ng-init='SearchTags = <?php echo $search_tags;?>'>
                            <div class="opener-box">
                                <a class="opener" href="#">Add</a>
                            </div>
                            <div class="slide">
                                <span class="arrow"></span>
                                <div class="slide-inner">
                                    <strong class="title">Such-Agent</strong>
                                    <form class="add-form" ng-submit="CreateSearchTag();">
                                        <fieldset>
                                            <input type="text" ng-model="search_tag" placeholder="Neuer Such-Agent" class="query">
                                            <input type="submit" value="add">
                                        </fieldset>
                                    </form>
                                    <?php
                                    if(!$this->session->userdata('user_id')){
                                        ?>
                                        <div class="list-holder">
                                            <p class="no-alerts-yet">
                                                So funktioniert's:<br><br>Neuen Such-Agent anlegen → Sobald neue Produkte zum Suchbegriff verkauft werden, bekommst du eine Nachricht.<br><br>Kein Interesse mehr? Agenten einfach löschen.
                                            </p>
                                        </div>
                                    <?php
                                    } else {
                                        ?>
                                        <!-- after login -->
                                        <div class="list-holder list-tag-header">
                                            <ul ng-if="SearchTags.length>0">
                                                <li class="" ng-repeat="tag in SearchTags track by $index">
                                                    <a href="javascript:void(0);" ng-click="RemoveSearchTag($index)" class="remove" data-key="{{tag}}" ng-bind="tag"></a>
                                                    <a href="javascript:void(0);" class="q goto" ng-bind="tag"></a>
                                                </li>

                                            </ul>
                                            <p ng-if="SearchTags.length==0" class="no-alerts-yet">
                                                How it works:<br>Add a new search alert → and as soon as products matching your search are listed, you will be notified.<br><br> As soon as you've got what you need, just remove the search agent.
                                            </p>
                                        </div>
                                        <!-- after login end -->
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>


                        <!-- end add section before login -->

                        <!-- add section  after login-->
                        <!-- <div class="add-box">
                                <div class="opener-box">
                                                                <a class="opener" href="#">Add</a>
                                                        </div>
                                                        <div class="slide" style="display: none;">
                                                                <span class="arrow"></span>
                                                                <div class="slide-inner">
                                                                        <strong class="title">Search alert</strong>
                                                                        <form action="#" class="add-form">
                                                                                <fieldset>
                                                                                        <input type="text" placeholder="New search alert" class="query">
                                                                                        <input type="submit" value="add">
                                                                                </fieldset>
                                                                        </form>
                                                                        <div class="list-holder">
                                                                                <ul>
                                                                                        <li class="odd">
                                                                                                <a href="#alert-remove" class="remove" data-key="hello">hello</a>
                                                                                                <a href="https://en.shpock.com/q/hello/" class="q goto">hello</a>
                                                                                        </li>
                                                                                        <li class="odd">
                                                                                                <a href="#alert-remove" class="remove" data-key="test">test</a>
                                                                                                <a href="https://en.shpock.com/q/test/" class="q goto">test</a>
                                                                                        </li>
                                                                                </ul>
                                                                                <div class="no-more-alerts-allowed-wrapper">
                                                                                        <div class="no-more-alerts-allowed">
                                                                                                <span class="icon"></span>
                                                                                                <p>Error. Limit is reached. No further search alerts possible.</p>
                                                                                                <p class="action">Delete an existing search agent.</p>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div> -->
                        <!-- end add section -->

                        <!-- search box header -->
                        <form action="<?php echo base_url(); ?>" class="search-form" method="get">
                            <fieldset>
                                <input type="hidden" name="category" value="<?php echo @$search_category;?>" >
                                <input type="text" name="searchtext" value="<?php echo @$searchtext;?>" placeholder="Suchen" class="search" >
                                <input type="submit" value="search">
                            </fieldset>
                        </form>
                        <!-- end header search box -->

                    </div>


                    <div class="sell col-md-4">
                        <div class="pull-right sell-outer" style=""><a href="<?php echo base_url(); ?>sell" class="sell-icon"></a><a href="<?php echo base_url(); ?>sell" class="sell-text">Verkaufen</a></div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </header>

	<main class="outer">
