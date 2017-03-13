<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA /public_html/varien (http://www./public_html/varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
      
// require "../app/Mage.php";


// DebugBreak();
//header('Content-Type: text/xml');
error_reporting(E_ALL);
  
  define('MAGENTO', realpath(dirname(__FILE__)));
  require_once MAGENTO . '/app/Mage.php';

  umask(0);
  Mage::app('base',"website"); 

  //$model = Mage::getModel('sitemap/sitemap');
  //$xmls  = $model -> generateproductXml();

 
              
             
  
  
    /*$currentCategory = Mage::registry('current_category');        
  
    $sub_cat = explode(",",$currentCategory->getChildren());*/
      //DebugBreak();
    $collection = Mage::getModel("catalog/category")->getCollection()
                  ->addAttributeToSelect(array('url','name','id','description','image','meta_title','meta_keywords','meta_description'))  
                  ->addAttributeToFilter('is_active',1)
                  ->addAttributeToFilter('parent_id',2)
                  ->setOrder("name","asc");

     foreach($collection as $category1) 
     {
         
         $name1 = "Dissolution Accessories >>".$category1->getName();
         $desc1 = $category1->getDescription();
         $image1 = $category1->getImage();
         $tile1 = $category1->getMetaTitle();
         $keyword1 = $category1->getMetaKeywords();
         $mdescr1 = str_replace(",","#########",$category1->getMetaDescription()); 
         
         $id1 = "179 >>".$category1->getId();
         
            $handleWrite = fopen("cat_id.csv", "a");
              $list = array ("$id1,$name1,$desc1,$image1,$tile1,$keyword1,$mdescr1"); 
              foreach ($list as $line) 
              {
                fputcsv($handleWrite, split(',', $line));
              }  
             fclose($handleWrite); 
             
             
             
         $sub_cat = explode(",",$category1->getChildren());   
         //DebugBreak();
         if($category1->getChildrenCount() > 0)
         {
                 $collection1 = Mage::getModel("catalog/category")->getCollection()
                                  ->addAttributeToSelect(array('url','name','id','description','image','meta_title','meta_keywords','meta_description'))  
                                  ->addAttributeToFilter('is_active',1)
                                  ->addAttributeToFilter('parent_id',$category1->getId())
                                  ->setOrder("name","asc");

                   foreach($collection1 as $category2) 
                   {
                         $name2 = $name1.">>".$category2->getName();
                         $id2   = $id1.">>".$category2->getId();
                         
                         $desc2     = $category2->getDescription();
                         $image2    = $category2->getImage();
                         $tile2     = $category2->getMetaTitle();
                         $keyword2  = $category2->getMetaKeywords();
                         $mdescr2   = str_replace(",","#########",$category2->getMetaDescription());
         
                         
                           $handleWrite = fopen("cat_id.csv", "a");
                              $list = array ("$id2,$name2,$desc2,$image2,$tile2,$keyword2,$mdescr2"); 
                              foreach ($list as $line) 
                              {
                                fputcsv($handleWrite, split(',', $line));
                              }  
                             fclose($handleWrite); 
                             
                             
                         $sub_cat = explode(",",$category2->getChildren());   
                         
                         if($category2->getChildrenCount() > 0)
                         {
                                $collection2 = Mage::getModel("catalog/category")->getCollection()
                                                  ->addAttributeToSelect(array('url','name','id','description','image','meta_title','meta_keywords','meta_description'))  
                                                  ->addAttributeToFilter('is_active',1)
                                                  ->addAttributeToFilter('parent_id',$category2->getId())
                                                  ->setOrder("name","asc");  
                                foreach($collection2 as $category3) 
                               {
                                     $name3 = $name2.">>".$category3->getName();
                                     $id3   = $id2.">>".$category3->getId();
                                     
                                     $desc3     = $category3->getDescription();
                                     $image3    = $category3->getImage();
                                     $tile3     = $category3->getMetaTitle();
                                     $keyword3  = $category3->getMetaKeywords();
                                     $mdescr3   = str_replace(",","#########",$category3->getMetaDescription());
                         
                                     
                                     $handleWrite = fopen("cat_id.csv", "a");
                                      $list = array ("$id3,$name3,$desc3,$image3,$tile3,$keyword3,$mdescr3"); 
                                      foreach ($list as $line) 
                                      {
                                        fputcsv($handleWrite, split(',', $line));
                                      }  
                                     fclose($handleWrite); 
                                         
                                     $sub_cat = explode(",",$category3->getChildren());   
                                     
                                     if($category3->getChildrenCount() > 0)
                                     {
                                          $collection3 = Mage::getModel("catalog/category")->getCollection()
                                                              ->addAttributeToSelect(array('url','name','id','description','image','meta_title','meta_keywords','meta_description'))  
                                                              ->addAttributeToFilter('is_active',1)
                                                              ->addAttributeToFilter('parent_id',$category3->getId())
                                                              ->setOrder("name","asc");
                                            foreach($collection3 as $category4) 
                                           {      
                                                 $name4 = $name3.">>".$category4->getName();
                                                 $id4   = $id3.">>".$category4->getId();
                                                 $sub_cat = explode(",",$category4->getChildren());   
                                                 
                                                 
                                                  $desc4     = $category4->getDescription();
                                                 $image4    = $category4->getImage();
                                                 $tile4     = $category4->getMetaTitle();
                                                 $keyword4  = $category4->getMetaKeywords();
                                                 $mdescr4   = str_replace(",","#########",$category4->getMetaDescription());
                                     
                                     
                                                  if($category4->getChildrenCount() > 0)
                                                  {
                                                           $handleWrite = fopen("/public_html/cat_id.csv", "a");
                                                          $list = array ("$id4,$name4,$desc4,$image4,$tile4,$keyword4,$mdescr4"); 
                                                          foreach ($list as $line) 
                                                          {
                                                            fputcsv($handleWrite, split(',', $line));
                                                          }  
                                                         fclose($handleWrite);
                                                  } 
                                                  else{
                                                      $handleWrite = fopen("cat_id.csv", "a");
                                                      $list = array ("$id4,$name4"); 
                                                      foreach ($list as $line) 
                                                      {
                                                        fputcsv($handleWrite, split(',', $line));
                                                      }  
                                                     fclose($handleWrite); 
                                                 }
                                           }
                                         
                                     }
                                      
                               }
                         }
                        
                   }                                   
                  
                  
                  
         }
         
     } 

?>