let today = new Date();
today.setDate(today.getDate());
console.log("oday " + today);

let septemberThisYear = new Date();
septemberThisYear.setMonth(8);
septemberThisYear.setMonth(septemberThisYear.getMonth() + 1, 0);
septemberThisYear.setHours(23, 59, 59, 999);

let oneYearAhead = new Date();
oneYearAhead.setFullYear(oneYearAhead.getFullYear() + 1);
oneYearAhead.setMonth(oneYearAhead.getMonth() + 1, 0);
oneYearAhead.setHours(23, 59, 59, 999);


const DATE_PICKER_CONFIG = {
    position: 'top right',
    language: "en",
    autoClose: false,
    dateFormat: "M dd, yyyy",
    onSelect: function (formattedDate, date, inst) {
        $(inst.el).trigger('input');
    },
};


var datePicker = $(`#year-picker`).datepicker({
    position: 'bottom right',
    language: "en",
    autoClose: false,
    dateFormat: "M dd, yyyy",
    onSelect: function (formattedDate, date, inst) {
        $(inst.el).trigger('input');
    },
});

