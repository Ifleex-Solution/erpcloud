<script src="<?php echo base_url() ?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('add_purchase') ?></h4>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open_multipart('purchase/purchase/bdtask_save_purchase', array('class' => 'form-vertical', 'id' => 'insert_purchase', 'name' => 'insert_purchase', 'onsubmit' => 'return validateForm()')) ?>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('supplier') ?>
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-6">
                                <select name="supplier_id" id="supplier_id" class="form-control " required="" tabindex="1">
                                    <option value=" "><?php echo display('select_one') ?></option>
                                    <?php foreach ($all_supplier as $suppliers) { ?>
                                        <option value="<?php echo $suppliers['supplier_id'] ?>">
                                            <?php echo $suppliers['supplier_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if ($this->permission1->method('add_supplier', 'create')->access()) { ?>
                                <div class="col-sm-2">
                                    <a class="btn btn-success" title="Add New Supplier" href="<?php echo base_url('add_supplier'); ?>"><i class="fa fa-user"></i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?>
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-8">
                                <?php
                                date_default_timezone_set('Asia/Colombo');

                                $date = date('Y-m-d'); ?>
                                <input type="text" required tabindex="2" class="form-control datepicker" name="purchase_date" value="<?php echo $date; ?>" id="date" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="chalan_no" class="col-sm-4 col-form-label"><?php echo display('chalan_no') ?>
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="3" class="form-control" name="chalan_no" placeholder="<?php echo display('chalan_no') ?>" id="chalan_no" required />
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="adress" class="col-sm-4 col-form-label"><?php echo display('details') ?>
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" tabindex="4" id="adress" name="purchase_details" placeholder=" <?php echo display('details') ?>" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                </div>


                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="purchaseTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="20%"><?php echo display('item_information') ?><i class="text-danger">*</i></th>
                                <th class="text-center"><?php echo display('stock_ctn') ?></th>
                                <th class="text-center"><?php echo display('expiry_date') ?></th>
                                <th class="text-center"><?php echo display('batch_no') ?><i class="text-danger">*</i></th>
                                <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i>
                                </th>
                                <th class="text-center"><?php echo display('rate') ?><i class="text-danger">*</i></th>
                                <?php if ($discount_type == 1) { ?>
                                    <th class="text-center invoice_fields"><?php echo display('discount_percentage') ?> %
                                    </th>
                                <?php } elseif ($discount_type == 2) { ?>
                                    <th class="text-center invoice_fields"><?php echo display('discount') ?> </th>
                                <?php } elseif ($discount_type == 3) { ?>
                                    <th class="text-center invoice_fields"><?php echo display('fixed_dis') ?> </th>
                                <?php } ?>
                                <th class="text-center invoice_fields"><?php echo display('dis_val') ?> </th>
                                <th class="text-center invoice_fields"><?php echo display('vat') . ' %' ?> </th>
                                <th class="text-center invoice_fields"><?php echo display('vat_val') ?> </th>
                                <th class="text-center"><?php echo display('total') ?></th>
                                <th class="text-center"><?php echo display('action') ?></th>
                            </tr>
                        </thead>
                        <tbody id="addPurchaseItem">
                            <tr>
                                <td class="span3 supplier">
                                    <input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list(1);" placeholder="<?php echo display('product_name') ?>" id="product_name_1" tabindex="5">

                                    <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId">

                                    <input type="hidden" class="sl" value="1">
                                </td>

                                <td class="wt">
                                    <input type="text" id="available_quantity_1" class="form-control text-right stock_ctn_1" placeholder="0.00" readonly />
                                </td>

                                <td class="wt">
                                    <input type="text" id="expiry_date_1" autocomplete="off" class="form-control datepicker expiry_date_1" placeholder="Expiry Date" name="expiry_date[]" />
                                </td>

                                <td class="wt">
                                    <input type="text" id="batch_no_1" class="form-control text-right batch_no_1" placeholder="Batch No" name="batch_no[]" required />
                                </td>

                                <td class="text-right">
                                    <input type="text" name="product_quantity[]" id="cartoon_1" required="" min="0" class="form-control text-right store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="" tabindex="6" />
                                </td>
                                <td class="test">
                                    <input type="text" name="product_rate[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="7" />
                                </td>
                                <!-- Discount start-->
                                <td>
                                    <input type="text" name="discount_per[]" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="discount_1" class="form-control discount_1 text-right" min="0" tabindex="11" placeholder="0.00" />
                                    <input type="hidden" value="<?php echo $discount_type ?>" name="discount_type" id="discount_type_1">

                                </td>
                                <td>
                                    <input type="text" name="discountvalue[]" id="discount_value_1" class="form-control text-right discount_value_1 total_discount_val" min="0" tabindex="12" placeholder="0.00" readonly />
                                </td>
                                <!-- Discount end-->
                                <!-- VAT  start-->
                                <td>
                                    <input type="text" name="vatpercent[]" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="vat_percent_1" class="form-control vat_percent_1 text-right" min="0" tabindex="13" placeholder="0.00" />


                                </td>
                                <td>
                                    <input type="text" name="vatvalue[]" id="vat_value_1" class="form-control vat_value_1 text-right total_vatamnt" min="0" tabindex="14" placeholder="0.00" readonly />
                                </td>
                                <!-- VAT  end-->

                                <td class="text-right">
                                    <input class="form-control total_price text-right total_price_1" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />

                                    <input type="hidden" id="total_discount_1" class="" />
                                    <input type="hidden" id="all_discount_1" class="total_discount dppr" name="discount_amount[]" />
                                </td>
                                <td>



                                    <button class="btn btn-danger text-right red" type="button" value="<?php echo display('delete') ?>" onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>

                                <td class="text-right" colspan="10"><b><?php echo display('total') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="Total" class="text-right form-control" name="total" value="0.00" readonly="readonly" />
                                </td>
                                <td> <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onClick="addPurchaseOrderField1('addPurchaseItem')" tabindex="9"><i class="fa fa-plus"></i></button>

                                    <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url(); ?>" />
                                </td>
                            </tr>
                            <tr>

                                <td class="text-right" colspan="10"><b><?php echo display('purchase_discount') ?>:</b>
                                </td>
                                <td class="text-right">
                                    <input type="text" id="discount" class="text-right form-control discount total_discount_val" onkeyup="calculate_store(1)" name="discount" placeholder="0.00" value="" />
                                </td>

                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="10"><b><?php echo display('total_discount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="10"><b><?php echo display('ttl_val') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="total_vat_amnt" class="form-control text-right" name="total_vat_amnt" value="0.00" readonly="readonly" />
                                </td>
                            </tr>

                            <tr>

                                <td class="text-right" colspan="10"><b><?php echo display('grand_total') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="grandTotal" class="text-right form-control grandTotalamnt" name="grand_total_price" placeholder="0.00" value="00" readonly />
                                </td>
                                <td> </td>
                            </tr>
                            <tr>

                                <td class="text-right" colspan="10"><b><?php echo display('paid_amount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="paidAmount" class="text-right form-control" onKeyup="invoice_paidamount()" name="paid_amount" placeholder="0.00" value="" />
                                </td>
                                <td> </td>
                            </tr>
                            <tr>

                                <td class="text-right" colspan="10"><b><?php echo display('due_amount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="dueAmmount" class="text-right form-control" name="due_amount" value="0.00" readonly="readonly" />
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" name="finyear" value="<?php echo financial_year(); ?>">
                    <p hidden id="pay-amount"></p>
                    <p hidden id="change-amount"></p>
                    <div class="col-sm-6 table-bordered p-20">
                        <div id="adddiscount" class="display-none">
                            <div class="row no-gutters">
                                <div class="form-group col-md-6">
                                    <label for="payments" class="col-form-label pb-2"><?php echo display('payment_type'); ?></label>

                                    <?php $card_type = 111000001;
                                    $default_option = array('' => 'Select an option'); // Default option
                                    $all_pmethod = $default_option + $all_pmethod;
                                    echo form_dropdown('multipaytype[]', $all_pmethod, (!empty($card_type) ? $card_type : null), 'onchange = "check_creditsale(0)" required id="your_dropdown_id" class="card_typesl postform resizeselect form-control "') ?>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="4digit" class="col-form-label pb-2"><?php echo display('paid_amount'); ?></label>

                                    <input type="number" id="pamount_by_method" class="form-control number pay " name="pamount_by_method[]" value="" onkeyup="changedueamount()" placeholder="0" />

                                </div>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="form-group row">
                                    <div id="che_0" style="display:none;"> <input type="checkbox" id="checkbox_0" onclick="showHideDiv('0')"> Cheque Transaction</div>
                                </div>
                                <div id="myDiv_0" style="display:none;">
                                    <div style="margin-top: 20px;">
                                        <div class="form-group row">
                                            <label for="cheque_no" class="col-sm-4 col-form-label">Cheque No
                                                <i class="text-danger">*</i>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" tabindex="3" class="form-control" name="cheque_no[]" placeholder="Cheque No" id="cheque_no_0" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-4 col-form-label">Draft Date

                                            </label>
                                            <div class="col-sm-8">
                                                <?php
                                                date_default_timezone_set('Asia/Colombo');

                                                $date = date('Y-m-d'); ?>
                                                <input type="date" tabindex="2" class="form-control" name="draft_date[]" value="" id="draft_date0" />
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
                                                <input type="date" required tabindex="2" class="form-control" name="effective_date[]" value="<?php echo $date; ?>" id="effective_date0" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Description

                                            </label>
                                            <div class="col-sm-8">
                                                <textarea tabindex="3" class="form-control" name="description[]" placeholder="Description" id="description0"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="" id="add_new_payment">



                            </div>
                            <div class="form-group text-right">
                                <div class="col-sm-12 pr-0">
                                    <button type="button" id="add_new_payment_type" class="btn btn-success w-md m-b-5"><?php echo display('new_p_method'); ?></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-group row text-right">
                    <div class="col-sm-12 p-20">
                        <input type="submit" id="add_purchase" class="btn btn-primary btn-large" name="add-purchase" value="<?php echo display('submit') ?>" />

                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>

    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cheques</h4>
            </div>
            <div class="modal-body">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cheque No</th>
                            <th>Customer Name</th>
                            <th>Effective Date</th>
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
<script>
    var i = 0;
    $(document).on('click', '#add_new_payment_type', function() {


        var base_url = $('#base_url').val();
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var gtotal = $("#paidAmount").val();

        var total = 0;
        $(".pay").each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        var is_credit_edit = $('#is_credit_edit').val();
        if (total >= gtotal) {
            alert("Paid amount is exceed to Total amount.");

            return false;
        }
        i++;

        var url = base_url + "purchase/purchase/bdtask_showpaymentmodal1/" + i;
        $.ajax({
            type: "post",
            url: url,
            data: {
                is_credit_edit: is_credit_edit,
                csrf_test_name: csrf_test_name
            },
            success: function(data) {

                $($('#add_new_payment').append(data));
                var length = $(".number").length;
                var total3 = 0;
                $(".pay").each(function() {
                    total3 += parseFloat($(this).val()) || 0;
                });

                var nextamnt = gtotal - total3;


                $(".number:eq(" + (length - 1) + ")").val(nextamnt.toFixed(2, 2));
                var total2 = 0;
                $(".number").each(function() {
                    total2 += parseFloat($(this).val()) || 0;
                });
                var dueamnt = parseFloat(gtotal) - total2

            }
        });
    });

    function showHideDiv(id) {
        var divId = "myDiv_" + id;
        if ($('#checkbox_' + id).prop('checked')) {
            $('#' + divId).show();
        } else {
            $('#' + divId).hide();
            $('#cheque_no_' + id).val("");
            $('#description' + id).val("");


        }
    }

    function validateForm() {

        var elements = document.getElementsByName("cheque_no[]");
        const array = [];
        var csrf_test_name = $('[name="csrf_test_name"]').val();
        var is_credit_edit = $('#is_credit_edit').val();



        for (var i = 0; i < elements.length; i++) {
            console.log(elements[i].value)
            if (elements[i].value != "") {
                if (array.some(item => item === elements[i].value)) {
                    alert("Can't use 1 perticular cheque number 2 times ");
                    return false;
                } else {
                    array.push(elements[i].value)
                }

            }
        }


       // var elements2 = document.getElementsByName("multipaytype[]");

        // for (var j = 0; j < elements2.length; j++) {
        //     if(elements2[j].value ==""){
        //         alert("Not valid payment type please check")
        //     }
        //     // (function(j) {
        //     //     var url2 = $('#base_url').val() + "purchase/purchase/bdtask_typeofthepayment/" + elements2[j].value;
        //     //     console.log(elements2[j].value);

        //     //     $.ajax({
        //     //         type: "post",
        //     //         url: url2,
        //     //         data: {
        //     //             is_credit_edit: is_credit_edit,
        //     //             csrf_test_name: csrf_test_name
        //     //         },
        //     //         success: function(data) {
        //     //             var parsedData = JSON.parse(data);
        //     //             if (parsedData[0].HeadName === '3rd party cheque') {
        //     //                 console.log(elements[j].value); 
        //     //             }
        //     //         }
        //     //     });
        //     // })(j);
        // }
        return true;
    }

    function handleTableClick(rowId, customerId, amount, id, chequeno, draftdate, effectivedate, description) {
        // Parse JSON string back to object
        // rowData = JSON.parse(rowData);
        // Handle click here
        if (id == 0) {
            $('#pamount_by_method').val(amount);
            $('#pamount_by_method').prop('readonly', true);


        } else {
            $('#pamount_by_method' + id).val(amount);
            $('#pamount_by_method' + id).prop('readonly', true);


        }
        $('#' + "che_" + id).hide();
        $('#' + "myDiv_" + id).show();


        $('#cheque_no_' + id).val(chequeno);
        $('#cheque_no_' + id).prop('readonly', true);

        $('#draft_date' + id).val(draftdate);
        $('#draft_date' + id).prop('readonly', true);


        $('#effective_date' + id).val(effectivedate);
        $('#effective_date' + id).prop('readonly', true);


        //    $('#description' + id).val(description);
        // $('#description' + id).prop('readonly', true);




        $("#exampleModal").modal('hide');




        // You can access properties of rowData as needed
    }

    function check_creditsale(id) {
        $('#cheque_no_' + id).prop('readonly', false);
        // $('#description' + id).prop('readonly', false);
        $('#draft_date' + id).prop('readonly', false);
        $('#effective_date' + id).prop('readonly', false);
        if (id == 0) {
            $('#pamount_by_method').prop('readonly', false);


        } else {
            $('#pamount_by_method' + id).prop('readonly', false);


        }
        var elements = document.getElementsByName("multipaytype[]");
        if (elements[id].value != 0) {
            var url = $('#base_url').val() + "purchase/purchase/bdtask_typeofthepayment/" + elements[id].value;
            $.ajax({
                type: "post",
                url: url,
                data: {
                    is_credit_edit: is_credit_edit,
                    csrf_test_name: csrf_test_name
                },
                success: function(data) {
                    var parsedData = JSON.parse(data);



                    if (parsedData[0].HeadName === '3rd party cheque') {

                        $('#cheque_no_' + id).val("");
                        $('#description' + id).val("");
                        $("#exampleModal").modal('show');
                        var url1 = $('#base_url').val() + "purchase/purchase/getallcheques";
                        $.ajax({
                            type: "post",
                            url: url1,
                            data: {
                                csrf_test_name: csrf_test_name,
                                is_credit_edit: is_credit_edit
                            },
                            success: function(data1) {

                                var parsedData1 = JSON.parse(data1);
                                console.log(parsedData1);
                                $('#example').DataTable({
                                    "bDestroy": true,
                                    "data": parsedData1, // Use parsed data as the DataTable source
                                    "columns": [{
                                            "data": "cheque_no"
                                        },
                                        {
                                            "data": "customer_name"
                                        },
                                        {
                                            "data": "effectivedate"
                                        },
                                        {
                                            "data": "amount"
                                        },
                                        {
                                            "data": "status"
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

                                                    return '<button class="btn btn-primary" onclick="handleTableClick(' + row.id + ',' + row.customer_id + ',' + row.amount + ',' + id + ',\'' + row.cheque_no + '\',\'' + row.draftdate + '\',\'' + row.effectivedate + '\',\'' + row.description + '\')">Call</button>';
                                                } else {
                                                    return ''; // Return empty string if row is null or undefined
                                                }
                                            }
                                        }

                                    ]
                                });
                            }
                        });


                    } else if (parsedData[0].PHeadName === 'Cash at Bank') {
                        $('#' + "che_" + id).show();
                        $('#' + "myDiv_" + id).hide();
                        $('#cheque_no_' + id).val("");
                        $('#description' + id).val("");
                        $('#draft_date' + id).val("");
                        $('#effective_date' + id).val(new Date().toISOString().slice(0, 10));




                    } else {
                        $('#' + "che_" + id).hide();
                        $('#' + "myDiv_" + id).hide();
                        $('#cheque_no_' + id).val("");
                        $('#description' + id).val("");
                        $('#draft_date' + id).val("");
                        $('#effective_date' + id).val(new Date().toISOString().slice(0, 10));


                    }


                }
            });
        }





        // $('#add_new_payment').append("<h1>Thayaan</h1><h1>Thayaan</h1><h1>Thayaan</h1><h1>Thayaan</h1>");
        // // Get all elements with the name "multipaytype[]"
        // var elements = document.getElementsByName("multipaytype[]");



        // Loop through the elements (if there are multiple)
        // for (var i = 0; i < elements.length; i++) {
        //     // Do something with each element
        //     console.log(elements[i].value);
        // }

        // Select the appended elements inside the element with ID "add_new_payment"
        // var appendedElements = $('#add_new_payment').children();

        // // Loop through the selected elements
        // appendedElements.each(function(index, element) {
        //     // Retrieve the text of each element
        //     var text = $(element).text();

        //     // Log or do something with the text
        //     console.log("Appended value: " + text);
        // });

        var card_typesl = $('.card_typesl').val();
        if (card_typesl == 0) {
            $("#add_new_payment").empty();
            var gtotal = $(".grandTotalamnt").val();
            $("#pamount_by_method").val(gtotal);
            $("#paidAmount").val(0);
            $("#dueAmmount").val(gtotal);
            $(".number:eq(0)").val(0);
            $("#add_new_payment_type").prop('disabled', true);

        } else {
            $("#add_new_payment_type").prop('disabled', false);
        }
        $("#pay-amount").text('0');

        var purchase_edit_page = $("#purchase_edit_page").val();
        var is_credit_edit = $('#is_credit_edit').val();
        if (purchase_edit_page == 1 && card_typesl == 0) {

            $("#add_new_payment").empty();
            var base_url = $('#base_url').val();
            var csrf_test_name = $('[name="csrf_test_name"]').val();
            var gtotal = $(".grandTotalamnt").val();
            var url = base_url + "purchase/purchase/bdtask_showpaymentmodal";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    csrf_test_name: csrf_test_name,
                    is_credit_edit: is_credit_edit
                },
                success: function(data) {
                    $('#add_new_payment').append(data);
                    $("#pamount_by_method").val(gtotal);
                    $("#add_new_payment_type").prop('disabled', true);
                }
            });

        }
    }
</script>