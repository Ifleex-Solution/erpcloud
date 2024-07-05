<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="your-generated-integrity-hash" crossorigin="anonymous">


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <input type="hidden" name="baseUrl" id="baseUrl" class="baseUrl" value="<?php echo base_url(); ?>" />
            <button type="button" id="btn-refresh" class="btn btn-success" style="margin-left: 30px;margin-top:20px;"><i class="fas fa-sync-alt"></i> Refresh Cheques</button>
            <button type="button" id="btn-create" class="btn btn-success" style="margin-left: 30px;margin-top:20px;"><i class="fas fa-plus"></i>Add Cheque</button>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="chequeList">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Cheque No</th>
                                <th>Type</th>
                                <th>Effective Date</th>
                                <th>Received From</th>
                                <th>Paid To</th>
                                <th>Deposited To</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>



                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cheque Detail</h4>
            </div>
            <div class="modal-body">
                <div id="chequedetail"></div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Cheque Details</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="cheque_no" class="col-sm-4 col-form-label">Cheque No
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" tabindex="3" class="form-control" name="cheque_no[]" placeholder="Cheque No" id="chequeno" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class="col-sm-4 col-form-label">Effective Date
                    <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-8">
                        <?php
                        date_default_timezone_set('Asia/Colombo');

                        $date = date('Y-m-d'); ?>
                        <input type="date" tabindex="2" class="form-control" name="draft_date[]" value="<?php echo $date; ?>" id="effectivedate" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class="col-sm-4 col-form-label">cheque received date
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-8">
                        <?php
                        date_default_timezone_set('Asia/Colombo');

                        $date = date('Y-m-d'); ?>
                        <input type="date" required tabindex="2" class="form-control" name="effective_date[]" value="<?php echo $date; ?>" id="chequereceiveddate" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="amount" class="col-sm-4 col-form-label">Amount
                    <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" tabindex="3" class="form-control" name="amount[]" placeholder="Amount" id="amount" required />

                    </div>
                </div>
                <button type="button" id="btn-save" class="btn btn-success" style="margin-left: 30px; margin-top: 20px;">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const btnCreate = document.getElementById('btn-create');

    // Add click event listener
    btnCreate.addEventListener('click', function() {
        // Replace with your desired functionality
        $("#exampleModal2").modal('show');
    });


    const btnSave = document.getElementById('btn-save');

    // Add click event listener
    btnSave.addEventListener('click', function() {
        var base_url = $("#baseUrl").val();

        if ($('#chequeno').val() === '') {
            alert("Please enter the cheque number")
        } else if ($('#effectivedate').val() === '') {
            alert("Please enter the Effective Date")
        } else if ($('#chequereceiveddate').val() === '') {
            alert("Please enter the Cheque Received Date")
        } else if ($('#amount').val() === '') {
            alert("Please enter the Amount")
        } else {
            $.ajax({
                type: "post",
                url: base_url + 'supplier/supplier/savecheque',
                data: {
                    chequeno: $('#chequeno').val(),
                    effectivedate: $('#effectivedate').val(),
                    chequereceiveddate: $('#chequereceiveddate').val(),
                    amount: $('#amount').val()
                },
                success: function(data1) {
                    alert("Cheque Details Created Successfully")
                    location.reload();
                }
            });

        }

        //console.log($('#chequeno').val())
    });

    document.getElementById('btn-refresh').addEventListener('click', function() {

        var base_url = $("#baseUrl").val();
        var csrf_test_name = '';
        var is_credit_edit = '';

        $.ajax({
            type: "post",
            url: base_url + 'supplier/supplier/refreshallcheques',
            data: {
                csrf_test_name: csrf_test_name,
                is_credit_edit: is_credit_edit
            },
            success: function(data1) {
                location.reload();

            }
        });

    });


    $(document).ready(function() {
        "use strict";
        // var csrf_test_name = $('#CSRF_TOKEN').val();
        // var total_purchase_no = $("#total_purchase_no").val();
        var base_url = $("#baseUrl").val();
        var csrf_test_name = '';
        var is_credit_edit = '';


        $.ajax({
            type: "post",
            url: base_url + 'supplier/supplier/getallcheques',
            data: {
                csrf_test_name: csrf_test_name,
                is_credit_edit: is_credit_edit
            },
            success: function(data1) {

                var parsedData1 = JSON.parse(data1);
                $('#chequeList').DataTable({
                    "bDestroy": true,
                    "data": parsedData1,
                    responsive: true,

                    "aaSorting": [
                        [4, "desc"]
                    ],
                    "columnDefs": [{
                            "bSortable": false,
                            "aTargets": [0, 1, 2, 3, 5, 6]
                        },

                    ],
                    'processing': true,
                    dom: "'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip",
                    buttons: [{
                        extend: "copy",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want
                        },
                        className: "btn-sm prints"
                    }, {
                        extend: "csv",
                        title: "PurchaseLIst",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want print
                        },
                        className: "btn-sm prints"
                    }, {
                        extend: "excel",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want print
                        },
                        title: "PurchaseLIst",
                        className: "btn-sm prints"
                    }, {
                        extend: "pdf",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want print
                        },
                        title: "PurchaseLIst",
                        className: "btn-sm prints"
                    }, {
                        extend: "print",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] //Your Colume value those you want print
                        },
                        title: "<center> PurchaseLIst</center>",
                        className: "btn-sm prints"
                    }],
                    "columns": [{
                            data: 'id'
                        },
                        {
                            data: 'cheque_no'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'effectivedate'
                        },
                        {
                            data: 'customer_name'
                        },
                        {
                            data: 'supplier_name'
                        },
                        {
                            data: 'bank2'
                        },

                        {
                            data: 'amount'
                        },
                        {
                            data: 'chequestatus'
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                // Check if row exists
                                if (row) {
                                    // console.log(row.draftdate)
                                    // // Encode row data to prevent errors in JSON stringification
                                    // var draftDateString = row.draftdate.toISOString(); // or use any desired date format
                                    // var effectiveDateString = row.effectivedate.toISOString();

                                    return '<button  class="btn btn-success" onclick="handleTableClick(' + row.id + ')" data-toggle="tooltip" data-placement="left" title="View"><i class="pe-7s-note2" aria-hidden="true"></i></button>';
                                } else {
                                    return ''; // Return empty string if row is null or undefined
                                }
                            }
                        }

                    ]
                });
            }
        });



        // $('#btn-filter').click(function() {
        //     purchasedatatable.ajax.reload();
        // });

    });

    function handleTableClick(rowId) {
        var base_url = $("#baseUrl").val();
        $("#exampleModal").modal('show');
        var csrf_test_name = 'jagan';
        var is_credit_edit = 'magan';
        $.ajax({
            type: "post",
            url: base_url + 'supplier/supplier/getchequebyid/' + rowId,
            data: {
                fromdate: '',
                todate: ''
            },
            success: function(data) {
                var parsedData = JSON.parse(data);
                console.log(parsedData);


                var chequedetail = document.getElementById("chequedetail");
                chequedetail.innerHTML = "";


                // Add the HTML string to the content container div
                chequedetail.innerHTML += "<p><b>Cheque No</b> : " + parsedData[0].cheque_no + "</p>";
                chequedetail.innerHTML += "<p><b>Cheque Type</b> : " + parsedData[0].type + "</p>";
                if (parsedData[0].type != '3rd Party')
                    chequedetail.innerHTML += "<p><b>Bank of the Cheque</b> : " + parsedData[0].HeadName + "</p>";
                chequedetail.innerHTML += "<p><b>Draft Date</b> : " + parsedData[0].draftdate + "</p>";
                chequedetail.innerHTML += "<p><b>Effective Date</b> : " + parsedData[0].effectivedate + "</p>";

                if (parsedData[0].type == '3rd Party') {
                    chequedetail.innerHTML += "<br/><h4><b>Sales Invoice  Details</h4>"
                    chequedetail.innerHTML += "<p><b>Received From</b> : " + parsedData[0].customer_name + "</p>";
                    chequedetail.innerHTML += "<p><b>Sales Invoice No</b> : " + parsedData[0].invoice + "</p>";
                    chequedetail.innerHTML += "<p><b>Sales Invoice Date</b> : " + parsedData[0].invoice_date + "</p>";
                    chequedetail.innerHTML += "<p><b>Cheque Received Date</b> : " + parsedData[0].createddate + "</p>";

                }

                if (parsedData[0].chalan_no != null) {
                    chequedetail.innerHTML += "<br/><h4><b>Pucharse Invoice  Details</h4>"
                    chequedetail.innerHTML += "<p><b>Transfered To</b> : " + parsedData[0].supplier_name + "</p>";
                    chequedetail.innerHTML += "<p><b>Purchase Invoice No</b> : " + parsedData[0].chalan_no + "</p>";
                    chequedetail.innerHTML += "<p><b>Purchase Invoice Date</b> : " + parsedData[0].purchase_date + "</p>";
                    chequedetail.innerHTML += "<p><b>Cheque Transferred Date</b> : " + parsedData[0].transfered + "</p>";
                }



                if (parsedData[0].chequestatus === 'Deposited') {
                    chequedetail.innerHTML += "<br/><h4><b>Deposited  Details</h4>"
                    chequedetail.innerHTML += "<p><b>Deposited Date</b> : " + parsedData[0].depositeddate + "</p>";
                    chequedetail.innerHTML += "<p><b>Deposited To</b> : " + parsedData[0].bank2 + "</p>";

                }


                chequedetail.innerHTML += "<br/><p><b>Amount</b> : " + parsedData[0].amount + "</p>";

                chequedetail.innerHTML += "<p><b>Cheque Status</b> : " + parsedData[0].chequestatus + "</p>";

                if (parsedData[0].chequestatus === 'Bounced') {
                    chequedetail.innerHTML += "<p><b>Bounced Date</b> : " + parsedData[0].updatedate + "</p>";
                }

                chequedetail.innerHTML += "<p><b>Last Updated Date</b> : " + parsedData[0].updatedate + "</p>";






            }
        });
    }
</script>