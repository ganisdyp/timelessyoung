<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\BrandSearch;
use common\models\ProductTypeSearch;
use common\models\BlogtypeSearch;

class DC extends Model {
  public static function get_menu() {
    $menu = array(
      array(
        'text' => Yii::t('common', 'Home'),
        'link' => Yii::$app->request->BaseUrl.'/site/index',
        'pagename' => 'index',
      ),
      array(
        'text' => Yii::t('common', 'About'),
        'link' => Yii::$app->request->BaseUrl.'/site/about',
        'pagename' => 'about',
      ),
      array(
        'text' => Yii::t('common', 'Services'),
        'link' => Yii::$app->request->BaseUrl.'/site/services',
        'pagename' => 'services',
      ),
      array(
        'text' => Yii::t('common', 'Product'),
        'link' => Yii::$app->request->BaseUrl.'/site/product-category',
        'pagename' => 'product',
        // 'subpage' => self::get_menu_product(),
      ),
      array(
        'text' => Yii::t('common', 'Blogs'),
        'link' => Yii::$app->request->BaseUrl.'/site/blog-category',
        'pagename' => 'blog',
        // 'subpage' => self::get_menu_blogs(),
      ),
      array(
        'text' => Yii::t('common', 'Contact'),
        'link' => Yii::$app->request->BaseUrl.'/site/contact',
        'pagename' => 'contact',
      )
    );

      return $menu;
  }

  public static function get_menu_brands() {
      $searchModel = new BrandSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $brands = $dataProvider->query->where(['<>','code', '--'])->orderBy(['code'=>SORT_ASC])->all();
      $menu = array();
      foreach($brands as $brand){
          $arr_detail = array(
              'id' => $brand->id,
              'text' => $brand->name,
              'code' => $brand->code,
              'link' => Yii::$app->request->BaseUrl.'/site/product-category?id='.$brand->id,
              'main_photo' => $brand->main_photo,
              'pagename' => 'brand'
          );
          array_push($menu,$arr_detail);
      }

      return $menu;
  }

  public static function get_menu_product() {
      $searchModel = new ProductTypeSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $product_category = $dataProvider->query->all();
      $menu = array();
      foreach($product_category as $category){
          $arr_detail = array(
              'text' => $category->name,
              'link' => Yii::$app->request->BaseUrl.'/site/product-list?id='.$category->id,
              'main_photo' => $category->main_photo,
              'pagename' => 'product'
          );
          array_push($menu,$arr_detail);
      }
      
      return $menu;
    }


}
?>