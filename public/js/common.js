var common_config = {
    net_error: '网络异常，请刷新重试',
    error_icon: 5,
    success_icon: 6,
    cookie_prefix:'qj_',
};

function alert_box(msg, icon = 1, closeBtn = false, title = '温馨提示') {
    layer.alert(msg, {
        icon: icon,
        closeBtn: closeBtn,
        title: title,
        skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
    })
}

function tips_box(msg) {
    layer.msg(msg);
}

function msg_box(msg, icon = 1, time = 1000) {
    layer.msg(msg, {icon: icon, time: time})
}


/***校验手机号***/
function check_mobile(value) {
    if (!/^\s*(15\d{9}|13\d{9}|14\d{9}|17\d{9}|18\d{9}|19\d{9}|16\d{9})\s*$/.test(value)) {
        return false;
    }
    return true;
}

/*** 校验座机号 ***/
function check_telphone(value) {
    if (!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(value)) {
        return false;
    }
    return true;
}

/**校验用户名格式***/
function check_username(value) {
    //5-10位纯字母或者6-16位字母+数字组合
    if (!/[A-Za-z]{3,16}$/.test(value) && !/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{3,16}$/.test(value)) {
        return false;
    }
    return true;
}


/**校验密码格式**/
function check_password(value) {
    //6-16 数字+字母组合，可以有特殊字符
    if (!/^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/.test(value)) {
        return false;
    }
    return true;
}

/**layui初始化表单**/
function renderForm() {
    layui.use('form', function () {
        var form = layui.form;
        form.render();
    });
}


function change_table_val(table, id_name, id_value, field, value) {
    $.ajax({
        url: "/manager/change_table_val",
        data: "table=" + table + "&id_name=" + id_name + "&id_value=" + id_value + "&field=" + field + '&value=' + value,
        type: "POST",
        dataType: 'JSON',
        success: function (res) {
            if (res.status == 1) {
                layer.msg(res.msg, {icon: 6});
            } else {
                layer.msg(res.msg, {icon: 5});
            }
        }
    });
}


/**校验身份证号**/
function checkIdCode(val) {
    var p = /^[1-9]\d{5}(18|19|20)\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;
    var factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
    var parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
    var code = val.substring(17);
    if (p.test(val)) {
        var sum = 0;
        for (var i = 0; i < 17; i++) {
            sum += val[i] * factor[i];
        }
        if (parity[sum % 11] == code.toUpperCase()) {
            return true;
        }
    }
    return false;
}

/**验证邮箱**/
function check_email(value) {
    if (/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.){1,4}[a-z]{2,3}$/.test(value)) {
        return true;
    }
    return false;
}

/**
 * 根据身份证获取生日与性别
 * @param value
 */
function transformIdentityCard(value) {
    if (value.length === 15) { // sex 0男  1女
        birthday = `19${value.substr(6, 2)}年${value.substr(8, 2)}月${value.substr(10, 2)}日`;
        sex = ((parseInt(value.substr(14, 1)) + 1) % 2) || 0;
    }
    if (value.length === 18) {
        birthday = `${value.substr(6, 4)}年${value.substr(10, 2)}月${value.substr(12, 2)}日`;
        sex = ((parseInt(value.substr(16, 1)) + 1) % 2) || 0;
    }
}


//设置cookies
function setCookie(name, value) {
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}

//读取cookies
function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");

    if (arr = document.cookie.match(reg))

        return unescape(arr[2]);
    else
        return null;
}

//删除cookies
function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie(name);
    if (cval != null)
        document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
}