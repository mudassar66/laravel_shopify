<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Client instance, that used for accessing shopify
     * @var \app\Services\shopify\Client
     */
    protected $client;

    public function __construct(\App\Services\shopify\Client $client)
    {
        $this->client = $client;
    }

    public function welcome()
    {
        if (isset($_GET['code'])) {
            $_SESSION['token'] = $this->client->getAccessToken($_GET['code']);

            $qry = "SELECT id,shop_token,shop_name,shop_secret,shop_url FROM shops WHERE shop_url = '" . $_GET['shop'] .
                "' OR shop_domain = '" . $_GET['shop'] . "'";
            $query = mysql_query($qry, $link);

            if (mysql_num_rows($query) > 0) {
                $shopDetail = mysql_fetch_array($query);
                $_SESSION['token'] = $shopDetail['shop_token'];
                $_SESSION['shop_domain'] = $shopDetail['shop_url'];
                $_SESSION['shop_name'] = $shopDetail['shop_name'];
                $_SESSION['shop_secret'] = $shopDetail['shop_secret'];
                $_SESSION['shop_id'] = $shopDetail['id'];
                header("Location: " . BASE_PATH . "configurations.php");
                exit;
            } else {
                $this->client->setToken($_SESSION['token']);
                $shop = $this->client->call('GET', '/admin/shop.json', array('published_status' => 'published'));
                $themes = $this->client->call('GET', '/admin/themes.json', array('published_status' => 'published'));

                $active_theme_id = "";
                $active_theme_mobile_id = "";

                foreach ($themes as $theme) {
                    if ($theme['role'] == "main") {
                        $active_theme_id = $theme['id'];
                    }
                    if ($theme['role'] == "mobile") {
                        $active_theme_mobile_id = $theme['id'];
                    }
                }

                if ($active_theme_mobile_id == "") {
                    $active_theme_mobile_id = $active_theme_id;
                }

                $postArray = array();

                $shopSecret = md5(uniqid(rand(), true));

                $postArray['asset'] = array(
                    "key" => "snippets/pwyw.liquid",
                    "value" =>
                        '{% if template == \'product\' %}
					{% if product.tags contains \'PWYW\' %}

						<div style="display:none">
						<form method="post" name="addToCartPWYW" id="addToCartPWYW">
						  	{% if product.images.size > 0 %}
						  		{% assign featured_image = product.selected_or_first_available_variant.featured_image | default: product.featured_image %}
						  		<input type="hidden" name="productImagePWYW" id="productImagePWYW" value="{{ featured_image | img_url: \'1024x1024\' }}">
						  	{% else %}
						  		<input type="hidden" name="productImagePWYW" id="productImagePWYW" value="{{ \'No_Image.png\' | asset_url }}">
						  	{% endif %}

						  	<input type="hidden" name="productNamePWYW" id="productNamePWYW" value="{{ product.title }}">
						  	<input type="hidden" name="productIdPWYW" id="productIdPWYW" value="{{ product.selected_or_first_available_variant }}">
						  	<div class="product-description rte" itemprop="description">{{ product.description }}</div>
						  	<input type="number" name="productPricePWYW" id="productPricePWYW" min="0" onkeypress="return isNumberPWYW(event)" placeholder="Suggested Price {{ product.price | money_without_currency | remove: \'.00\' | remove: \',00\' }}">
						  	<input type="button" id="addToCartButtonPWYW" class="btn" name="add" value="{{ \'products.product.add_to_cart\' | t }}" />
						</form>
						</div>

						<script type="text/javascript">
						  	function isNumberPWYW(evt) {
						    	evt = (evt) ? evt : window.event;
						    	var charCode = (evt.which) ? evt.which : evt.keyCode;
						    	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
						        	return false;
						    	}
						    	return true;
							}

							$(document).ready(function(){
							  	if($("form[action=\'/cart/add\']").length > 0 && $("form[name=\'addToCartPWYW\']").length > 0) {
							    	var form = $("form[action=\'/cart/add\']");

							    	if(form.find("input[type=\'submit\']").length > 0) {
							       		var button = form.find("input[type=\'submit\']");
							       		form.after($("form[name=\'addToCartPWYW\']"));
							       		form.hide();
							    	}
									if(form.find("button[type=\'submit\']").length > 0) {
							       		var button = form.find("button[type=\'submit\']");
							       		form.after($("form[name=\'addToCartPWYW\']"));
							       		form.hide();
							    	}
							    	// get default parameter
									var query = window.location.search.substring(1);
									var vars = query.split("&");
									for (var index = 0; index < vars.length; index++) {
										var pair = vars[index].split("=");
										if(pair[0] === "default") {
											$("#productPricePWYW").val(parseInt(pair[1]))
										}
									}
							  	}
							   	function addItemPWYW(form_id) {
							      	$.ajax({
							        	type: "POST",
							        	url: "/cart/add.js",
							        	dataType: "json",
							        	data: { "id" :form_id,"quantity" :1},
							        	success: Shopify.onSuccess,
							        	error: Shopify.onError
							      	});
							   	}

							   	$( "#addToCartButtonPWYW" ).click(function() {
						     		if($("#productPricePWYW").val() != "") {
							     		$(this).prop("disabled", true);
							     		$.ajax({
											type: "POST",
											url: "' . BASE_PATH . 'api.php?action=createProduct&token=' . $shopSecret . '",
											crossDomain: true,
											data: $("#addToCartPWYW").serialize(),
											dataType: "json",
											success: function(responseData, textStatus, jqXHR) {
							    	              addItemPWYW(responseData);
											},
											error: function (responseData, textStatus, errorThrown) {
												console.log(responseData);
											}
										});
							        }
							     	else {
							       		alert("Please enter valid price or atleast 0");
							     	}
								});

							   	Shopify.onSuccess = function() {
							      	var elem = $("#addToCartButtonPWYW");
							      	elem.removeAttr("disabled");
							     	document.location.href="/cart";
							    };

							    Shopify.onError = function(XMLHttpRequest, textStatus) {
							      	// Shopify returns a description of the error in XMLHttpRequest.responseText.
							      	// It is JSON.
							      	// Example: {"description":"The product "Amelia - Small" is already sold out.","status":500,"message":"Cart Error"}
							      	var data = eval("(" + XMLHttpRequest.responseText + ")");
							      	if (!!data.message) {
							        	alert(data.message + "(" + data.status  + "): " + data.description);
							      	}
							      	else {
							        	alert("Error : " + Shopify.fullMessagesFromErrors(data).join("; ") + ".");
							      	}
							      	$("#addToCartButtonPWYW").removeAttr("disabled");
							    };
							})
						</script>
					{% endif %}
				{% endif %}'
                );

                $result = $this->client->call('PUT', '/admin/themes/' . $active_theme_id . '/assets.json', $postArray);


                $result = $this->client->call('GET',
                    '/admin/themes/' . $active_theme_id . '/assets.json?asset[key]=templates/product.liquid&theme_id=' .
                    $active_theme_id);

                if (!strstr($result['value'], "{% include 'pwyw' %}")) {
                    $result['value'] = $result['value'] . "{% include 'pwyw' %}";
                }

                $postArray['asset'] = array(
                    "key" => "templates/product.liquid",
                    "value" => $result['value']
                );

                $result = $this->client->call('PUT', '/admin/themes/' . $active_theme_id . '/assets.json', $postArray);

                mysql_query("INSERT INTO shops SET shop_owner = '" . $shop['shop_owner'] . "', shop_name = '" .
                    $shop['name'] . "', shop_token = '" . $_SESSION['token'] . "', shop_url = '" . $shop['domain'] .
                    "', shop_domain = '" . $shop['myshopify_domain'] . "',shop_country = '" . $shop['country_code'] .
                    "',shop_email = '" . $shop['email'] . "',shop_plan = '" . $shop['plan_name'] .
                    "',shop_currency = '" .
                    $shop['currency'] . "',shop_secret = '" . $shopSecret . "', province_code = '" .
                    $shop['province_code'] . "', city = '" . $shop['city'] . "', address1 = '" . $shop['address1'] .
                    "',active_theme_id = '" . $active_theme_id . "',active_theme_mobile_id = '" .
                    $active_theme_mobile_id .
                    "',join_datetime='" . date("Y-m-d H:i:s") . "'");

                $id = mysql_insert_id();

                $_SESSION['shop_domain'] = $shop['myshopify_domain'];
                $_SESSION['shop_name'] = $shop['name'];
                $_SESSION['shop_secret'] = $shopSecret;
                $_SESSION['shop_id'] = $id;

                header("Location: " . BASE_PATH . "configurations.php");
                exit;
            }
        } elseif (isset($_GET['hmac'])) {

            $qry = "SELECT id,shop_token,shop_name,shop_secret,shop_domain FROM shops WHERE shop_url = '" .
                $_GET['shop'] .
                "' OR shop_domain = '" . $_GET['shop'] . "'";
            $query = mysql_query($qry, $link);

            if (mysql_num_rows($query) > 0) {
                $shopDetail = mysql_fetch_array($query);

                $_SESSION['token'] = $shopDetail['shop_token'];
                $_SESSION['shop_secret'] = $shopDetail['shop_secret'];
                $_SESSION['shop_domain'] = $shopDetail['shop_domain'];
                $_SESSION['shop_name'] = $shopDetail['shop_name'];
                $_SESSION['shop_id'] = $shopDetail['id'];


                header("Location: " . BASE_PATH . "configurations.php");
                exit;
            } else {
                $pageURL = 'https://';
                /*
                if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
                    $pageURL .= "://";
                    */
                if ($_SERVER["SERVER_PORT"] != "80") {
                    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
                } else {
                    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
                }

                header("Location: " . $this->client->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
                exit;
            }
        } elseif (isset($_POST['shop'])) {
            $pageURL = 'https://';

            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            }

            header("Location: " . $this->client->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
            exit;
        }

        return view('welcome');
    }
}
