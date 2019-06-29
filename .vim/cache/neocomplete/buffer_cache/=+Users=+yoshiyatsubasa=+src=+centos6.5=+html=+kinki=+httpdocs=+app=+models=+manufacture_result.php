{'class', 'ManufactureResult', 'extends', 'AppModel', '$name', '$acceptance_type', 'array', '$status', '$material_type', '$order_type', '$result_type', '$action_type', '$accident_type', '$validate_acceptance', 'manufacture_id', 'rule1', 'method', 'isNotNull', 'message', 'attention', 'rule2', 'isNumeric', 'rule3', 'isLengthWithin', 'parameters', 'receipt_date', 'isDate', 'delimitter', 'yyyy', 'acceptance_type', 'delivery', 'clean', 'true', 'isLargeSubThanDelivery', 'rule4', 'isLargeDeliveryThanSub', 'factory_id', '$validate_inspection', 'product_id', 'order_date', 'inspection', 'defective', 'waste', 'quantity', 'result_type', 'staff_id', '$validate_modal_search_acceptabce', '$validate_accident', 'accident', '$validate_subcontracts_index3', 'order_date_from', 'order_date_to', '$validate_inspection_result_index', '$validate_subcontract', 'subcontract_id', 'approve', '$validate_outsource_index', 'isPattern', 'pattern', '$validate_modal_search_accident', 'staff_code', 'isPositiveNum', 'customer_code', 'product_code', 'factory_code', '$validate_accident_index', 'date_from', 'date_to', 'function', 'validation', 'rule', '$params', '$flg', '$this', 'data', '$val', 'name', '$manufacture_quaintity', 'str_replace', 'Manufacture', '$total_delivery', 'total_delivery', '$sub', 'false', 'return', 'status', 'sub_delivery', 'model', 'callback', 'afterFind', '$result', 'foreach', '$row', 'isset', 'ManufactureResultList', '$mrl_row', 'array_key_exists', 'today_delivery', 'empty', 'total_status2_delivery', '$controller', '$action', '$options', '$src', 'extract', 'switch', 'case', 'manufacture_results', 'acceptance_edit', 'bindModel', 'belongsTo', 'className', 'foreignKey', 'fields', 'Product', 'code', 'image_number', 'name2', 'Customer', 'customer_id', 'Factory', '$manufacture_results', 'findById', 'status_name', '$conditions', 'NULL', 'del_flg', '$fields', 'daily_receipt_number', '$order', '$histories', 'findAll', 'sum_today_delivery', 'break', 'accident_index', '$_SESSION', 'site', 'user', '$data', 'BETWEEN', 'else', 'accident_type', 'type', 'inspection_result_index', '$ret', 'Staff', 'hasMany', 'ManufactureInspectionDefect', 'manufacture_result_id', 'null', 'CAST', 'SIGNED', '$key', '$order_date', 'date', 'strtotime', 'unset', 'dbug', 'exit', 'outsource_index', '$order_date_from', '$order_date_to', '$sql', 'SELECT', 'price', 'delivery_deadline_date', 'supplier_id', 'Supplier', 'sum_delivery', 'FROM', 'manufactures', 'LEFT', 'OUTER', 'JOIN', 'customers', 'products', 'users', 'GROUP', 'WHERE', 'ORDER', '$manufactures', 'query', 'loadModel', 'ProductMaterial', '$material_code', 'material_code', '$staff_id', '$supplier_id', 'rank', '$product_materials', '$type_names', '$pm_row', 'mb_substr', 'type_name', 'implode', 'outsource_unfinished_index', 'sum_approve', '$supplier', 'getInspection', 'select', 'formated_date', 'DATE_FORMAT', 'from', 'inner', 'join', 'where', 'supplier_code_from', 'cast', 'signed', 'supplier_code_to', 'close_day', 'order', '$manufacture_result', '$purchase_price', 'ProductPurchasePrice', 'desc', 'subtotal', 'calcSubtotal', 'value_round_type', 'calcTax', 'tax_round_type', 'total', 'saveFunc', 'subcontract_edit', 'Subcontract', '$product_id', '$factory_id', '$type', '$order_id', 'ProductHistory', 'deleteHistory', '$subcontracts', 'next_daily_receipt_number', '$res', 'save', 'getLastInsertId', 'updateStatus', '$quantity', 'saveHistory', 'inspection_edit', '$current_manufacture_results', 'findAllDell', '$saves', 'create', '$defective', 'PayableSummary', 'saveManufactureResult', '$product_components', 'ProductComponent', '$required', 'calcRequired', 'bottom_quantity', 'part_product_id', 'checkAcceptanceId', 'deleteAccident', 'dead', 'saveStock', 'mode', '$MID', '$mid_ids', 'findSingle', 'delete', 'deleteSubContractEdit', '$arr', 'parent_id', '$product_history_ids', '$product_history_id', 'getAcceptanceIndexData', 'getAccidentEditData', 'action_type', 'Client', 'left', 'outer', 'factories', '$mids', 'getAjaxGetBeforeQuantityData', '$manufacture_id', 'before_quantity', 'getAjaxGetIdAcceptanceEdit', 'getAjaxGetIdInEditData', '$manufacture_schedule_id', '$daily_receipt_number', 'manufacture_schedule_id', 'getAjaxGetInSubcontractEdit', 'getAjaxGetTodayTotal', 'getAjaxGetTodayQuantityData', '$extend_conditions', '$field', '$condition', 'today_quantity', 'getEditData', 'ManufactureSchedule', 'manufacture_line_id', 'calcurate', 'total_today_quantity', 'ManufactureLine', 'line_number', 'child_number', '$manufacture_lines', 'getInspectionEditData', 'MInspectionQuantity', '$MIQ', 'calcInspection', 'view', '$tmp', 'getInspectionIndexData', 'getModalSearchAcceptance', 'DESC', 'getModalSearchAccidentData', 'getSearchIndex', '$mode', 'getSubcontractEditData', 'exp_delivery_date', '$suppliers', '$value', 'calculate', 'SubQuantity', 'total_quantity', 'sub_quantity', 'pdfDetail', 'vendor', 'fpdf', 'japanese', 'defined', 'FPDF_FONTPATH', 'define', 'font', 'SC_CHAR', 'UTF8', 'sets', '$pdf', '$font_size', 'SetFont', '_pdf_family', 'SetXY', 'PDF_Japanese', 'SJIS', 'AddSJISFont', '_pdf_font', 'Open', 'SetMargins', 'AddPage', 'Cell', 'sjis_conv', 'JobberCustomer', 'number_format', 'product_set_code', 'ProductSet', 'product_set_quantity', 'material_type', 'order_type', 'deadline_type', 'DelivClient', 'note', 'note2', 'TODO', 'Output', 'saveAcceptance', 'MaterialOffset', 'group', 'max_daily_receipt_number', 'deleteManufactureResult', '$foo', 'offset_date', 'saveAccident', 'getData', '$attr', 'ajax_get_id', 'getSumInspection', 'param', '$sum_inspection', 'public', 'getSumInspectionByManufactureId', 'deleteInspection', '$target_manufacture_result', '$new_manufacture_result', '$manufacture', '$savedata', 'revert', 'product', 'histories'}