showNotification = function (message, color, icon) {
    $.notify({
        icon: "nc-icon " + icon,
        message: message

    }, {
        type: color,
        delay: 100,
        placement: {
            from: 'top',
            align: 'center'
        }
    });
};

$.fn.serializeObject = function () {
    let o = {};
    let a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$(document).on("click", ".save-bet-button", function (event) {
    event.preventDefault();
    let $_target = $(event.target);
    let bettingWrapperSelector = $('.betting-wrapper');
    let bettingFormSelector = $('.user-betting-form');
    let submitSelector = $('.save-bet-button');

    submitSelector.prop('disabled', true);
    let data = $_target.closest(bettingWrapperSelector).find(bettingFormSelector).serializeObject();

    $.ajax({
        url: '/savebet',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
            if (data.status) {
                showNotification("Tipp erfolgreich gespeichert!", 'success', 'nc-check-2')
            } else {
                showNotification("Fehler! 🙁", 'danger', 'nc-simple-remove')

            }
        },
        complete: function () {
            submitSelector.prop('disabled', false);
        }
    });

});

$(document).on("click", ".extra-bet-submit", function (event) {
    event.preventDefault();
    let $_target = $(event.target);
    let bettingWrapperSelector = $('.extra-bet-wrapper');
    let bettingFormSelector = $('.extra-bet-form');
    let submitSelector = $('.extra-bet-submit');

    submitSelector.prop('disabled', true);

    let data = $_target.closest(bettingWrapperSelector).find(bettingFormSelector).serializeObject();

    $.ajax({
        url: '/saveextrabet',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
            if (data.status) {
                showNotification("Tipp erfolgreich gespeichert!", 'success', 'nc-check-2')
            } else {
                showNotification("Fehler! 🙁", 'danger', 'nc-simple-remove')

            }
        },
        complete: function () {
            submitSelector.prop('disabled', false);
        }
    });

});

