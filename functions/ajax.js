function search1(){
    let msg = $('#form_search').serialize();
    $.ajax({
        type: 'POST',
        url: 'search.php',
        data: msg,
        success: function(data){
            $('#container_products').remove();
            $('#results').html(data);},
        error: function(xhr, str){
            alert("Возникла ошибка: " + xhr.responseCode);
        }
    })
}

function bag_view(){
    let msg = $('#form_bag').serialize();
    $.ajax({
        type: 'POST',
        url: 'bag.php',
        data: msg,
        success: function(data){
            $('#bag_list').remove();
            $('#results').html(data);},
        error: function(xhr, str){
            alert("Возникла ошибка: " + xhr.responseCode);
        }
    })
}


