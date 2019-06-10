window.addEventListener('load', function () {
    let node = document.getElementById("js-countText");
    if (node) {
        node.addEventListener('keyup', count, false);
        let js_check = document.getElementById("js-check");
        let selectbox = document.getElementById("js-selectbox");
        if (js_check) {
            js_check.addEventListener('click', count, false);
        }
        if (selectbox) {
            selectbox.addEventListener('change', count, false);
        }
    }


    function count() {
        let node = document.getElementById("js-countText");
        let str = getLen(node.value);
        let counter = document.querySelector(".js-show-countText");
        counter.innerHTML = str;
        if (str > 140)
            document.getElementById('js-error-color').style.color = "red";
        else
            document.getElementById('js-error-color').style.color = null;
    };

});

function getLen(str) {
    var result = 0;
    for (var i = 0; i < str.length; i++) {
        var chr = str.charCodeAt(i);
        if ((chr >= 0x00 && chr < 0x81) ||
            (chr === 0xf8f0) ||
            (chr >= 0xff61 && chr < 0xffa0) ||
            (chr >= 0xf8f1 && chr < 0xf8f4)) {
            result += 0.5;
        } else {
            result += 1;
        }
    }
    //結果を返す
    return result;
};