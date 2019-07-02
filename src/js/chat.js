var lastMessageId = 0;  //variable to container the id of the last message
var lastMessage = 0;  //variable for the array id of the last message
var countMessages = 0;  //variable to count the messages
var timer = 1100;  //Time interval
//fetch read messages
fetch(2);
//check for new messages
setInterval(() => {
    fetch(1)
}, timer);
$("document").ready(function () {
    //popup close
    $("#closePopup").click(function () {
        $("#popup").hide();
    })
    //chat card click handle
    $(".item").children().not("img").click(function () {
        var url = "chat.php?to=" + $(this).parent().attr('link');
        window.location.href = url;
    })
    // Profile picture popup
    $("img").click(function () {
        var imgLocation = $(this).attr("src");
        $("#popupImg").attr("src", imgLocation);
        $("#popup").toggle();
    })
    //on click on the form scroll
    $("#msg-input").on("click", function () {
        scroll();

    })
})
//function to append read messages
function appendMessages(dataArray) {
    var jsonData = JSON.parse(dataArray);
    if (jsonData != "")
        //variable used in loop
        var i = 0;
    var readMessages = "";
    for (i; i < jsonData.length; i++) {
        //template for messages
        var float = "";
        if (jsonData[i][1] == self) {
            float += "id='myMessages'";
        } else {
            float += "id='others'";
        }
        var messages = "<div class='msg-container'" + float + " >";
        //id,sender,receiver,msg,time,type,status
        /*
         * id=0
         * sender=1
         * receiver=2
         * msg=3
         * time-4
         *status=5
         */
        messages += "<p class='msg'>" + jsonData[i][3] + "</p>";
        messages += "<div class='time'>" + jsonData[i][4] + "</div>";

        messages += "</div>";
        readMessages += messages;
        //lastMessageID should contain the id of the last message
        lastMessageId = jsonData[i][0];
    }
    $("#msg-div").hide();

    setTimeout(() => {
        $("#msg-div").append(readMessages);
        $("#msg-div").toggle();
        scroll();
    }, 200)
}
//function to append unread messages
function appendNewMessages(dataArray) {
    var jsonData = JSON.parse(dataArray);
    if (jsonData !== "") {
        //variable to container unread messages divs
        var newMessageContainer = "";
        //variable used in looping 
        var i = 0
        for (i; i < jsonData.length; i++) {
            if (lastMessageId < jsonData[i][0]) {
                //template for messages
                var float = "";
                if (jsonData[i][1] == self) {
                    float += "id='myMessages'";
                } else {
                    float += "id='others'";
                }
                var messages = "<div class='msg-container '" + float + " >";
                //id,sender,receiver,msg,time,type,status
                /*
                 * id=0
                 * sender=1
                 * receiver=2
                 * msg=3
                 * time-4
                 *status=5
                 */
                messages += "<p class='msg'>" + jsonData[i][3] + "</p>";
                messages += "<div class='time'>" + jsonData[i][4] + "</div>";
                messages += "</div>";
                newMessageContainer += messages;
                lastMessageId = jsonData[i][0];
                lastMessage = i;
                countMessages = jsonData.length - 1;
            }
        }
        if (newMessageContainer !== "" && countMessages < jsonData.length) {
            scroll();
            if (jsonData[lastMessage][1] != self) {
                newMessageLineFadeOut()
                newMessageLine();
            }
            scroll();
            setTimeout(() => {
                newMessageLineFadeOut()
            }, 3000);
            $("#msg-div").append(newMessageContainer);
            countMessages = jsonData.length;
        }
    }
}
/*
 * Function to fetch messages
 * 1 : unread
 * 2 : read
 *
 */
function fetch(messageStatus) {
    var fetchUrl = "modules/fetch.php";
    if (messageStatus == 1) {
        fetchUrl += "?unread=";
    }
    if (messageStatus == 2) {
        fetchUrl += "?read=";
    }
    $.ajax({
        url: fetchUrl,
        data: {
            to: receiver,
        },
        method: "get",
        //On success
        success: function (data) {
            if ((messageStatus == 1)) {
                appendNewMessages(data);
            }
            if ((messageStatus == 2)) {
                appendMessages(data);
            }
        }
    });
    return false;
}
//Create new message line
function newMessageLine() {
    $("#msg-div").append("<div class='newMessageLine' style='clear: both;'>New Messages</div>");
}
//function to fade out all new message lines
function newMessageLineFadeOut() {
    $(".newMessageLine").hide();
}
//function for scrolling
function scroll() {
    $("body, html").animate({
        scrollTop: $(document).height()
    }, 10);
}
//function to send message
function send() {
    var msg = document.getElementById("msg-input").value;
    // Returns successful data submission message when the entered information is stored in database.
    var dataString = "sender=" + self + "&receiver=" + receiver + "&msg=" + msg;
    // AJAX code to submit form.
    $.ajax({
        type: "post",
        url: "modules/send.php",
        data: dataString,
        cache: false,
        success: function () {
            document.getElementById("msg-form").reset();
            //fetch new mesg
            fetch(1);
        }
    });
    return false;
}
