<?php include('include/header.php'); ?>



<div class="container pagebg page-sell-product" id="ProductCTRL" ng-controller="ProductCTRL">    

    <div class="row">        

        <div class="col-md-2">        

        </div>        

        <div class="col-md-8">            

            <div class="whitebg-page col-md-12">                

                <div class="col-md-1"></div>               

                <div class="col-md-10 sell-product">                    

                    <div class="col-md-12 text-center">

                        <div class="heading-form">Verkaufen</div>

                    </div>                    

                    <form method="post"  ng-submit="CreateItem(ItemSell);">                        



                        <div class="col-md-12">                            

                            <label for="#field-product"></label>                            

                            <input type="text" ng-model="ItemSell.title" name="field-product" id="field-product" placeholder="Produkt Name">                        

                        </div> 



                        <div class="col-md-12">                            

                            <label for="#field-description"></label>                            

                            <textarea ng-model="ItemSell.description" name="field-description" id="field-description" placeholder="Produktbeschreibung"></textarea>                        

                        </div>                        



                        <div class="col-md-12">                            

                            <label for="#field-category"></label>                            

                            <select name="field-category" id="field-category"  placeholder="Product Category"

                                    ng-model="ItemSell.category_id" >

                                <option value="">Kategorie wählen</option>

                                <?php

                                if(!empty($categoryList)){

                                    foreach($categoryList as $category){

                                        echo '<option value="'.$category['category_id'].'">'.$category['category_name'].'</option>';

                                    }

                                }

                                ?>

                                

                            </select>

                        </div>



                        <div class="col-md-12 price-sec">                            

                            <label for="#field-price"></label>                            

                            <span class="type-of-crncy">

                                <select name="currency-type" ng-model="ItemSell.currency">

                                    <option value="CHF">CHF</option>

                                    <option value="EURO">EURO</option>

                                </select>

                            </span>	

                            <span class="value-of-crncy">

                                <input type="text" ng-model="ItemSell.price" name="field-price" id="field-price" placeholder="Preis">

                            </span>

                        </div>



                        <div class="col-md-12">                            

                            <label for="#field-address"></label>                            

                            <input type="text" ng-model="ItemSell.location" name="field-address" id="ProductAddress" placeholder="Adresse" />

                        </div>	



<!--                        <div class="col-md-12 pro-img-label"><label>Featured Image</label></div>

                        

                        <div class="col-md-12 w-featured-image" ng-init="InitializeFineUpload('upload-cover');">

                            

                            <div class="img-box-outer">                            

                                <a id="upload-cover" class="profiler_img">Upload Image</a>

                                <span ng-bind="uploadMessage1"></span>

                                <img ng-src="{{ItemSell.cover_image_url}}" class="uploaded-image" />

                            </div>



                        </div>	  						-->



                        <div class="col-md-12 pro-img-label"><label>Bilder </label></div>

                        <div class="col-md-12 w-pro-glry-image" >

                            

                            <div class="img-box-outer" ng-repeat="image in ItemSell.item_images"> 

                                <a ng-click="RemoveImage($index)" style="background: #000;padding: 0 3px;">X</a>

                                <img ng-src="{{image.image_url}}" />

                            </div>

                            

                            <div ng-repeat="EmptyImg in EmptyItemImg" >

                                <a id="upload-images{{$index}}" class="profiler_img img-box-outer" ng-init="InitializeFineUpload('upload-images', $index);">Upload Image</a>

                            </div>

                            

                            <span ng-bind="uploadMessage2"></span>

                            

                            <!-- <div class="img-box-outer">                            

                                <input type="file" name="profile" id="pro-pic6" class="img-box">

                            </div> -->

                        </div>	                        



                        <div class="col-md-12 pro-img-label"><label>Teilen und schneller verkaufen</label></div>

                        <div class="share col-md-12">                            

                            <input type="checkbox" name="facebook" ng-model="ItemSell.fb_share" value="facebook"> <img src="<?php echo base_url('assets/images/facebook1.png') ?>" >

                            <br/>

<!--                            <br/>

                            <input type="checkbox" name="twitter" value="twitter"> <img src="<?php echo base_url('assets/images/twitter1.png') ?>" >

                            <br/>

                            <br/>

                            <input type="checkbox" name="insta" value="insta"> <img src="<?php echo base_url('assets/images/instagram1.png') ?>" >-->

                        </div>		



                        <div class="submit col-md-12">                            

                            <button type="submit" id="login-submit" class="btn-loadable" > Angebot einstellen <span class="loader"></span></button>                        

                        </div>



                    </form>                

                </div> 

                <div class="col-md-1"></div>           

            </div>	        

        </div>        

        <div class="col-md-2"></div>	    

    </div>

</div>



<?php include('include/footer.php'); ?>



<script>

jQuery(document).ready(function() {

    LocationInitialize('ProductAddress');

});

</script>