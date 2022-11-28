var url = $(location).attr('href'),
parts = url.split("/"),
last_part = parts[parts.length-1];
 
// alert(last_part);
if (last_part != "user" && last_part != "") {
    $(document).idle({
        onIdle: function(){
            window.location.href =  BASE_URL + "user/sign_out/xp";
        },
        idle: 300000
    });
}