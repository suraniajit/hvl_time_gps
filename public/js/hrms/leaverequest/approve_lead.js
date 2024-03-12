$(document).ready(function () {

    $('#approveleaverequest_dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": "/hrms/leaverequest/lead/approve/getdata",
        "type":'GET',
        "columns": [
            {"data":"id","width":"5%",},
            {"data": "Name"},
            {"data": "Name"},
            {"data": "from_date"},
            {"data": "end_date"},
            {"data": "total_days"},
            {"data": "remark"},
            {"data": "status", render : function(data) {
                    if(data==3){
                        return '<span class="badge green">Approved</span>';
                    }
                    else if(data==0){
                        return '<span class="badge red">Rejected</span>';
                    }
                    else if(data==2){
                        return '<span class="badge brown darken-1">Pending</span>';
                    }
                    else if(data==1){
                        return '<span class="badge green">Approved</span>';
                    }
                }
            },
            {"data": "action", orderable: false, searchable: false},
                    ],
        "order": [[0, "desc"]],

        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
            return nRow;
        },
        "info": false   ,
        //"dom": '<"top"f>irt<"bottom"lp><"clear">',
//        "bPaginate": false,
        "paginate":false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false

    });

});






