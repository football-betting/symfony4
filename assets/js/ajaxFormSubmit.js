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

$(document).on("click", ".save-bet-button-dashboard", function (event) {
    event.preventDefault();
    let $_target = $(event.target);
    let $_bettingWrapperSelector = $('.betting-wrapper-dashboard');
    let bettingFormSelector = $('.user-betting-form-dashboard');
    let submitSelector = $('.save-bet-button-dashboard');
    let $_firstGameHiddenSelector = $('.firstGame-hidden-input');
    let $_secondGameHiddenSelector = $('.secondGame-hidden-input');
    let $_firstGameFakeSelector = $('.firstGame-fake-input');
    let $_secondGameFakeSelector = $('.secondGame-fake-input');
    let closestFirstFakeSelector = $_target.closest($_bettingWrapperSelector).find($_firstGameFakeSelector);
    let closestSecondFakeSelector = $_target.closest($_bettingWrapperSelector).find($_secondGameFakeSelector);

    $_target.closest($_bettingWrapperSelector).find($_firstGameHiddenSelector).val(closestFirstFakeSelector.val());
    $_target.closest($_bettingWrapperSelector).find($_secondGameHiddenSelector).val(closestSecondFakeSelector.val());

    submitSelector.prop('disabled', true);
    let data = $_target.closest($_bettingWrapperSelector).find(bettingFormSelector).serializeObject();

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

