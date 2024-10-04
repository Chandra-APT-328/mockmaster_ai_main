var a = "";

$(document).ready(function () {

    var data_url = $("#data-url").val();

    $("#sortable").sortable({
        stop : function(event, ui) {
            $.ajax({
                url: data_url,
                dataType: "json",
                type: "post",
                data: $(this).sortable('serialize'),
                success: function(data) {}
            })
        }
    });


    $("#sortable").disableSelection();

    var products_form_data = {};

      //called when key is pressed in textbox
    $("#phone_number").keypress(function (e) {

       //if the letter is not digit then display error and don't type anything
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

       return false;

      }

   });

  $('form#form_enter_submit input').keypress(function (e) {

      if (e.which == 13) {

          $('form#form_enter_submit').submit();

	        return false;

	    }

	});


  $("#add_new_purchase").click(function(){

    var customer_id = $(this).data('id');

    var type = $(this).data('type');

    if(typeof type !== "undefined" && type == "admin")
      window.location.href = SITE_URL+"/admin/purchase/add/"+customer_id;
    else
      window.location.href = SITE_URL+"/store/purchase/add/"+customer_id;

  })

  $( function() {
   
    if ( typeof product_list !== 'undefined' ) {

      $( "#project" ).autocomplete({

        minLength: 0,

        source: product_list,

        focus: function( event, ui ) {

          $( "#project" ).val("");

          return false;
        },

        select: function( event, ui ) {

          $("#purchase_product_list tbody tr:last").after(ui.item.html);

          $("#purchase_product_list tbody tr.product-row:last").attr("product-id",ui.item.id);

          products_form_data[ui.item.id] = 1;

          calculate_total_purchase_price();

          complete_purchase_btn_status();
          $( "#project" ).length
            document.getElementById("project").focus();

          return false;

        }

      })

      .autocomplete( "instance" )._renderItem = function( ul, item ) {

        return $( "<li>" )

        .append( "<div>" + item.name +"</div>" )

        .appendTo( ul );

      };

    }
    
  });

  // if($("#add_products_to_purchase").length){
  //   $('html, body').animate({
  //     scrollTop: $("#add_products_to_purchase").offset().top
  //   }, 2000);
  // }
  $( function() {
   
    if ( typeof service_center_list !== 'undefined' ) {

      $( "#service_center_search" ).autocomplete({

        minLength: 0,

        source: service_center_list,

        focus: function( event, ui ) {

          $( "#service_center_search" ).val("");

          return false;
        },

        select: function( event, ui ) {

          $("#service_center_search-id").val(ui.item.id);

          $.ajax({
              url: SITE_URL+"/admin/complain/get_engineers_by_service_center_id",

              type: "POST",

              dataType : "JSON",

              data: "service_center_id="+ui.item.id,

              success: function (response) {

                 if(response.success)
                 {
                      var html_select = "";

                      $("#engineer_list").html('<option value = "">Select engineer </option>');

                      $.each(response.data.engineers, function (i, v) {

                        $("#engineer_list").append("<option value='"+ v.id +"'>" + v.engineer_name + "</option>");

                      });

                      $("#engineer_list").prop("disabled",false);

                      // $("#btn-submit").prop("disabled",false);

                 }
              },

          });

        }

      })

      .autocomplete( "instance" )._renderItem = function( ul, item ) {

        return $( "<li>" )

        .append( "<div>" + item.name +"</div>" )

        .appendTo( ul );

      };

    }
    
  });

  $("#service_center_search").blur(function(){

    var _this = $(this);

    if(_this.val() == "")
    {
      $("#engineer_list").html('<option value = "">Select engineer </option>');

      $("#engineer_list").prop("disabled",true);

      // $("#btn-submit").prop("disabled",true);

    }

  });

  $(document).on("change", "select[name=complain_status]", function(){

    var _this = $(this);

      if(_this.val() == 2 || _this.val() == 1)
      {
          $("#engineer_list").html('<option value = "">Select engineer </option>');

          $("#engineer_list").prop("disabled",true);

          // $("#btn-submit").prop("disabled",false);

      }
      else
      {
          // $("#btn-submit").prop("disabled",true);
      }

  })

  $(document).on("change", "#engineer_list", function(){

    var _this = $(this);

    $("input[name=engineer_id]").val(_this.val());

  })

  $(document).on("click", "#btn-submit", function(){

        $(this).parents("form").submit();

    });

  $(document).on("click", ".remove-product-purchase", function(){

    var _this = $(this);

    _this.parents("td").parents("tr").remove();

    calculate_total_purchase_price();

    complete_purchase_btn_status();

    // products_form_data

  })

  $(document).on("keypress", ".quantity-box", function(e){

    //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

       return false;

     }

  })

  $(document).on("keypress", ".number-only-box", function(e){

    var _this = $(this);

    //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

       return false;

     }

  })

    $(document).on("change", ".quantity-box", function(e){

      var _this = $(this);

      var quantity = _this.val();

      var store_price = _this.parents("td").siblings(".store_price_box").find("input").val();

      var total_amount = quantity*store_price;

      total_amount = Math.round(total_amount,2);

      _this.parents("td").siblings(".amount-box").text(total_amount);

      calculate_total_purchase_price();

      complete_purchase_btn_status();

    })

    $(document).on("keyup", ".quantity-box", function(e){

      var _this = $(this);

      var quantity = _this.val();

      var store_price = _this.parents("td").siblings(".store_price_box").find("input").val();

      var total_amount = quantity*store_price;

      total_amount = Math.round(total_amount,2);

      _this.parents("td").siblings(".amount-box").text(total_amount);

      calculate_total_purchase_price();

      complete_purchase_btn_status();

    })

    $(document).on("keyup", ".store_price_box input", function(e){

      var _this = $(this);

      var store_price = 0;

      var quantity = 0;

      var unit_price = 0;

      var total_amount = 0;

      var store_discount = 0;

      store_price = parseFloat(_this.val());

      quantity = _this.parents("td").siblings(".quantity-cell").find("input.quantity-box").val();

      unit_price = _this.parents("td").siblings(".unit-box").text();

      unit_price = parseFloat(unit_price);

      total_amount = parseFloat(quantity)*store_price;

      total_amount = Math.round(total_amount,2);

      store_discount = unit_price - store_price;

      store_discount = Math.round(store_discount,2);

      if(store_discount < 0)
        store_discount = 0;

      _this.parents("td").siblings(".amount-box").text(total_amount);

      _this.parents("td").siblings(".store_discount_cell").find("input").val(store_discount);

      calculate_total_purchase_price();

      complete_purchase_btn_status();

    })


    $(document).on("change", ".store_price_box input", function(e){

      var _this = $(this);

      var store_price = parseFloat(_this.val());

      var quantity = parseFloat(_this.parents("td").siblings(".quantity-cell").find("input.quantity-box").val());

      var unit_price = _this.parents("td").siblings(".unit-box").text();

      unit_price = parseFloat(unit_price);

      var total_amount = quantity*store_price;

      total_amount = Math.round(total_amount,2);

      var store_discount = parseFloat(unit_price - store_price);

      store_discount = Math.round(store_discount,2);

      if(store_discount < 0)
        store_discount = 0;

      _this.parents("td").siblings(".amount-box").text(total_amount);

      _this.parents("td").siblings(".store_discount_cell").find("input").val(store_discount);

      calculate_total_purchase_price();

      complete_purchase_btn_status();

    })


    $(document).on("keyup", ".store_discount_cell input", function(e){
      
      var _this = $(this);

      var store_discount = parseFloat(_this.val());

      var unit_price = _this.parents("td").siblings(".unit-box").text();

      if(isNaN(store_discount)) {

        var store_price = unit_price;
        
      }
      else
      {
          var store_price = parseFloat(unit_price) - store_discount;

          store_price = Math.round(store_price,2);

      }

      var quantity = _this.parents("td").siblings(".quantity-cell").find("input.quantity-box").val();

      var total_amount = parseFloat(quantity)*store_price;

      total_amount = Math.round(total_amount,2);

      if(total_amount < 0)
        total_amount = 0;

      if(store_price < 0)
        store_price = 0;

      _this.parents("td").siblings(".amount-box").text(total_amount);

      _this.parents("td").siblings(".store_price_box").find("input").val(store_price);

      calculate_total_purchase_price();

      complete_purchase_btn_status();

    })


    $(document).on("change", ".store_discount_cell input", function(e){

      var _this = $(this);

      var store_discount = parseFloat(_this.val());

      var unit_price = _this.parents("td").siblings(".unit-box").text();

      if(isNaN(store_discount)) {

        var store_price = unit_price;
        
      }
      else
      {
          var store_price = parseFloat(unit_price) - store_discount;

          store_price = Math.round(store_price,2);

      }

      var quantity = _this.parents("td").siblings(".quantity-cell").find("input.quantity-box").val();

      var total_amount = parseFloat(quantity)*store_price;

      total_amount = Math.round(total_amount,2);

      if(total_amount < 0)
        total_amount = 0;
      
      if(store_price < 0)
        store_price = 0;

      _this.parents("td").siblings(".amount-box").text(total_amount);

      _this.parents("td").siblings(".store_price_box").find("input").val(store_price);

      calculate_total_purchase_price();

      complete_purchase_btn_status();

    })


    $(document).on("click", "#complete-purchase", function(){

      var products_form_data_arr = {};

      $(".product-row").each(function(){

        var _this = $(this);

        var pid = _this.attr("product-id");

        var qty = _this.find(".quantity-box").val();

        var store_price = _this.find(".store_price_box input").val();

        products_form_data_arr[pid] = {qty : qty, store_price : store_price}

      });

      $("#purchase-form").find("input[name=product_purchase_data]").val(JSON.stringify(products_form_data_arr));

      $("#purchase-form").submit();

    });

    if($('#inp').length)
     document.getElementById("inp").addEventListener("change", readFile);

    if($('#inp1').length)
     document.getElementById("inp1").addEventListener("change", readFile1);

    if($('#inp2').length)
     document.getElementById("inp2").addEventListener("change", readFile2);

    if($('#inp3').length)
     document.getElementById("inp3").addEventListener("change", readFile3);

    if($('#inp4').length)
     document.getElementById("inp4").addEventListener("change", readFile4);

    if($('#inp5').length)
     document.getElementById("inp5").addEventListener("change", readFile5);

    if($('#inp6').length)
     document.getElementById("inp6").addEventListener("change", readFile6);

   $(document).on("change", ".select_store_purchase", function(){

      var _this = $(this);

      var slelected_store = _this.val();

      $(".select_store_purchase").addClass("danger-class-store");

      if(slelected_store != 0)
      {
          $(".select_store_purchase").removeClass("danger-class-store");
      }

      $(".admin_purchase_form").find("input[name=store_id]").val(slelected_store);

      complete_purchase_btn_status();

   })

   $(document).on("click", ".delete-store", function(){

        var _this = $(this);

        var href = _this.data("href");

        $("#delete-store-modal").find(".btn-del-modal").attr("href",href);

        $("#delete-store-modal").modal();
    })

   $(document).on("click", ".cannot-delete-store", function(){

        var _this = $(this);

        $("#cannot-delete-store-modal").modal();

    })

   $(document).on("click", ".delete-service-center-engineer", function(){

        var _this = $(this);

        var href = _this.data("href");

        $("#delete-service-center-engineer-modal").find(".btn-del-modal").attr("href",href);

        $("#delete-service-center-engineer-modal").modal();
    })

   $(document).on("click", ".cannot-delete-service-center-engineer", function(){

        var _this = $(this);

        $("#cannot-delete-service-center-engineer-modal").modal();

    })

   $(document).on("click", ".cannot-delete-product-service", function(){

        var _this = $(this);

        $("#cannot-delete-product-service-modal").modal();

    })

   $(document).on("click", ".delete-product-service", function(){

        var _this = $(this);

        var href = _this.data("href");

        $("#delete-product-service-modal").find(".btn-del-modal").attr("href",href);

        $("#delete-product-service-modal").modal();
    })

   $(document).on("click", ".delete-banner", function(){

        var _this = $(this);

        var href = _this.data("href");

        $("#delete-banner-modal").find(".btn-del-modal").attr("href",href);

        $("#delete-banner-modal").modal();
    })

   if($('.file_inp').length)
     document.getElementByClassName("file_inp").addEventListener("change", encodeImagetoBase64);

   $(document).on("change", ".file_inp", function(e){

      var _this = $(this);

      var base64_img_code = encodeImagetoBase64(_this);

   });

  $( function() {

    if($( "#datepicker" ).length)
    {
        $( "#datepicker" ).datepicker({

        changeMonth: true,

        changeYear: true,

        dateFormat : "DD, d MM, yy",

        altField: "#alternate_datepicker",

        altFormat: "yy-mm-dd",

        minDate: 0

      }).on('changeDate', function(e){
        $("#alternate_datepicker").val(e.format('yyyy-mm-dd'))
    });
    }

  });

  $(document).on("change", ".product-checkbox", function(){

    var _this = $(this);
   
    if(_this.prop("checked") == true)
    {
      _this.parents(".custom-checkbox").siblings(".all-issues").find(".issue-checkbox").prop("checked", true);
    }
    else
    {
      _this.parents(".custom-checkbox").siblings(".all-issues").find(".issue-checkbox").prop("checked", false);

    }

  })
  $(document).on("change", ".issue-checkbox", function(){

    var _this = $(this);
   
    if(_this.prop("checked") == false)
    {
      var check = _this.parents(".all-issues").find(".issue-checkbox:checked").length;

      // if(check < 1)
         _this.parents(".all-issues").siblings(".custom-checkbox").find(".product-checkbox").prop("checked", false);
    }
    else
    {
        var check_checked = _this.parents(".all-issues").find(".issue-checkbox:checked").length;
        var check_all = _this.parents(".all-issues").find(".issue-checkbox").length;

        if(check_checked == check_all)
         _this.parents(".all-issues").siblings(".custom-checkbox").find(".product-checkbox").prop("checked", true);
    }

  });

  $(".all-issues").each(function(){
      var _this = $(this);
      if(_this.find(".issue-checkbox:checked").length == _this.find(".issue-checkbox").length)
        {
        _this.siblings(".custom-checkbox").find(".product-checkbox").prop("checked", true);
      }
  });

  $(document).on("click", "#service-center-act-form .submit-btn", function(){

      var _this = $(this);

      var value = _this.val();

      if(value != 1 && value != 2)
      {
        value = 0;
      }

      $("#service-center-act-form").find("input[name=status]").val(value);
      
      $("#service-center-act-form").submit();

  })

});


function readFile() {

 if (this.files && this.files[0]) {

   var FR= new FileReader();

   FR.addEventListener("load", function(e) {

     document.getElementById("img").src = e.target.result;

     document.getElementById("b64").value = e.target.result;

   });

   FR.readAsDataURL( this.files[0] );

 }

}
function readFile1() {

 if (this.files && this.files[0]) {

   var FR= new FileReader();

   FR.addEventListener("load", function(e) {

     document.getElementById("img1").src = e.target.result;

     document.getElementById("b641").value = e.target.result;

   });

   FR.readAsDataURL( this.files[0] );

 }

}
function readFile2() {

 if (this.files && this.files[0]) {

   var FR= new FileReader();

   FR.addEventListener("load", function(e) {

     document.getElementById("img2").src       = e.target.result;

     document.getElementById("b642").value = e.target.result;

   });

   FR.readAsDataURL( this.files[0] );
 }

}
function readFile3() {

 if (this.files && this.files[0]) {

   var FR = new FileReader();

   FR.addEventListener("load", function(e) {

     document.getElementById("img3").src = e.target.result;

     document.getElementById("b643").value = e.target.result;

   });

   FR.readAsDataURL( this.files[0] );
 }

}

function readFile4() {

 if (this.files && this.files[0]) {

   var FR = new FileReader();

   FR.addEventListener("load", function(e) {

     document.getElementById("b644").value = e.target.result;

   });

   FR.readAsDataURL( this.files[0] );
 }

}

function readFile5() {

 if (this.files && this.files[0]) {

   var FR = new FileReader();

   FR.addEventListener("load", function(e) {

     document.getElementById("bppo").value = e.target.result;

   });

   FR.readAsDataURL( this.files[0] );
 }

}

function readFile6() {

 if (this.files && this.files[0]) {

   var FR = new FileReader();

   FR.addEventListener("load", function(e) {

     document.getElementById("bppmc").value = e.target.result;

   });

   FR.readAsDataURL( this.files[0] );
 }

}

function calculate_total_purchase_price()
{
    var total_purchase_amount = 0.00;

    $(".amount-box").each(function(){

      var _this = $(this);

      total_purchase_amount = total_purchase_amount + parseFloat(_this.text());

      total_purchase_amount = Math.round(total_purchase_amount,2);

    })

    total_purchase_amount = total_purchase_amount.toLocaleString('en-IN');

    $('#purchase_total').text(total_purchase_amount);

}

function complete_purchase_btn_status()
{

  var purchase_total = $('#purchase_total').text();

  purchase_total = parseFloat(purchase_total);

  var store_selected = true;

  if($("#purchase-form").hasClass("admin_purchase_form"))
  {
      store_selected = false;

      var temp = $("#purchase-form").find("input[name=store_id]").val();

      if(temp != 0)
      {
          store_selected = true;
      }
  }

  if(store_selected && $(".product-row").length && purchase_total > 0)
  {
    $("#complete-purchase").removeAttr("disabled");
  }
  else
    $("#complete-purchase").attr("disabled","disabled");

}
