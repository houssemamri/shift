jQuery(document).ready(function () {
    // this file contains send and update message's templates
    'use strict';
    var url = jQuery(".home-page-link").attr("href");
    jQuery(".list-group-item").click(function ()
    {
        if (jQuery(this).attr("data-id"))
        {
            get_notification(jQuery(this).attr("data-id"));
        }
    });
    jQuery(document).on("click", ".delnot", function (e)
    {
        e.preventDefault();
        if (jQuery(this).attr("data-id"))
        {
            var id = jQuery(this).attr("data-id");
            jQuery.ajax({
                url: url + "user/del-notification/" + id,
                type: "GET",
                dataType: "json",
                success: function (data)
                {
                    if (data)
                    {
                        jQuery(".msg-body").append(data);
                    }
                    else
                    {
                        jQuery(".msg-body").fadeOut("slow");
                        var n = 0;
                        jQuery(".list-group-item").each(function () {
                            if (jQuery(this).attr("data-id") === id)
                            {
                                jQuery(this).remove();
                            }
                            n++;
                        })
                        if (n === 1)
                        {
                            jQuery(".list-group").html('<li class="list-group-item">' + Main.translation.mm131 + '</li>');
                        }
                    }
                },
                error: function (data, jqXHR, textStatus)
                {
                    console.log("Request failed: " + textStatus);
                }
            });
        }
    });
    if (window.location.hash)
    {
        var hash = window.location.hash;
        hash = hash.replace('#', '');
        get_notification(hash);
        jQuery('.new a').each(function () {
            if (jQuery(this).attr("href") == document.location.href)
            {
                jQuery(this).closest("li").removeClass("new");
                var notifications = jQuery(".label.label-primary").text();
                notifications = parseInt(notifications) - 1;
                if (notifications >= 0)
                {
                    jQuery(".label.label-primary").text(notifications);
                }
            }
        });
    }
    jQuery(document).on("click", ".notificationss p a", function (event)
    {
        event.preventDefault();
        document.location.href = jQuery(this).attr("href");
        if (jQuery(".notifications").length > 0)
        {
            window.location.reload();
        }
    });
    function get_notification(id)
    {
        // submit data via ajax
        jQuery.ajax({
            url: url + "user/get-notification/" + id,
            type: "GET",
            dataType: "json",
            success: function (data)
            {
                jQuery(".msg-body").fadeIn("slow");
                var content = "";
                if (data[0].notification_title)
                {
                    content += '<h2>' + data[0].notification_title + '<a href="#" class="label label-danger delnot" data-id="' + id + '">' + Main.translation.mm133 + '</a></h2>';
                }
                if (data[0].notification_body)
                {
                    content += data[0].notification_body;
                }
                jQuery(".msg-body").html(content);
            },
            error: function (data, jqXHR, textStatus)
            {
                console.log("Request failed: " + textStatus);
            }
        });
    }
});