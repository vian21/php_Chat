//check for recent unread chats immediately
check(1);
//start the checking loop
startCheckingRecent();
//variable used in checking that your recent chats' data is up to date, it will be checked with new data to avoid double append
var recentUnreadNUmber = 0;
//variable used to mean that there are no new recent chats(Boolean)
var noChat = false;
$(document).ready(function () {
    //Image popup close
    $("#closePopup").click(function () {
        $("#popup").hide();
    })
    //handle onclick somewhere else other that the dropdown -->hide
    const $menu = $('.dropdown-content');
    $(document).mouseup(function (e) {
        if (!$menu.is(e.target) // if the target of the click isn't the container...
            &&
            $menu.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $menu.css("display", "none");
        }
    });
    //Ontouch for touchscreens -->close dropdown
    $(document).on('touchend', function (e) {
        if (!$menu.is(e.target) // if the target of the click isn't the container...
            &&
            $menu.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $menu.css("display", "none");
        }
    });
    //activate dropdown
    $(".settings").click(function () {
        $(".dropdown-content").css("display", "block")
    })
    //Ajax for search on input in search bar
    $("#inputBox").on("keyup", function () {
        var searchText = $("#inputBox").val();
        $.ajax({
            url: "modules/search.php",
            data: {
                search: searchText,
            },
            method: "get",
            success: function (data) {
                appendSearchResult(data);
            }
        });
    });
})
/*Funtions*/
//Append json for read recent data
function appendRecentRead(jsonData) {
    if (jsonData !== "") {
        var jsonArray = JSON.parse(jsonData);
        var i = 0;
        var itemHtml = "";
        for (i; i < jsonArray.length; i++) {
            itemHtml += "<div class='item' onclick='goChat(" + jsonArray[i][0] + ")'>";
            itemHtml += "<img src='src/img/uploaded/" + jsonArray[i][2] + "' onclick='pop()'>";
            itemHtml += "<span class='item_name'>" + jsonArray[i][1] + "</span>";
            itemHtml += "<span class='msg_num'>" + jsonArray[i][3] + "</span>";
            itemHtml += "</div>";
        }
        $("#main").append(itemHtml)
    }
}
//Append unread chats
function appendRecentUnread(jsonData) {
    if (jsonData !== "") {
        var jsonArray = JSON.parse(jsonData);
        var i = 0;
        var itemHtml = "";
        for (i; i < jsonArray.length; i++) {
            itemHtml += "<div class='item' onclick='goChat(" + jsonArray[i][0] + ")'>";
            itemHtml += "<img src='src/img/uploaded/" + jsonArray[i][2] + "' onclick='pop()'>";
            itemHtml += "<span class='item_name'>" + jsonArray[i][1] + "</span>";
            itemHtml += "<span class='msg_num'>" + jsonArray[i][3] + "</span>";
            itemHtml += "</div>";
        }
        //If the already appended(or not) is not up to date
        if (recentUnreadNUmber !== jsonArray.length) {
            //Clear the main div and append new data
            $("#main").html(itemHtml)
            //Also check and append read recent chats
            check(2)
            //Passing the length of the gotten array in order to compare it to future requests
            recentUnreadNUmber = jsonArray.length;
            //Re-initialise the noChat variable if new recent chats found
            noChat = false;

        }
        //If there are no unread recent chats
        if (jsonArray == "" && noChat == false) {
            //Clear the main div
            $("#main").html("")
            //Check and append read chats
            check(2);
            //Make noChat == true to mean that there no unread recent chats
            noChat = true;
        }
    }
}
//function to append results from the search request
function appendSearchResult(jsonArray) {
    /*
     *0:id
     *1:name
     *2:img
     *3:number of messages
     */
    if (isJSON(jsonArray) && jsonArray !== "ko" && jsonArray !== "null") {
        var jsonData = JSON.parse(jsonArray);
        var i = 0;
        var itemHtml = "";
        stopCheck();
        for (i; i < jsonData.length; i++) {
            itemHtml += "<div class='item' onclick='goChat(" + jsonData[i][0] + ")'>";
            itemHtml += "<img src='src/img/uploaded/" + jsonData[i][2] + "' onclick='pop()'>";
            itemHtml += "<span class='item_name'>" + jsonData[i][1] + "</span>";
            itemHtml += "<span class='msg_num'>" + jsonData[i][3] + "</span>";
            itemHtml += "</div>";

        }
        $("#main").html(itemHtml);
    }
    if (jsonArray == "ko") {
        stopCheck();
        $("#main").html("<center><div id='noResult'>No results</div></center>");
    }
    if (jsonArray == "null") {
        recentUnreadNUmber = 0;
        noChat = false;
    }
}
/*unread chats check
 *Type 1 for unread
 *Type 2 for read
*/
function check(type) {
    var fetchUrl = "modules/recent.php";
    if (type == 1) {
        fetchUrl += "?unread=";
    }
    if (type == 2) {
        fetchUrl += "?read=";
    }
    $.ajax({
        url: fetchUrl,
        data: {},
        method: "get",
        //On success
        success: function (data) {
            if ((type == 1)) {
                appendRecentUnread(data);
            }
            if ((type == 2)) {
                appendRecentRead(data);
            }
        }
    });
    return false;
}
//Chat redirect to chats page
function goChat(id) {
    var itemId = $("#item");
    var goTrigger = event.target
    if (itemId.children().not("img") && goTrigger.tagName != "IMG") {
        console.log(id)
        var url = "chat.php?to=" + id;
        console.log(url)
        window.location.href = url;
    }
}
//Check if gotten data is json
function isJSON(something) {
    if (typeof something != 'string')
        something = JSON.stringify(something);

    try {
        JSON.parse(something);
        return true;
    } catch (e) {
        return false;
    }
}
//Popup image function
function pop() {
    var imgLocation = $(event.target).attr("src");
    $("#popupImg").attr("src", imgLocation);
    $("#popup").toggle();
}
//function to start checking for recent unread messages every second
function startCheckingRecent(time) {
    var timer = setInterval(() => {
        check(1)
    }, 1000)
}
//Function to stop checking for recent chats
function stopCheck() {
    timer = 0;
}
