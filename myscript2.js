var webpage2 = require('webpage').create();
var fs2 = require('fs');

webpage2.open("ya.ru").then(function() {
    slimer.wait(12000); // пауза, длительность в миллисекундах
    var context = webpage2.evaluate(function () { // после того как динамический контент подгружен, можно его спарсить
        return document.body;
    });
});
fs2.write('/error.txt', 'Ошибка', 'w');
slimer.exit();