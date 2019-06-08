window.addEventListener('DOMContentLoaded', function () {
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
        let str = node.value.length;
        let counter = document.querySelector(".js-show-countText");
        counter.innerHTML = str;
        if (str > 140)
            document.getElementById('js-error-color').style.color = "red";
        else
            document.getElementById('js-error-color').style.color = null;
    };

});

var charcount = function (str) {
    len = 0;
    str = str.split("");
    for (i = 0; i < str.length; i++) {
        if (str[i].match(/[ｱ-ﾝﾞﾟ]+/)) {
            // 半角カタカナ
            len++;
        } else {
            esc = escape(str[i]);
            if (esc.match(/^\%u/)) {
                // 全角
                len += 2;
            } else {
                // 半角英数
                len++;
            }
        }
    }

    return len;
}