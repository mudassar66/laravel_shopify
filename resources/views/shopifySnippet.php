<?php /** @var string $secret */?>

{% if template == 'product' %}
{% if product.tags contains 'PWYW' %}

<div style="display:none">
    <form method="post" name="addToCartPWYW" id="addToCartPWYW">
        {% if product.images.size > 0 %}
        {% assign featured_image = product.selected_or_first_available_variant.featured_image | default:
        product.featured_image %}
        <input type="hidden" name="productImagePWYW" id="productImagePWYW"
               value="{{ featured_image | img_url: '1024x1024' }}">
        {% else %}
        <input type="hidden" name="productImagePWYW" id="productImagePWYW" value="{{ 'No_Image.png' | asset_url }}">
        {% endif %}

        <input type="hidden" name="productNamePWYW" id="productNamePWYW" value="{{ product.title }}">
        <input type="hidden" name="productIdPWYW" id="productIdPWYW"
               value="{{ product.selected_or_first_available_variant }}">

        <div class="product-description rte" itemprop="description">{{ product.description }}</div>
        <input type="number" name="productPricePWYW" id="productPricePWYW" min="0"
               onkeypress="return isNumberPWYW(event)"
               placeholder="Suggested Price {{ product.price | money_without_currency | remove: '.00' | remove: ',00' }}">
        <input type="button" id="addToCartButtonPWYW" class="btn" name="add"
               value="{{ 'products.product.add_to_cart' | t }}"/>
    </form>
</div>

<script type="text/javascript">
    function isNumberPWYW(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }

    $(document).ready(function () {
        var form = $("form[action='/cart/add']"),
            formCart = $("form[name='addToCartPWYW']");

        if (form.length > 0 && formCart.length > 0) {
            var button = form.find("input[type='submit']");

            if (button.length <= 0) {
                button = form.find("button[type='submit']");
            }

            if (button.length > 0) {
                form.after(formCart);
                form.hide();
            }

            // get default parameter
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var index = 0; index < vars.length; index++) {
                var pair = vars[index].split("=");
                if (pair[0] === "default") {
                    $("#productPricePWYW").val(parseInt(pair[1]))
                }
            }
        }
        function addItemPWYW(form_id) {
            $.ajax({
                type: "POST",
                url: "/cart/add.js",
                dataType: "json",
                data: {"id": form_id, "quantity": 1},
                success: Shopify.onSuccess,
                error: Shopify.onError
            });
        }

        $("#addToCartButtonPWYW").click(function () {
            if ($("#productPricePWYW").val() != "") {
                $(this).prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "<?= Request::fullUrl() ?>/api.php?action=createProduct&token=<?= $secret ?>",
                    crossDomain: true,
                    data: $("#addToCartPWYW").serialize(),
                    dataType: "json",
                    success: function (responseData, textStatus, jqXHR) {
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

        Shopify.onSuccess = function () {
            var elem = $("#addToCartButtonPWYW");
            elem.removeAttr("disabled");
            document.location.href = "/cart";
        };

        Shopify.onError = function (XMLHttpRequest, textStatus) {
            // Shopify returns a description of the error in XMLHttpRequest.responseText.
            // It is JSON.
            // Example: {"description":"The product "Amelia - Small" is already sold out.","status":500,"message":"Cart Error"}
            var data = eval("(" + XMLHttpRequest.responseText + ")");
            if (!!data.message) {
                alert(data.message + "(" + data.status + "): " + data.description);
            }
            else {
                alert("Error : " + Shopify.fullMessagesFromErrors(data).join("; ") + ".");
            }
            $("#addToCartButtonPWYW").removeAttr("disabled");
        };
    })
</script>
{% endif %}
{% endif %}