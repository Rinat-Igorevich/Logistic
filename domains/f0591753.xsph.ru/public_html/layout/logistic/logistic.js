let arrival = {
    // addRow: function (e) {
    //     console.log(e.target.parentElement.parentElement.parentElement)
    //     // $('#arrival').append($('#row'));
    //     // $('#arrival').append('<tr><th>2</th>...</tr><tr>...</tr>');
    //     $('#arrival').append('<tr id="row"><th></th><td><select id="product" onchange=""><option disabled="" selected="">Выберите товар</option>\n' +
    //         ' <option value="1">ноутбук</option>\n' +
    //         ' <option value="2">мышь</option>\n' +
    //         ' <option value="3">клавиатура</option>\n' +
    //         ' </select></td>\n' +
    //         ' <td>\n' +
    //         ' <input id="sum" style="width: 70px">\n' +
    //         ' </td>\n' +
    //         '\n' +
    //         '                        </tr>');
    //     $('#arrival').append(e.target.parentElement.parentElement);
    // }

    create: function () {

        let formData = new FormData();
        formData.append('action', 'createArrival')
        formData.append('storageID', $('#storage').val())
        formData.append('productID', $('#product').val())
        formData.append('productCount', $('#count').val())

        $.ajax({
            url: '/',
            method: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,

            success: function (respond) {
                console.log(respond)
            }
        });
    }
}

let move = {

    checkStock: function (e) {
        let error = null

        console.log($('#countToMove').val())
        console.log($('#onStock').val())
        if ($('#fromStorage').val() == null) {
            //alert('Выберите склад отправитель')
            error = 1
        }
        if ($('#toStorage').val() == null) {
            //alert('Выберите склад получатель')
            error = 2
        }
        if ( $('#fromStorage').val() === $('#toStorage').val()) {
            //alert('Склад получатель не может быть равен отправителю')
            error = 3
        }
        if (Number($('#onStock').val()) < Number($('#countToMove').val())) {
            alert('переместить больше чем есть на складе нельзя')
            $('#countToMove').val($('#onStock').val())
            error = 3
        }
        if ($('#productIDToMove').val() == null) {
            error = 3
        }

        if (error == null) {
            let formData = new FormData
            let productID = $('#productIDToMove').val()
            formData.append('action', 'checkMoveStock')
            formData.append('storageID', $('#fromStorage').val())
            console.log(productID)
            formData.append('productID', productID)
            $.ajax({
                url: '/',
                method: 'post',
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,

                success: function (respond) {
                    console.log(respond.stock)
                    $('#createMove').prop('disabled', false)
                    $('#onStock').val(respond.stock)
                }
            });
        } else {
            $('#createMove').prop('disabled', true)
        }
    },

    create: function () {

        let formData = new FormData();
        formData.append('action', 'createMove')
        formData.append('fromStorageID', $('#fromStorage').val())
        formData.append('toStorageID', $('#toStorage').val())
        formData.append('productID', $('#productIDToMove').val())
        formData.append('productCount', $('#countToMove').val())

        $.ajax({
            url: '/',
            method: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,

            success: function (respond) {

                console.log(respond)
                alert('перемещение создано')
                $('#moveModal').modal('hide')

            },
            error: function (jqXHR, status, errorThrown) {
                console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
            }
        });
    }
}

let sale = {
    create: function () {
        let formData = new FormData();
        formData.append('action', 'createSale')
        formData.append('storageID', $('#saleFromStorage').val())
        formData.append('productID', $('#saleProductID').val())
        formData.append('productCount', $('#saleCount').val())

        $.ajax({
            url: '/',
            method: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,

            success: function (respond) {
                console.log(respond)
            }
        });
    }
}