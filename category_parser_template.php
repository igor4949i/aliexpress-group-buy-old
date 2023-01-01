<?php
set_time_limit(0);
require('./PHPDebug.php');
require('./phpQuery-onefile.php');

// PHPDebug.php
// $debug = new PHPDebug();
// echo $debug->debug("Start");
// $start = microtime(true);



$url_ali = 'html_files/html_1/Group buy.html';
$html_ali = file_get_contents($url_ali);
$doc =  phpQuery::newDocument($html_ali);

$list_products = $doc -> find('.ProductList--productListWrapper--1swWq9C')->html();
echo $list_products . '</br>';

$json_reg = '/itemid&quot;:&quot;.*&quot;,&quot;stock&quot;/';
preg_match_all($json_reg, $list_products, $json_array, PREG_SET_ORDER, 0);
$json_list_url = [];

for ($i=0; $i < count($json_array); $i++) {
    // $json_array[$i][0] = preg_replace('/&q;original&q;:{&q;url&q;:&q;/', '', $json_array[$i][0]);
    // $json_array[$i][0] = preg_replace('/&q;/', '', $json_array[$i][0]);
    // array_push($json_list_url, $json_array[$i][0]);
    echo 'test' . '</br>';
}


// echo $product_array[0][0] . '</br>';






// category_url_product($url_category);

// // run parse each product
// for ($i = 0; $i < 10; $i++) { // count($url_product_array)
//   product_parsing($url_product_array[$i], $i+1);
// }

// search URLs products on page category
function category_url_product($url_category) {
  global $url_product_array;
  $html_category = file_get_contents($url_category);
  $doc_category = phpQuery::newDocument($html_category);

  foreach ($doc_category->find('.x-catalog-gallery .x-gallery-tile__name.ek-link.ek-link_style_multi-line') as $item) {
    $item = pq($item);
    $url_product = $item->attr('href');
    array_push($url_product_array, $url_product);
  }

  $next = $doc_category->find('.x-pager__content .x-pager__item_state_selected')->next()->attr('href');
  // check the next page
  if ($next) {
    $url_category = 'https://prom.ua'.$next;
    // category_url_product($url_category);
  }
}


// parse each product
function product_parsing($url_item, $number_product) {
  $html = file_get_contents($url_item);
  $doc = phpQuery::newDocument($html);
  //  name_product
  $name_product = $doc->find('.x-product-info__content .x-title')->text();
  $number_product = $number_product;
  // url product
  $url = $url_item;

  // price
  $price = $doc->find('.x-product-price .x-product-price__value .x-hidden')->text();
  $price = preg_replace('/UAH/', '', $price); // trim currency symbol
  $price = preg_replace('/[^x\d|*\.]/', '', $price); // trim spaces

  // // old_price
  // $old_price = $doc->find('.x-product-price .x-product-price__discount .x-product-price__discount-value')->attr('data-qaprice');
  // $old_price = preg_replace('/₴/', '', $old_price);
  // $old_price = preg_replace('/[^x\d|*\.]/', '', $old_price);

  // // sku
  // $sku = $doc->find('.x-product-info__identity-item span[data-qaid="product-sku"]')->text();

  // // available
  // $available = $doc->find('.x-product-presence')->text();

  // // desc_full
  // $desc_full = $doc->find('.x-user-content')->html();
  // $desc_full = preg_replace('/\sstyle=".*?"/', '', $desc_full); // trim styles
  // $desc_full = preg_replace('/\sclass=".*?"/', '', $desc_full); // trim classes


  // // category_list
  // $category = $doc->find('.x-breadcrumb .x-breadcrumb__item a');
  // $category_list = [];
  // foreach($category as $item) {
  //   $item = pq($item);
  //   $item = trim($item->text());
  //   array_push($category_list, $item);
  // }
  // array_shift($category_list);
  // array_pop($category_list);

  // $category_breadcrumbs_last = $category_list[array_key_last($category_list)];
  // $category_list = implode('>', $category_list);

  // // image
  // $json_template = $doc->find('.x-product-info__images div[data-bazooka="ProductGallery"]')->attr('data-bazooka-props');
  // $json_reg = '/"image_url_100x100".+?".+?"/';
  // preg_match_all($json_reg, $json_template, $json_array, PREG_SET_ORDER, 0);
  // $json_list_url_img = [];
  // for ($i = 0; $i < count($json_array); $i++) {
  //   $json_array[$i][0] = preg_replace('/"image_url_100x100".+?"/', '', $json_array[$i][0]);
  //   $json_array[$i][0] = preg_replace('/"/', '', $json_array[$i][0]);
  //   $json_array[$i][0] = preg_replace('/_w.*?_h.*?_/', '_', $json_array[$i][0]);
  //   array_push($json_list_url_img, $json_array[$i][0]);
  // }
  // $main_image_url = $json_list_url_img[0];
  // $all_images_url = implode(',', $json_list_url_img);
  // array_shift($json_list_url_img);
  // $additional_images_url = implode(',', $json_list_url_img);

  // // $characteristics
  // $characteristics_data = $doc->find('.x-product-attr');
  // pq($characteristics_data)->find('.x-title')->remove();
  // pq($characteristics_data)->find('.x-product-attr__more-link')->remove();
  // $characteristics = $characteristics_data->html();
  // $characteristics = preg_replace('/\shref=".*?"/', ' href="#"', $characteristics);

  echo '<tr>';
  echo '<td class="number_product">'.$number_product.'</td>';
  echo '<td class="name_product">'.$name_product.'</td>';
  echo '<td class="url">'.$url.'</td>';
  echo '<td class="price">'.$price.'</td>';
  // echo '<td class="old_price">'.$old_price.'</td>';
  // echo '<td class="sku">'.$sku.'</td>';
  // echo '<td class="available">'.$available.'</td>';
  // echo '<td class="desc_full">'.$desc_full.'</td>';
  // echo '<td class="category_list">'.$category_list.'</td>';
  // echo '<td class="category_breadcrumbs_last">'.$category_breadcrumbs_last.'</td>';
  // echo '<td class="_main_image_url">'.$main_image_url.'</td>';
  // echo '<td class="main_image_url">'.$additional_images_url.'</td>';
  // echo '<td class="all_images_url">'.$all_images_url.'</td>';
  // echo '<td class="characteristics">'.$characteristics.'</td>';
  echo '</tr>';

}
