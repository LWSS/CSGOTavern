/**
 * Created by Administrator on 9/11/2015.
 */

$.ajax({
    url: "http://steamcommunity.com/id/Xversial/inventory/json/730/2",
    //context: document.body
}).done(function(data) {
    //$( this ).addClass( "done" );
    console.log(data);
});