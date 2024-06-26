<!-- Invoice js -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>



<!--Add Invoice -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <span><?php echo display('new_invoice') ?></span>
                    <span class="padding-lefttitle">
                        <?php if ($this->permission1->method('manage_invoice', 'read')->access()) { ?>
                            <a href="<?php echo base_url('invoice_list') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_invoice') ?> </a>
                        <?php } ?>
                        <?php if ($this->permission1->method('pos_invoice', 'create')->access()) { ?>
                            <a href="<?php echo base_url('gui_pos') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('pos_invoice') ?> </a>
                        <?php } ?></span>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open_multipart('invoice/invoice/bdtask_manual_sales_insert', array('class' => 'form-vertical', 'id' => 'insert_sale', 'name' => 'insert_sale', 'onsubmit' => 'return validateFormWrapper()')) ?>
                <div class="row">

                    <div class="col-sm-6" id="payment_from_1">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label"><?php
                                                                                        echo display('customer_name') . '/' . display('phone');
                                                                                        ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" size="100" name="customer_name" class=" form-control" placeholder='<?php echo display('customer_name') . '/' . display('phone') ?>' id="customer_name" tabindex="1" onkeyup="customer_autocomplete()" value="<?php echo $customer_name ?>" />

                                <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden" name="customer_id" value="<?php echo $customer_id ?>">
                            </div>
                            <?php if ($this->permission1->method('add_customer', 'create')->access()) { ?>
                                <div class=" col-sm-3">
                                    <a href="#" class="client-add-btn btn btn-success" aria-hidden="true" data-toggle="modal" data-target="#cust_info"><i class="ti-plus m-r-2"></i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <?php
                                date_default_timezone_set('Asia/Colombo');

                                $date = date('Y-m-d');
                                ?>
                                <input class="datepicker form-control" type="text" size="50" name="invoice_date" id="date" required value="<?php echo html_escape($date); ?>" tabindex="4" />
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6" id="bank_div">
                        <div class="form-group row">
                            <label for="bank" class="col-sm-3 col-form-label"><?php
                                                                                echo display('bank');
                                                                                ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="bank_id" class="form-control bankpayment" id="bank_id">
                                    <option value="">Select Location</option>
                                    <?php foreach ($bank_list as $bank) { ?>
                                        <option value="<?php echo html_escape($bank['bank_id']) ?>">
                                            <?php echo html_escape($bank['bank_name']); ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="normalinvoice">
                        <thead>
                            <tr>
                                <th class="text-center product_field"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                <th class="text-center"><?php echo display('item_description') ?></th>
                                <th class="text-center"><?php echo display('batch_no') ?><i class="text-danger">*</i>
                                </th>
                                <th class="text-center"><?php echo display('available_qnty') ?></th>
                                <th class="text-center"><?php echo display('unit') ?></th>
                                <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i>
                                </th>
                                <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th>

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
                                <th class="text-center invoice_fields"><?php echo display('total') ?>
                                </th>
                                <th class="text-center"><?php echo display('action') ?></th>
                            </tr>
                        </thead>
                        <tbody id="addinvoiceItem">
                            <tr>
                                <td class="product_field">
                                    <input type="text" required name="product_name" onkeypress="invoice_productList(1)" id="product_name_1" class="form-control productSelection" placeholder="<?php echo display('product_name') ?>" tabindex="5">

                                    <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId" />

                                    <input type="hidden" class="baseUrl" value="<?php echo base_url(); ?>" />
                                </td>
                                <td>
                                    <input type="text" name="desc[]" class="form-control text-right " tabindex="6" />
                                </td>
                                <td class="invoice_fields">
                                    <select class="form-control basic-single" onchange="invoice_product_batch(1)" id="serial_no_1" required name="serial_no[]" tabindex="7">
                                        <option></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_1" value="0" readonly="" />
                                </td>
                                <td>
                                    <input name="" id="" class="form-control text-right unit_1 valid" value="None" readonly="" aria-invalid="false" type="text">
                                </td>
                                <td>
                                    <input type="text" name="product_quantity[]" required="" onkeyup="bdtask_invoice_quantity_calculate(1);" onchange="bdtask_invoice_quantity_calculate(1);" class="total_qntt_1 form-control text-right" id="total_qntt_1" placeholder="0.00" min="0" tabindex="8" value="1" />
                                </td>
                                <td class="invoice_fields">
                                    <input type="text" name="product_rate[]" id="price_item_1" class="price_item1 price_item form-control text-right" tabindex="9" required="" onkeyup="bdtask_invoice_quantity_calculate(1);" onchange="bdtask_invoice_quantity_calculate(1);" placeholder="0.00" min="0" />
                                </td>
                                <!-- Discount -->
                                <td>
                                    <input type="text" name="discount[]" onkeyup="bdtask_invoice_quantity_calculate(1);" onchange="bdtask_invoice_quantity_calculate(1);" id="discount_1" class="form-control text-right" min="0" tabindex="10" placeholder="0.00" />
                                    <input type="hidden" value="<?php echo $discount_type ?>" name="discount_type" id="discount_type_1">

                                </td>
                                <td>
                                    <input type="text" name="discountvalue[]" id="discount_value_1" class="form-control text-right" min="0" tabindex="18" placeholder="0.00" readonly />
                                </td>

                                <!-- VAT  -->
                                <td>
                                    <input type="text" name="vatpercent[]" onkeyup="bdtask_invoice_quantity_calculate(1);" onchange="bdtask_invoice_quantity_calculate(1);" id="vat_percent_1" class="form-control text-right" min="0" tabindex="19" placeholder="0.00" />

                                </td>
                                <td>
                                    <input type="text" name="vatvalue[]" id="vat_value_1" class="form-control text-right total_vatamnt" min="0" tabindex="20" placeholder="0.00" readonly />
                                </td>
                                <!-- VAT end -->

                                <td class="invoice_fields">
                                    <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                </td>

                                <td>


                                    <!-- Discount calculate start-->
                                    <input type="hidden" id="total_discount_1" class="" />
                                    <input type="hidden" id="all_discount_1" class="total_discount dppr" name="discount_amount[]" />
                                    <!-- Discount calculate end -->

                                    <button class='btn btn-danger text-right' type='button' value='Delete' onclick='deleteRow_invoice(this)'><i class='fa fa-close'></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10" rowspan="2">
                                    <center><label for="details" class="  col-form-label text-center"><?php echo display('invoice_details') ?></label>
                                    </center>
                                    <textarea name="inva_details" id="details" class="form-control" placeholder="<?php echo display('invoice_details') ?>" tabindex="12"></textarea>
                                </td>
                                <td class="text-right" colspan="1"><b><?php echo display('invoice_discount') ?>:</b>
                                </td>
                                <td class="text-right">
                                    <input type="text" onkeyup="bdtask_invoice_quantity_calculate(1);" onchange="bdtask_invoice_quantity_calculate(1);" id="invoice_discount" class="form-control text-right total_discount" name="invoice_discount" placeholder="0.00" tabindex="13" />
                                    <input type="hidden" id="txfieldnum">
                                </td>
                                <td><a href="javascript:void(0)" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onClick="addInputField_invoice('addinvoiceItem');" tabindex="11"><i class="fa fa-plus"></i></a></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="1"><b><?php echo display('total_discount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="11"><b><?php echo display('ttl_val') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="total_vat_amnt" class="form-control text-right" name="total_vat_amnt" value="0.00" readonly="readonly" />
                                </td>
                            </tr>

                            <tr>
                            <tr>
                                <td class="text-right" colspan="11"><b><?php echo display('shipping_cost') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="shipping_cost" class="form-control text-right" name="shipping_cost" onkeyup="bdtask_invoice_quantity_calculate(1);" onchange="bdtask_invoice_quantity_calculate(1);" placeholder="0.00" tabindex="14" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-right"><b><?php echo display('grand_total') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="grandTotal" class="form-control text-right grandTotalamnt" name="grand_total_price" value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-right"><b><?php echo display('previous'); ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="previous" class="form-control text-right" name="previous" value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="text-right"><b><?php echo display('net_total'); ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="n_total" class="form-control text-right" name="n_total" value="0" readonly="readonly" placeholder="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="11"><b><?php echo display('paid_ammount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url(); ?>" />
                                    <input type="text" id="paidAmount" onkeyup="invoice_paidamount();" class="form-control text-right" name="paid_amount" placeholder="0.00" tabindex="15" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="11"><b><?php echo display('due') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" value="0.00" readonly="readonly" />
                                </td>
                            </tr>
                            <tr>

                                <td colspan="11" class="text-right"><b><?php echo display('change'); ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="change" class="form-control text-right" name="change" value="0" readonly="readonly" placeholder="" />
                                    <input type="hidden" name="is_normal" value="1">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" name="finyear" value="<?php echo financial_year(); ?>">
                    <p hidden id="old-amount"><?php echo 0; ?></p>
                    <p hidden id="pay-amount"></p>
                    <p hidden id="change-amount"></p>
                    <div class="col-sm-6 table-bordered p-20">
                        <div id="adddiscount" class="display-none">
                            <div class="row no-gutters">
                                <div class="form-group col-md-6">
                                    <label for="payments" class="col-form-label pb-2"><?php echo display('payment_type'); ?></label>

                                    <?php
                                    $card_type = 1020101;
                                    echo form_dropdown('multipaytype[]', $all_pmethod, (!empty($card_type) ? $card_type : null), ' onchange = "check_creditsale(0)" class="card_typesl postform resizeselect form-control "') ?>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="4digit" class="col-form-label pb-2"><?php echo display('paid_amount'); ?></label>

                                    <input type="text" id="pamount_by_method" class="form-control number pay " name="pamount_by_method[]" value="" onkeyup="changedueamount()" placeholder="0" />

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
                                                <input type="text" tabindex="3" class="form-control" name="cheque_no[]" placeholder="Cheque No" id="cheque_no_0" onkeypress="handleKeyPress(event,'0')" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-4 col-form-label">Draft Date

                                            </label>
                                            <div class="col-sm-8">
                                                <?php
                                                date_default_timezone_set('Asia/Colombo');

                                                $date = date('Y-m-d'); ?>
                                                <input type="date" tabindex="2" class="form-control" name="draft_date[]" value="" id="date" />
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
                                                <input type="date" required tabindex="2" class="form-control" name="effective_date[]" value="<?php echo $date; ?>" id="date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Description

                                            </label>
                                            <div class="col-sm-8">
                                                <textarea tabindex="3" class="form-control" name="description[]" placeholder="Description" id="description"></textarea>

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
                        <input type="submit" id="add_invoice" class="btn btn-success" name="add-invoice" value="<?php echo display('submit') ?>" tabindex="17" />

                    </div>
                </div>
                <?php echo form_close() ?>
            </div>

        </div>
    </div>


</div>
<script>
    function printRawHtml(view) {
        printJS({
            printable: view,
            type: 'raw-html',

        });

    }

    function handleKeyPress(event, id) {
        const key = event.key;

        var invoice_edit_page = $("#invoice_edit_page").val();
        var is_credit_edit = $('#is_credit_edit').val();

        var url = $('#base_url').val() + "invoice/invoice/checkCheque/" + $('#cheque_no_' + id).val() + key;
        $.ajax({
            type: "post",
            url: url,
            data: {
                is_credit_edit: is_credit_edit,
                csrf_test_name: invoice_edit_page
            },
            success: function(data) {
                var parsedData = JSON.parse(data);

                if (parsedData.length > 0) {
                    $('#cheque_no_' + id).val('')
                    alert("This Cheque Number already exsist")
                }


            }
        });

    }

    var i = 0;

    async function checkCheque(id) {
        return new Promise((resolve, reject) => {
            let url = $('#base_url').val() + "invoice/invoice/checkCheque/" + $('#cheque_no_' + id).val();
            $.ajax({
                type: "get",
                url: url,
                success: function(data) {
                    var parsedData = JSON.parse(data);
                    if (parsedData.length > 0) {
                        alert($('#cheque_no_' + id).val() + " Cheque Number already exists");
                        $('#cheque_no_' + id).val('');
                        resolve(false);
                    } else {
                        resolve(true);
                    }
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }

    function validateFormWrapper() {
        validateForm().then(function(result) {
            if (result) {
                document.getElementById('insert_sale').submit();
            }
        });
        return false; // Prevent the form from submitting immediately
    }

    async function validateForm() {
        const array = [];
        for (var j = 0; j < i + 1; j++) {
            let element = document.getElementById("myDiv_" + j);
            let displayProperty = element.style.display;
            if (displayProperty == '') {
                if ($('#cheque_no_' + j).val() === '') {
                    alert("Please enter the cheque no")
                    return false;
                } else {

                    let a = await checkCheque(j);
                    if (!a) {
                        return false;
                    } else {
                        if (array.some(item => item === $('#cheque_no_' + j).val())) {
                            alert("Can't use 1 perticular cheque number 2 times ");
                            return false;
                        } else {
                            array.push($('#cheque_no_' + j).val())
                        }

                    }
                }
            }
        }

        return true;
    }


    // ******* new payment add start *******
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
        var url = base_url + "invoice/invoice/bdtask_showpaymentmodal/" + i;
        $.ajax({
            type: "post",
            url: url,
            data: {
                is_credit_edit: is_credit_edit,
                csrf_test_name: csrf_test_name
            },
            success: function(data) {
                $($('#add_new_payment').append(data)).show("slow", function() {});
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

        }
    }

    function check_creditsale(id) {

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
                        $('#' + "che_" + id).hide();
                        $('#' + "myDiv_" + id).show();

                    }
                    //  else if (parsedData[0].PHeadName === 'Cash at Bank') {
                    //     $('#' + "che_" + id).show();
                    //     $('#' + "myDiv_" + id).hide();

                    // } 
                    else {
                        $('#' + "che_" + id).hide();
                        $('#' + "myDiv_" + id).hide();
                        $('#cheque_no_' + id).val("");
                    }


                }
            });
        }

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

        var invoice_edit_page = $("#invoice_edit_page").val();
        var is_credit_edit = $('#is_credit_edit').val();
        if (invoice_edit_page == 1 && card_typesl == 0) {
            $("#add_new_payment").empty();

            var base_url = $('#base_url').val();
            var csrf_test_name = $('[name="csrf_test_name"]').val();
            var gtotal = $(".grandTotalamnt").val();
            var url = base_url + "invoice/invoice/bdtask_showpaymentmodal";
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