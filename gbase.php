<?php
define('SAVE_FEED_LOCATION','export/google_base_feed.csv');//you can set a new folder and file if you want, don't forget to chmod the folder to 777

// make sure we don't time out
set_time_limit(0);	

require_once 'app/Mage.php';
Mage::app('default');

try{
    //    $handleWrite = fopen("cidnew.csv", "a");

    /*$list = array ("$categorystring,$newid");
    foreach ($list as $line)
    {
    fputcsv($handleWrite, split(',', $line));
    }
    fclose($handleWrite);*/

    $count = 4;
    $handle = fopen("google_base_feed".$count.".csv", 'w');


    $heading = array('id','title','UNIQUE INTERNAL CODE','link','image_link','price',"condition",'brand','CATEGORY','description');
    //$feed_line=implode("\t", $heading)."\r\n";
    fputcsv($handle, $heading);
    //fwrite($handle, $feed_line);

    //---------------------- GET THE PRODUCTS	
    $products = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('status', 1)
                ->addAttributeToFilter('visibility', array("neq"=>1))
                ->addAttributeToSelect('*')
                ->setPageSize(400)
                ->setCurPage($count);
    $prodIds=$products->getAllIds();

    //echo 'Product filter: '.memory_get_usage(false).'<br>';
    //flush();

    $product = Mage::getModel('catalog/product');
    foreach($products as $productId) {
        //echo '. ';
        //flush();
        //echo 'Loop start: '.memory_get_usage(false).'<br>';
        //flush();

        //$product = Mage::getModel('catalog/product');
        $product->load($productId->getId());

        $product_data = array();	
        $product_data['sku']=$product->getSku();	
        $product_data['title']=$product->getName();
        $product_data['title']=preg_replace(array("/\n/","/\t/","/\r/"),array("","",""),addslashes($product->getName()));
        $product_data['UNIQUE INTERNAL CODE']=$product->getSku();
        
        $product_data['link']=$product->getProductUrl();
        $product_data['image_link']=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product/'.$product->getImage();
        $product_data['price']=$product->getFinalPrice();
        $product_data['condition']="New";
        //$product_data['brand']="";    
        $product_data['brand']=$product->getResource()->getAttribute('manufacturer')->getFrontend()->getValue($product);	
        $product_data['CATEGORY']='';		

        //echo 'Product load: '.memory_get_usage(false).'<br>';
        //flush();		

        //get the product categories            		
        foreach($product->getCategoryIds() as $_categoryId){
            $category = Mage::getModel('catalog/category')->load($_categoryId);
            $product_data['CATEGORY']= addslashes($category->getName().',');
        }
        $product_data['CATEGORY']=rtrim($product_data['CATEGORY'],', ');	
        $product_data['CATEGORY'] = "'".preg_replace(array("/\n/","/\t/","/\r/"),array("","",""),$product_data['CATEGORY'])."'";    
        //roduct_data['CATEGORY'] = "";  ///  
        //$product_data['description'] = "'".preg_replace(array("/\n/","/\t/","/\r/"),array("","",""),htmlspecialchars(trim(strip_tags($product->getDescription()))))."'";	
        //$product_data['description']= addslashes(str_replace("\n","",str_replace("\r","",str_replace("\r\n","",htmlspecialchars(trim(strip_tags($product->getDescription())))))));
        $product_data['description']= "";
        //echo 'Category load: '.(memory_get_usage(false)).'<br>';			

        //sanitize data	
       /* foreach($product_data as $k=>$val){
            $bad=array('"',"\r\n","\n","\r","\t");
            $good=array(""," "," "," ","");
            $product_data[$k] = '"'.str_replace($bad,$good,$val).'"';
        }*/


        //  $feed_line = implode("\t", $product_data)."\r\n";
        //fwrite($handle, $feed_line);
        fputcsv($handle,  $product_data);
        fflush($handle);

        //echo 'Loop end: '.memory_get_usage(false).'<br>';
        //flush();
    }

    //---------------------- WRITE THE FEED	
    fclose($handle);

}
catch(Exception $e){
    die($e->getMessage());
}

