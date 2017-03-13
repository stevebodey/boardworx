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
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
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
                  ->addAttributeToSelect(array('url','name','id'))  
                  ->addAttributeToFilter('is_active',1)
                  ->addAttributeToFilter('parent_id',2)
                  ->setOrder("name","asc");

     foreach($collection as $category1) 
     {
         
         $name1 = $category1->getName();
         $id1 = $category1->getId();
         
         $handleWrite = fopen("cat_id.csv", "a");
              $list = array ("$id1,$name1"); 
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
                                  ->addAttributeToSelect(array('url','name','id'))  
                                  ->addAttributeToFilter('is_active',1)
                                  ->addAttributeToFilter('parent_id',$category1->getId())
                                  ->setOrder("name","asc");

                   foreach($collection1 as $category2) 
                   {
                         $name2 = $category2->getName();
                         $id2   = $category2->getId();
                         
                             $handleWrite = fopen("cat_id.csv", "a");
                              $list = array ("$id2,$name2"); 
                              foreach ($list as $line) 
                              {
                                fputcsv($handleWrite, split(',', $line));
                              }  
                             fclose($handleWrite); 
                             
                             
                         $sub_cat = explode(",",$category2->getChildren());   
                         
                         if($category2->getChildrenCount() > 0)
                         {
                                $collection2 = Mage::getModel("catalog/category")->getCollection()
                                                  ->addAttributeToSelect(array('url','name','id'))  
                                                  ->addAttributeToFilter('is_active',1)
                                                  ->addAttributeToFilter('parent_id',$category2->getId())
                                                  ->setOrder("name","asc");
                                foreach($collection2 as $category3) 
                               {
                                     $name3 = $category3->getName();
                                     $id3   = $category3->getId();
                                     
                                     $handleWrite = fopen("cat_id.csv", "a");
                                      $list = array ("$id3,$name3"); 
                                      foreach ($list as $line) 
                                      {
                                        fputcsv($handleWrite, split(',', $line));
                                      }  
                                     fclose($handleWrite); 
                                         
                                     $sub_cat = explode(",",$category3->getChildren());   
                                     
                                     if($category3->getChildrenCount() > 0)
                                     {
                                          $collection3 = Mage::getModel("catalog/category")->getCollection()
                                                              ->addAttributeToSelect(array('url','name','id','lavel'))  
                                                              ->addAttributeToFilter('is_active',1)
                                                              ->addAttributeToFilter('parent_id',$category3->getId())
                                                              ->setOrder("name","asc");
                                            foreach($collection3 as $category4) 
                                           {      
                                                 $name4 = $category4->getName();
                                                 $id4   = $category4->getId();
                                                 $sub_cat = explode(",",$category4->getChildren());   
                                                  if($category4->getChildrenCount() > 0)
                                                  {
                                                           $handleWrite = fopen("cat_id.csv", "a");
                                                          $list = array ("$id4,$name4"); 
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