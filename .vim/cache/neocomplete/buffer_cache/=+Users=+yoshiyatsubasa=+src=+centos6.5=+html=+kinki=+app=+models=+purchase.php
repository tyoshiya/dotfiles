{'class', 'Purchase', 'extends', 'AppModel', '$name', '$type', 'array', '$validate', 'rule1', 'method', 'isNumeric', 'message', 'attention', 'rule2', 'isLengthWithin', 'parameters', 'order_date', 'isNotNull', 'isDate', 'delimitter', 'yyyy', 'supplier_id', 'subtotal', 'isNumericOrFloat', 'clean', 'true', 'total', '$validate_del', 'rule3', 'rule4', 'isExist', '$validate_outsource_payment_edit', 'type', '$validate_search_invoice_customer', 'receipt_date', 'isPattern', 'pattern', 'close_day', '$validate_daily_index', 'order_date_from', 'order_date_to', '$validate_master_index', '$validate_sum_material_total', '$validate_sum_account', '$validate_sum_monthly_material_price', 'created', '$validate_sum_customer', '$validate_data_link', 'function', 'afterFind', '$result', 'foreach', '$row', 'isset', '$this', 'name', 'date', 'strtotime', 'return', 'param', '$data', '$order_type', 'getSearchIndex', 'bindModel', 'belongsTo', 'Supplier', 'className', 'Customer', 'foreignKey', 'order_type', 'factory_id', '$_SESSION', 'site', 'user', 'empty', 'code', 'findAll', 'delFunc', 'delete', 'model', 'PurchaseDetail', 'findAllDell', 'purchase_id', 'getMasterIndex', '$ret', '$purchase_type', 'Material', 'purchase_type', '$date_from', '$date_to', '$args', 'code_from', 'supplier_code_from', 'code_to', 'supplier_code_to', 'Payable', 'formated_date', '$purchase_details', 'getPurchaseDetail', '$formated_date', '$supplier_code', 'sum_subtotal', 'sum_tax', 'sum_total', 'sum_amount', 'sum_other_tax', '$foo', 'getStrId', 'order_number', 'purchaseorder_id', 'Purchaseorder', 'image_number', 'name2', 'short_name', 'quantity', 'defective', 'null', 'price', 'memo', 'note', 'tax_calc_type', 'calcTax', 'tax_round_type', 'amount', 'data', 'else', '$manufacture_results', 'ManufactureResult', 'getInspection', 'manufacture_id', 'Manufacture', 'Product', 'approve', 'ProductPurchasePrice', '$from', '$offset_total', 'MaterialOffset', 'month', '$material_supplies', 'getIndexData', '$jobber_customer_code', '$bar', 'JobberCustomer', 'value_round_type', '$manufacture_id', '$buz', '$key', 'while', '$payables', 'PayableDetail', 'getPayable', '$types', '$rd_key', '$rd_row', 'payment_date', '$tmp', 'explode', '$tmp_format_date', 'substr', 'prev_balance', 'PayableSummary', 'getPrevBalance', '$balance', '$order_date_sort', 'unset', 'array_multisort', 'SORT_ASC', 'elseif', 'balance', 'getSumMaterialTotal', '$res', 'getSumMaterialTotalData', '$customer_code', 'false', 'total_quantity', 'total_subtotal', 'sum_quantity', '$material_code', '$price', 'ksort', '$qux', 'getCsvSumMaterialTotal', '$hoge', 'private', '$sql', 'select', 'date_format', 'from', 'purchase_details', 'left', 'outer', 'join', 'materials', 'material_id', 'purchases', 'customers', 'purchaseorders', 'deliv_customer_id', 'where', 'del_flg', '$order_date_from', '$order_date_to', 'between', 'cast', 'signed', 'group', 'order', 'query', 'getSumMonthlyMaterialPrice', '$conditions', '$fields', 'firsttime_price', '$order', '$materials', '$dates', '$material', 'MaterialRevision', '$revi', '$revis', '$unix_material_created', '$unix_date_to', '$prev_price', '$dkey', '$date', 'prices', '$unix_first_date_from', '$unix_created', 'array_reverse', '$unix_date_from', '$comp', '$date_key', 'start_equal', 'material_revisions', 'revision', 'desc', 'limit', '$material_revisions', 'getPaymentEditData', 'fields', 'hasMany', 'findById', 'dbug', 'exit', 'loadModel', '$field', '$val', 'purchase_type_name_', 'savePaymentEdit', '__isDistinct', 'save', 'purchase', 'create', 'getLastInsertId', '$save_cols', 'purchaseorder_id_', '$saves', 'material_id_', 'quantity_', 'price_', 'subtotal_', 'tax_', 'total_', 'name_', 'name2_', 'image_number_', 'note_', 'type_', 'getPdfInvoiceCustomerData', 'product_image_number', 'product_code', 'jobber_customer_code', 'jobber_customer_name', 'products', 'product_id', '$receipt_date_from', '$receipt_date_to', 'jobber_customer_id', 'afterfind', 'groupbydate', 'genarrcsvinvoicecustomer', '$csvs', '$cnt', '$total', '$strdate', '$last_key', 'getlastkey', '$vals', 'getstrid', 'purchaseorder', 'getpdfinvoicedetaildata', 'deliv_date', 'deliv_client_name', 'deliv_client_name2', 'client_name', 'client_name2', 'groupbyjobbercustomer', 'genarrcsvinvoicedetail', '$strorderdate', '$arr', '$arr2', 'lists', 'getSumCustomerData', '$class', 'total_prev_balance', 'total_amount', 'total_hurikae', 'total_offset', 'total_forward', 'total_tax', 'total_total', 'total_balance', '_setDefault', 'sum_', 'back', 'payables', 'getPayableDetail', 'hurikae', 'offset', 'discount', '$material_offsets', 'forward', 'sum_prev_balance', 'sum_hurikae', 'sum_discount', 'sum_offset', 'sum_forward', 'sum_purchase', 'sum_back', 'sum_balance', 'public', '$prefix', 'genarrcsvsumcustomer', '$total1', '$total2', '$total3', '$total4', '$total5', '$total6', '$total7', '$total8', '$total9', '$total10', '$total11', '$total12', 'payablesummary', 'payable1', 'payable5', 'payable8', 'purchase1', 'purchase2', 'purchase3', 'purchase_subtotal', 'purchase_tax', 'getDailyIndexData', 'inner', '$purchases', '$supplier_id', 'material_name', 'material_name2', 'product_name', 'product_name2', 'purchase_type_name', 'customer_id', 'calcSubtotal', 'getSumAccountData', 'pdfinvoicecustomer', 'vendor', 'fpdf', 'japanese', 'defined', 'fpdf_fontpath', 'define', 'font', 'sc_char', 'utf8', '$pdf', 'pdf_japanese', 'sjis', 'addsjisfont', '_pdf_font', '_pdf_family', 'open', 'sets', '$font_size', 'setfont', 'setxy', 'setmargins', 'addpage', '$add_y', 'cell', 'sjis_conv', 'jobber_customer_name2', 'deliv_customer_code', 'deliv_customer_name', 'deliv_customer_name2', 'client_code', 'output', 'pdfinvoicedetail', 'outputdetailheader', '$page', '$receipt_date', 'time', 'page', 'line', '$base_y', '$add_base_y', '$row_spacing', '$total_add_y', 'number_format', 'str_replace', 'apo_deliv_date', 'apo_deliv_date_memo', 'note2', 'note3', 'deliv_client_code', 'deliv_client_name3', 'client_name3', '$search_receipt_date', '$date_format', '$receipt_dates', 'switch', 'case', 'break', '$deliv_dates', '$jobber_customer_id', 'getDataLink', 'makeCsvDataLink', 'getPurchase', 'DATE_FORMAT', 'getSumTotal', '$supplier_code_from', '$supplier_code_to', 'checkDistinct', 'ctype_digit', '$purchase_detail_column', 'showColumns', '$excludes', 'modified', 'tax_rate', '$column_names', '$col', '$col_name', 'COLUMNS', 'Field', 'in_array', '$flg2', 'distinct', '_PURCHASE_DETAIL_NUM', '$flg3', '$val2'}
