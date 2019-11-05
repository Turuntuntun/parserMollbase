var pages = [];

for (var i = 0; i < 251; i++) {
    if (i == 1) {
        pages.push('http://www.molbase.com/cas/category-11');
    } else {
        pages.push('http://www.molbase.com/cas/category-11-' + i );
    }
}

var webpage2 = require('webpage').create();
var fs2 = require('fs');

var itog = [];
for (i = 1; i < 251; i ++) {
    webpage2.open(pages[i]).then(function() {
        slimer.wait(5000);
        var context = webpage2.evaluate(function () { // после того как динамический контент подгружен, можно его спарсить
            return 1;
        });
        itog.push(context);
    });
}
fs2.write('test.txt', JSON.stringify(itog),'w');

