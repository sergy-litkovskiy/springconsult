$('.product-cart').on('click', function () {
    var button = $(this),
        price = button.data('price'),
        title = button.data('title'),
        productId = button.data('product-id');

    var modalPopup = $('#prompt-popup').modal('show');

    modalPopup.find('.error').remove();

    var _paymentSend = function (e) {
        modalPopup.find('.error').remove();

        var name = modalPopup.find('input[name=name]').val(),
            email = modalPopup.find('input[name=email]').val(),
            phone = modalPopup.find('input[name=phone]').val();

        if (!name.length) {
            modalPopup.find('form').after('<label class="error">Поле Имя обязательно</label>');

            return false;
        }

        if (!email.length && !phone.length) {
            modalPopup.find('form').after('<label class="error">Заполните поле Email или Телефон, чтобы мы могли связаться с вами</label>');

            return false;
        }

        if (email.length) {
            var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (!email.match(emailPattern)) {
                modalPopup.find('form').after('<label class="error">Неверный формат поля Email</label>');

                return false;
            }
        }

        var paymentUrl = '/shop/payment',
            data = {
                name     : name,
                email    : email,
                phone    : phone,
                price    : price,
                title    : title,
                productId: productId
            };

        $.ajax({
            type      : 'POST',
            url       : paymentUrl,
            dataType  : 'json',
            data      : data,
            beforeSend: function () {
                modalPopup.find('button.confirm').attr('disabled', true);
                modalPopup.find('button[data-dismiss="modal"]').attr('disabled', true);
            },
            success   : function (response) {
                modalPopup.find('.error').remove();
                modalPopup.find('h2').remove();

                if (response.success == true) {
                    modalPopup.find('form input').val('');
                    modalPopup.find('form').hide().after('<h2>Заказ успешно принят!</h2><p class="text-center">С вами свяжется наш менеджер для уточнения деталей заказа</p>');

                    setTimeout(function () {
                        modalPopup.find('h2').remove();
                        modalPopup.find('form').show();
                        modalPopup.find('button.confirm').attr('disabled', false);
                        modalPopup.find('button[data-dismiss="modal"]').attr('disabled', false);
                        modalPopup.modal('hide');
                    }, 3000);
                } else if (response.error == true) {
                    modalPopup.find('form').after('<label class="error">' + response.message + '</label>');
                    modalPopup.find('button.confirm').attr('disabled', false);
                    modalPopup.find('button[data-dismiss="modal"]').attr('disabled', false);
                }
            },
            error     : function (response) {
                modalPopup.find('form').after('<label class="error">' + response.message + '</label>');
                modalPopup.find('button.confirm').attr('disabled', false);
                modalPopup.find('button[data-dismiss="modal"]').attr('disabled', false);
            }
        });
    };

    modalPopup.find('button.confirm').on('click', _paymentSend);
    modalPopup.find('button[data-dismiss=modal]').on('click', function () {
        modalPopup.find('form input').val('');
    });
});