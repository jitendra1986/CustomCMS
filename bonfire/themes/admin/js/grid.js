/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
        
    $(".admin-box").delegate(".submit-filters", "click", function(e) {        
        submitForm();
    });
    
    $(".admin-box").delegate(".search-field-dropdown", "change", function(e) {        
        var rel = $(this).attr('rel');
        var value = $(this).val();
        $("input[rel_id="+rel+"]").attr("name", 'search[' + value + ']');        
    });
    
    $(".admin-box").delegate(".category-dropdown", "change", function(e) {
        $("#sortby").attr("value", "");
        $("#order").attr("value", "");   
        submitForm();
    });
    
    $(".admin-box").delegate(".sort", "click", function(e) {
        var sortby = $(this).attr("for");
        var order = $(this).attr("rel");
        $("#sortby").attr("value", sortby);
        $("#order").attr("value", order);
        submitForm();        
    });
    
    
    $(".admin-box").delegate(".search-dropdown", "change", function(e) {
        submitForm();
    });
   
    $(".admin-box").delegate(".pagination_link", "click", function(e) {
        var page = $(this).attr("value");
        paginationCall(page);
    });

    $(".admin-box").delegate("#page", "focusout", function(e) {
        var page = $(this).attr("value");
        paginationCall(page);
    });

    $(".admin-box").delegate(".per_page", "change", function(e) {
        $("#page").attr("value", 1);
        submitForm();
    });

    $(".admin-box").delegate(".delete-selected", "click", function(e) {
        var checkedBoxes = $("input:checkbox[name=checked[]]:checked").length;
        if (checkedBoxes > 0) {
            if (confirm("Are you sure you want to delete selected rows ?")) {
                $("#action").attr("value", "deleteSelected");
                submitForm();
            }
        }else{
            alert("No Records Selected.Please Select Record First.")
        }
    });

    $(".admin-box").delegate(".delete", "click", function(e) {
        if (confirm("Are you sure you want to delete this row ?")) {
            $("#action").attr("value", "delete");
            var data = $("#admin_listing_form").serializeArray();
            data.push({name: "delete_id", value: $(this).attr("rel")});
            var url = $("#admin_listing_form").attr("action");
            ajax(url, data, setResponse);
        }
    });
    
    $(".admin-box").delegate(".toggle_status", "click", function(e) {
        $("#action").attr("value", "toggleStatus");
        var data = $("#admin_listing_form").serializeArray();        
        data.push({name: "id", value: $(this).attr("rel_id")});
        var url = $("#admin_listing_form").attr("action");
        ajax(url, data, setResponse);
    });

    $(".admin-box").delegate(".check-all", "click", function() {
        $("table input[type=checkbox]").attr('checked', $(this).is(':checked'));
    });
    
    $(".admin-box").delegate(".icon-chevron-down, .icon-chevron-up", "click", function(e) {                    
            $("#action").val('changePosition');
            var data = $("#admin_listing_form").serializeArray();
            var url = $("#admin_listing_form").attr("action");
            
            data.push({name: "state", value: $(this).attr("state")});
            data.push({name: "position", value: $(this).attr("position")});
            data.push({name: "id", value: $(this).attr("rel_id")});
            
            ajax(url, data, setResponse);        
            $("#action").val('');
    });
    
    $(".admin-box").delegate(".reset-filters", "click", function() {
        $('.reset-input').val("");
        $('.reset-dropdown').find('option:first').attr('selected', 'selected');        
        submitForm();        
    });
    
     $(".admin-box").delegate("input", "keypress", function(event) {
        if (event.which == 13) {
            event.preventDefault();
            submitForm();
        }
    }); 

});

function ajax(url, data, callback) {
    $.ajax({
        url: url+"/"+$.now(),
        type: "POST",
        data: data,
        success: callback
    }).fail(function() {
        console.log('failed to retrieve data from server.');
    });
}

function setResponse(response) {
//    console.log("response :: "+response);
      $("#table_content").hide().html(response).fadeIn("slow");
      $('.search-field-dropdown').trigger('change');
}

function paginationCall(page) {
    if (page > 0) {
        $("#page").attr("value", page);
        submitForm();
    }
}

function submitForm(){
    var data = $("#admin_listing_form").serializeArray();
    var url = $("#admin_listing_form").attr("action");
    ajax(url, data, setResponse);
}
