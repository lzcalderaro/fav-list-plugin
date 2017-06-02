jQuery(document).ready(function(){
    setWgSc();
    jQuery(document).on('click', ".favBtn", function () {
        sendfav(jQuery(this).attr('value'));
    });

    if(jQuery('#favBtn').val() !== undefined) getButtonState(jQuery('#favBtn').val());
});

function sendfav(value)
{
    jQuery.ajax({
        type: "POST",
        url: "/wp-admin/admin-ajax.php",
        data: {"action": "list_fav","idPost":value},
        success: function (retorno) {

            if(retorno != 0) jQuery('.favBtn').html(retorno);
            setWgSc();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}

function setWgSc(){
    jQuery.ajax({
        type: "POST",
        url: "/wp-admin/admin-ajax.php",
        data: {"action": "get_fav_list"},
        success: function (response) {
            if(response != 0)
            {
                response = jQuery.parseJSON(response);
                jQuery("#fav_list").html('');
                jQuery("#fav_list_shortcode").html('');
                jQuery.each(response, function( key, value ){
                    jQuery("#fav_list").append('<li><a href="'+value[1]+'">'+value[0]+'</a></li>');
                    jQuery("#fav_list_shortcode").append('<li><a href="'+value[1]+'">'+value[0]+'</a></li>');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}

function getButtonState(value)
{
    jQuery.ajax({
        type: "POST",
        url: "/wp-admin/admin-ajax.php",
        data: {"action": "get_state_button","idPost":value},
        success: function (response) {
           jQuery("#favBtn").html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}