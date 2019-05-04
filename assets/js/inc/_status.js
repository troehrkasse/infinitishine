/**
 * Check order status via api
 */
// TODO pass as arg
const controller_url = 'https://infinitishine.com/wp-json/status';

jQuery('document').ready(function($){
    $('#order-status-button').click(function(){
        let orderNumber = parseInt($('#order-status-input').val(), 10);
        if(!isNaN(orderNumber)){
            jQuery.get(controller_url + '/status?order_number=' + orderNumber, function (response) {
                $('#order-status-output').html(response);
            });
        }
        else{
            alert('Please enter a valid order number');
        }



    });

});