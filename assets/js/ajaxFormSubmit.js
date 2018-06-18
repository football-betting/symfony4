$(document).on("click", ".save-bet-button-dashboard", function (event) {
    event.preventDefault();
    let $_target = $(event.target);
    let $_bettingWrapperSelector = $('.betting-wrapper-dashboard');
    let $_bettingFormSelector = $('.user-betting-form-dashboard');
    let $_submitSelector = $('.save-bet-button-dashboard');
    let $_firstGameHiddenSelector = $('.firstGame-hidden-input');
    let $_secondGameHiddenSelector = $('.secondGame-hidden-input');
    let $_firstGameFakeSelector = $('.firstGame-fake-input');
    let $_secondGameFakeSelector = $('.secondGame-fake-input');
    let $_closestFirstFakeSelector = $_target.closest($_bettingWrapperSelector).find($_firstGameFakeSelector);
    let $_closestSecondFakeSelector = $_target.closest($_bettingWrapperSelector).find($_secondGameFakeSelector);
    let submitAction = '/savebet';

    $_target.closest($_bettingWrapperSelector).find($_firstGameHiddenSelector).val($_closestFirstFakeSelector.val());
    $_target.closest($_bettingWrapperSelector).find($_secondGameHiddenSelector).val($_closestSecondFakeSelector.val());

    $_submitSelector.prop('disabled', true);
    let data = $_target.closest($_bettingWrapperSelector).find($_bettingFormSelector).serializeObject();

    submitForm(data, $_submitSelector, submitAction);

});

$(document).on("click", ".save-bet-button", function (event) {
    event.preventDefault();
    let $_target = $(event.target);
    let $_bettingWrapperSelector = $('.betting-wrapper');
    let $_bettingFormSelector = $('.user-betting-form');
    let $_submitSelector = $('.save-bet-button');
    let submitAction = '/savebet';

    $_submitSelector.prop('disabled', true);
    let data = $_target.closest($_bettingWrapperSelector).find($_bettingFormSelector).serializeObject();

    submitForm(data, $_submitSelector, submitAction);

});


$(document).on("click", ".extra-bet-submit", function (event) {
    event.preventDefault();
    let $_target = $(event.target);
    let $_bettingWrapperSelector = $('.extra-bet-wrapper');
    let $_bettingFormSelector = $('.extra-bet-form');
    let $_submitSelector = $('.extra-bet-submit');
    let submitAction = '/saveextrabet';

    $_submitSelector.prop('disabled', true);

    let data = $_target.closest($_bettingWrapperSelector).find($_bettingFormSelector).serializeObject();

    submitForm(data, $_submitSelector, submitAction);

});

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

function submitForm(data, $_submitSelector, url) {
    $.ajax({
        url: url,
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
            $_submitSelector.prop('disabled', false);
        }
    });
}

