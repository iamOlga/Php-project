$('.count_minus').on('click', function count_minus() {
    var messages = $(this).parent().find('.count')[0].innerText;
    console.log(messages);
    if($(this).parent().find('.count')[0].innerText > 0){
    $(this).parent().find('.count')[0].innerText = Number(messages) - 1; 
    } else {
        $(this).parent().find('.count')[0].innerText = 0;
    }

    /* $.ajax({
        type: 'POST',
        url: 'favorite.php',
        data: messages,
        success: $.get('favorite.php', {message: messages, val:val}, function(data) {
            // alert('записан: '+data);
        })
    });  */
});