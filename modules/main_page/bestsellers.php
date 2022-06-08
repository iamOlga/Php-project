<!-- <link rel="stylesheet" href="../../css/style_main-bestsellers.css"> -->

<div class="container">
    <h3 class="title_h3" style="margin-top:100px;">Бестселлеры</h3>
    <div class="products">
        

        <?php
            $bestsellers_info = getBestsellersInfo($mysqli);
            foreach ($bestsellers_info as $product) : 
        ?>
            <div class="product">
                <img class="product_img" src="<?=$product["image"]?>" alt="">
                <p class="product_name"><?=$product["product_name"]?></p>
                <p class="product_price">$<?=$product["price"]?></p>
            </div>
            <?php 
            endforeach;
        ?>
        
        </div >
</div>