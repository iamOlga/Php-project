    <link rel="stylesheet" href="../../css/style_reviews.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="../../functions/ajax.js"></script>

    <?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
        $query = "SELECT * FROM reviews inner join users on users.user_id=reviews.user_id";
        $reviews = getAllProducts($mysqli, $query);  
        

        
    ?>

    <div class="div_reviews">
        <img src="../../images/reviews_img.png" alt="">
        <div class="container_reviews">
            <div class="cont">
                <h3 class="title_h3 h3_reviews">Отзывы</h3>

                <!-- <div id="results_reviews" class="reviews"></div> -->

                <div class="reviews" id="all_reviews">
                    <?php 
                        foreach ($reviews as $review) :
                    ?>
                        <div class="review">
                            <div class="img"><span><?=strtoupper(substr($review["user_name"], 0, 1))?></span></div>
                            <div class="review_info">
                                <p class="review_name"><?=strtoupper(substr($review["user_name"], 0, 1)).substr($review["user_name"], 1)?></p>
                                <p class="review_text">«<?=$review["review"]?>»</p>
                            </div>
                        </div>

                    <?php 
                        endforeach;
                    ?>
                </div>


            </div>

            <form class="add_review_div" id="add_review_form" action="" method="post">

                <?php
                    if (!empty($_SESSION['user_name'])) {
                ?>
                    <div class="review add_review">
                        <div class="img">
                            <span><?=strtoupper(substr($_SESSION['user_name'], 0, 1))?></span>
                        </div>
                        <div class="review_info">
                            <p class="review_name"><?=strtoupper(substr($_SESSION['user_name'], 0, 1)).substr($_SESSION['user_name'], 1)?></p>
                            <textarea name="review_add" id="review_add" placeholder="Введите отзыв" type="text" maxlength="200"></textarea>
                        </div>
                    </div>
                    <input type="submit" name="add_review_button" class="black_button black_button_review add_review_button" value="оставить отзыв">
                <?php
                    }
                    else{
                ?>  
                    <div>
                        <a href="modules/account_page/account_page.php" class="button" >зарегистрируйтесь, чтобы оставлять отзывы</a>
                    </div>
                <?php
                    }
                ?>
            </form>

            <script>   
                $(document).ready(function(){   
                    $('#add_review_form').submit(function(){   
                        $.ajax({   
                            type: "POST",   
                            url: "modules/main_page/add_review.php",   
                            data: $('#add_review_form').serialize(),  
                            success: function(html){   
                                $("#all_reviews").html(html); 
                                $("#review_add").val(" ");
                               
                            }   
                        });   
                    return false;   
                    });   
                             
                });   
            </script>  
        </div>
    </div>