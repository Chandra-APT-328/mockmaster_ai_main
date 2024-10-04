let sidebar_datatable = $('.custom-table').DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    dataType: "json",
    paging: true,
    pagingType: "numbers",
    order: [],
    pageLength: 10,
    dom: "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-12 d-flex justify-content-center'p>>",
    "ajax": {
        "url": app_url+"user/listquestions?list_only=true&type="+$('.custom-table').data('type')+"&status=&order=",
    },
    "columnDefs": [{
        "targets": [0],
        "orderable": false
    },
    {
        "targets": [0],
        "className": 'text-left'
    }],
    "initComplete":function( settings, json){
        $('#questions-found').html(json.recordsFiltered); 
    }
    // "bInfo": false,
    // searching: false,
    // "bPaginate": false,
    // "bLengthChange": false,
    // "bFilter": true,
    // "bInfo": false,
    // "bAutoWidth": false
});

$("#practicestatus").change(function(){
    sidebar_datatable.ajax.url(app_url+"user/listquestions?list_only=true&type="+$('.custom-table').data('type')+"&status=&order=&practicestatus="+$('#practicestatus').find(":selected").val());
    sidebar_datatable.ajax.reload(function(json){$('#questions-found').html(json.recordsFiltered); });
});