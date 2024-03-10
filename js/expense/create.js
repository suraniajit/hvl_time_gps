//$(document).ready(function () {
//    $("#formValidateExpense").validate({
//        rules: {
//            "expense_type": {
//                required: true,
//            },
//            "is_active": {
//                required: true,
//            },
//            "expense_type_document[]": {
//                extension: "png|jpeg|jpg",
//                required: true,
//                filesize: 1048576
//            },
//            "total_amount_cash": {
//                required: true,
//                number: true
//            },
//            "spent_at_cash": {
//                required: true
//            },
//            "date_of_expense_cash": {
//                required: true
//            },
//            "city_id_cash": {
//                required: true,
//            },
//            "account_premises_no_cash": {
//                required: true
//            },
//            "card_used_cash": {
//                required: true
//            },
//            "account_name_cash": {
//                required: true
//            },
//            "ddl_department_cash": {
//                required: true,
//            },
//            "category_id_cash": {
//                required: true
//            },
//            "sub_category_id_cash": {
//                required: true
//            },
//            "payment_method_id_cash": {
//                required: true
//            },
//            "payment_status_id_cash": {
//                required: true
//            },
//            "multi_day_from_date_cash": {
//                required: true
//            },
//            "multi_day_to_date_cash": {
//                required: true
//            }
//        },
//        messages: {
//            "expense_type": {
//                required: 'Select Expense Type',
//            },
//            "is_active": {
//                required: 'Select Status',
//            },
//            "expense_type_document[]": {
//                required: 'Select Status',
//                extension: "File must be JPEG or PNG, less than 1MB",
//                filesize: "less than 1MB"
//            },
//            "total_amount_cash": {
//                required: 'Enter Amount'
//            },
//            "spent_at_cash": {
//                required: 'Enter Spent At'
//            },
//            "date_of_expense_cash": {
//                required: 'Select Date of Expance'
//            },
//            "city_id_cash": {
//                required: 'Enter City '
//            },
//            "account_premises_no_cash": {
//                required: 'Select Account No / Premises No'
//            },
//            "card_used_cash": {
//                required: 'Enter Card Used'
//            },
//            "account_name_cash": {
//                required: 'Enter Account Name'
//            },
//            "ddl_department_cash": {
//                required: 'Select Department'
//            },
//            "category_id_cash": {
//                required: 'Select Category'
//            },
//            "sub_category_id_cash": {
//                required: 'Select Sub Category'
//            },
//            "payment_method_id_cash": {
//                required: 'Select Payment Method'
//            },
//            "payment_status_id_cash": {
//                required: 'Select Payment Status'
//            },
//            "multi_day_from_date_cash": {
//                required: "Select Multi Day From Date"
//            },
//            "multi_day_to_date_cash": {
//                required: "Select Multi Day To Date"
//            }
//        },
//        errorElement: 'div',
//        errorPlacement: function (error, element) {
//            var placement = $(element).data('error');
//            if (placement) {
//                $(placement).append(error)
//            } else {
//                error.insertAfter(element);
//            }
//        }
//    });
//});
