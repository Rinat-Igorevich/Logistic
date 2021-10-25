let products = {

    changeCost: function () {
        if (Number($('#count').val()) < 0) {

            $('#count').val(0)
        } else if (Number($('#count').val()) > $('#onStock').val()) {
            alert('Вы пытаетесь заказать больше чем есть на складе')
            $('#count').val($('#onStock').val())
        } else if ($('#discount').val() > Number($('#count').val()) * Number($('#price').val()) ) {
            alert('Скидка превышает стоимость заказа!')
            $('#discount').val(0)
        }
        console.log($('#cost').val())
        $('#sum').val((Number($('#count').val()) * Number($('#price').val())))
        $('#cost').val(Number($('#sum').val()) - Number($('#discount').val()))

    },

    reset: function () {
        $('#createOrder')[0].reset()
        $('#status').prop('disabled', true)
        $('#submit').val('createOrder')
    },

    setStockAndPrice: function (e) {
        let id = e.target.value
        $('#count').val(0)

        let formData = new FormData();
        formData.append('id', id)
        formData.append('action', 'getProduct')

        $.ajax({
            url: '/',
            method: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,

            success: function (respond) {
                $('#onStock').val(respond.stock[0]['stock'])
                $('#price').val(respond.stock[0]['price'])
            }
        });
    }
}

let orders = {

    setOrderFields: function (orderID) {

        let formData = new FormData();
        formData.append('action', 'getOrders')
        formData.append('id', orderID)
        console.log(orderID)
        $.ajax({
            url: '/',
            method: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            success: function (respond) {
                let order = respond.orders[0]
                console.log(order)

                $('#orderID').val(order['id'])
                $('#customer').val(order['customer'])
                $('#phone').val(order['phone'])
                $('#product').val(order['product_id'])
                $('#count').val(order['count'])
                $('#price').val(order['price'])
                $('#sum').val(order['price'] * order['count'])
                $('#discount').val(order['discount'])
                $('#onStock').val(order['stock'])
                $('#cost').val(order['cost'])
                $('#status').prop('disabled', false)
                $('#status').val(order['status'])
                $('#user').val(order['user_id'])
                $('#type').val(order['type'])
            }
        });
    },

    createOrChangeOrder: function (orderID = null, action = 'createOrder') {
        // event.preventDefault()
        let formData = new FormData();
        console.log(this.checkForm())
        if (this.checkForm()) {
            formData.append('action', $('#submit').val())
            formData.append('orderID',  $('#orderID').val())
            formData.append('customer', $('#customer').val())
            formData.append('phone', $('#phone').val())
            formData.append('product', $('#product').val())
            formData.append('count', $('#count').val())
            formData.append('discount', $('#discount').val())
            formData.append('cost', $('#cost').val())
            formData.append('user', $('#user').val())
            formData.append('type', $('#type').val())
            formData.append('status', $('#status').val())

            $.ajax({
                url: '/',
                method: 'post',
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (respond) {
                    alert('Заказ' + respond.text)
                    console.log(respond)
                    products.reset()
                    $('#exampleModal').modal('hide')
                },
                error: function (jqXHR, status, errorThrown) {
                    console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
                }
            });
        }

    },

    changeOrder: function (e) {
        $('#exampleModal').modal('show')
        let orderId = e.target.value
        this.setOrderFields(orderId)
        $('#submit').val('changeOrder')
    },

    checkForm: function() {

        return ($('#customer').val().replace(/ /g, "").length > 0) &&
               ($('#phone').val().replace(/ /g, "").length > 0) &&
               ($('#product').val() != null) &&
               ($('#count').val() > 0 )
    }
}
