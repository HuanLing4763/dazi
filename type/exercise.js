const Sidebar = `<p style="margin: 7px 5px;">总字数：<span id="totalWordCount">0</span>字</p>
                <p style="margin: 7px 5px;">时　间：<span id="time">00:00</span></p>
                <p style="margin: 7px 5px;">速　度：<span id="speed">0</span>字/分</p>
                <p style="margin: 7px 5px;">正确率：<span id="accuracy">100</span>%</p>
                <p style="margin: 7px 5px;">进　度：<span id="progress">0</span>%</p>
                <div style="text-align: center;">
                    <input id="start" type="image" onclick="startTime()" src="icon/start.svg">
                    <input id="reset" type="image" onclick="reset()" src="icon/reset.svg">
                </div>
                <div id="mode">
                    <input class="btn" type = "button" onclick = "changeMode()" value = "限时模式" >
                </div>`;
var secs = 0;
var mins = 0;
var timeoutId;
var limitTime = 0;  // 时间限制，0为不限时间

var all = 0;  // 总字数
var sum = 0;  // 处于未激活状态的输入框的总字数
var line = 0;  // 总行数
var current_line = 0;  // 行光标
var percentage = 0;  // 一个字所占百分比

var isCounting = false;  // 判断计时状态
var inputLock = false;  // 判断中文输入法是否在拼写状态

var acticle = "test";

window.onload = function () {
    showTexts("test");
    $.ajax({
        type: "GET",
        url: "exercise.php",
        success: function (msg) {
            layui.use('dropdown', function () {
                var dropdown = layui.dropdown
                dropdown.render({
                    elem: "#demo1",
                    data: msg,
                    click: function (data, othis) {
                        showTexts(data.title);
                    }
                })
            })
        }
    })
}

function showTexts(str) {
    $.ajax({
        url: `../acticle/${str}.txt`,
        success: function (data) {
            acticle = str;
            current_line = 0;  // 重置输入行数
            limitTime = 0;
            all = data.replace(/[\r\n]/g, "").length;
            percentage = 1 / all * 100;
            data = data.split('\n');
            var strArr = [];
            var htmlcode = '';
            for (let i = 0; i < data.length; i++) {
                for (let j = 0; j < data[i].length; j += 40)
                    strArr.push(data[i].slice(j, j + 40));
            }
            for (line = 0; line < strArr.length; line++) {
                var lineStr = strArr[line].replace(/[\r\n]/g, "");
                htmlcode += `<div class="text" id="refer${line}">`;
                for (let j = 0; j < lineStr.length; j++) {
                    htmlcode += `<span id=row${line}&column${j} class="">${lineStr[j]}</span>`;
                }
                htmlcode += `</div><input class="inputText" id="${line}" readonly oninput="startTime()">`;
            }
            document.getElementById("txtHint").innerHTML = htmlcode;
            document.getElementById("Sidebar").innerHTML = Sidebar;
            document.getElementById("0").focus();
            $("#0").removeAttr("readonly");
            addAttr(0);
        }
    });
}

function compositionstart() {
    inputLock = true;
}

function compositionend() {
    inputLock = false;
}

function addAttr(id) {
    var inputElement = document.getElementById(id);
    inputElement.addEventListener('compositionstart', compositionstart);
    inputElement.addEventListener('compositionend', compositionend);
}

function startTime() {
    setTimeout(() => {
        if (!inputLock) {
            var current_line_content = $(`#refer${current_line}`).text();
            var input_content = $(`#${current_line}`).val();
            if (!isCounting) {
                isCounting = true;
                timeoutId = setInterval(countTime, 1000);  //指定时间执行任务
            }
            // 修改按钮
            $("#start").attr("onclick", "").click(function () { pauseTime(); });
            $("#start").attr("src", "icon/pause.svg");
            $("#start").attr("id", "pause");
            $("#mode").html("");

            //统计字数及进度
            var totalWordCount = input_content.length + sum;
            var progress = Math.trunc(totalWordCount / all * 100);
            $("#totalWordCount").html(totalWordCount);
            $("#progress").html(progress);

            // 计算正确率
            var countNo = $("#txtHint").html().split('class="no"').length - 1;
            var accuracy = Math.trunc(100 - countNo * percentage)
            $("#accuracy").html(accuracy);

            // 判断输入是否正确
            for (let i = 0; i < current_line_content.length; i++) {
                if (input_content[i] == undefined) {
                    document.getElementById(`row${current_line}&column${i}`).className = "";
                } else if (current_line_content[i] == input_content[i]) {
                    document.getElementById(`row${current_line}&column${i}`).className = "yes";
                } else {
                    document.getElementById(`row${current_line}&column${i}`).className = "no";
                }
            }

            finish(totalWordCount);

            // 自动换行输入
            if (current_line_content.length <= input_content.length) {
                var temp = input_content.substring(current_line_content.length + 1);
                $(`#${current_line}`).attr("readonly", "readonly");
                current_line++;

                $(`#${current_line}`).removeAttr("readonly");
                var last = document.getElementById(`${current_line - 1}`);
                var next = document.getElementById(`${current_line}`);
                var next_refer = document.getElementById(`refer${current_line}`);
                next.focus();
                addAttr(current_line);

                // 将溢出内容移动至下面的输入框
                next.value = temp;
                last.value = last.value.substring(0, current_line_content.length + 1);
                if (next.value.length >= next_refer.innerText.length) {
                    startTime();
                }

                // 保存上一行字数
                sum += last.value.length;
            }
        }
    }, 100);

}

function pauseTime() {
    if (isCounting) {
        isCounting = false;
        clearTimeout(timeoutId); //清除指定id计时器
        $("#pause").attr("onclick", "").click(function () { startTime(); });
        $("#pause").attr("src", "icon/start.svg");
        $("#pause").attr("id", "start");
    }
}

function countTime() {
    secs += 1;
    if (secs >= 60) {
        mins += 1;
        secs = 0;
    }
    var content = $(`#${current_line}`).val();
    var totalWordCount = content.length + sum;
    var time = mins * 60 + secs;
    var speed = Math.trunc(totalWordCount / (time / 60));

    temp_secs = checkTime(secs);
    temp_mins = checkTime(mins);
    $("#time").html(`${temp_mins}:${temp_secs}`);
    $("#speed").html(speed);

    finish(totalWordCount);
}

function checkTime(time) {
    if (time < 10)
        time = "0" + time;
    return time;
}
function reset() {
    secs = 0;
    mins = 0;
    accuracy = 100;
    current_line = 0;  // 重置输入行数
    document.getElementById("Sidebar").innerHTML = Sidebar;
    isCounting = false;
    clearTimeout(timeoutId); //清除指定id计时器
    showTexts(acticle);
}

function changeMode() {
    var input = '<input class="btn" type="number" min=1 value=5>';
    var text = '<span style="font-weight: normal;">分钟 </span>';
    var button = '<input id="q" type="button" value="确定" onclick="timeMode()">';
    $("#mode").html(input + text + button);
    // 修改样式
    $(".btn").css({
        "background-color": "white",
        "padding": "5px",
        "width": "35%",
        "color": "black",
        "font-weight": "normal",
        "cursor": "text"
    });
    $("#q").css({
        "background-color": "#66ccff",
        "padding": "5px 10px",
        "color": "white",
        "border": "none",
        "outline": "none",
        "cursor": "pointer"
    });
}

function timeMode() {
    var time = $(".btn").val();
    var reg = /^[0-9]+$/g;
    if (reg.test(time) && time != 0) {
        document.getElementById("0").focus;
        startTime();
        $("#mode").html("");
        limitTime = time;
    } else {
        alert("请输入正整数！");
    }
}

function finish(wordCount) {
    if ((limitTime && mins == limitTime) || wordCount == all) {
        var countNo = $("#txtHint").html().split('class="no"').length - 1;
        var accuracy = Math.trunc(100 - countNo * percentage);
        var param = {
            acticle: acticle,
            wordCount: wordCount,
            time: $("#time").html(),
            speed: $("#speed").html(),
            accuracy: accuracy
        }
        var params = JSON.stringify(param);
        localStorage.setItem('params', params);
        window.location.replace("../result/result.html");
    }
}