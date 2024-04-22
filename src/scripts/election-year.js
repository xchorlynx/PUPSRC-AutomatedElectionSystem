
let today = new Date();
today.setDate(today.getDate());

let oneYearAhead = new Date();
oneYearAhead.setFullYear(oneYearAhead.getFullYear() + 1);
oneYearAhead.setMonth(oneYearAhead.getMonth() + 1, 0);
oneYearAhead.setHours(23, 59, 59, 999);


let datePickerInst = $(`#year-picker`).datepicker({
    classes: 'col-10 col-md-5 col-xl-4',
    position: 'bottom center',
    language: "en",
    view: 'years',
    minView: 'years',
    minDate: today,
    maxDate: oneYearAhead,
    clearButton: true,
    isMobile: true,
    autoClose: false,
    dateFormat: "yyyy",
    onSelect: function (formattedDate, date, inst) {
        $(inst.el).trigger('input');
    },
    onShow: function () {
        let thisPicker = document.getElementsByClassName('datepicker');
        let input = document.getElementById('year-picker');
        let inputWidth = input.offsetWidth;
        for (let i = 0; i < thisPicker.length; i++) {
            let element = thisPicker[i];

            element.style.width = inputWidth + 'px';
        }
    },
});

