<?php
session_start();

// Grabs the URI and breaks it apart in case we have querystring stuff
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

// Route it up!
switch (str_replace('/admin', '', $request_uri[0])) {
// Home page
case '/':
  require 'login.php';
  break;
// Login page
case '/login':
  require 'login.php';
  break;
// pending_quote page
case '/pending_quote':
  require 'quote_record.php';
  break;
 
case '/payable_accounts':
  require 'payable_accounts.php';
  break;
 
 case '/payable_monitoring':
  require 'payable_monitoring.php';
  break;
 
 case '/receivable_monitoring':
  require 'receivable_monitoring.php';
  break;
 
  
 
  
// pending_quote page
case '/edit_po':
  require 'edit_po.php';
  break;

case '/rejected_indent_quote':
    require 'rejected_indent_quote.php';
    break;

//edit_pr
case '/edit_pr':
    require 'edit_pr.php';
    break;


case '/accepted_indent_quote':
    require 'accepted_indent_quote.php';
    break;
   
// pending_quote page
case '/qr_archived':
  require 'qr_archived.php';
  break;   
    
// pending_quote page
case '/copy_quote':
  require 'quote_copy.php';
  break;
  
// bom page
case '/foreign':
  require 'bom.php';
  break;

//indent_products
case '/indent_products':
  require 'indent_products.php';
  break;
  
  //indent_products
case '/local_products':
  require 'local_products.php';
  break;

// local page
case '/local':
  require 'local.php';
  break;

// subcon page
case '/subcon':
  require 'subcon.php';
  break;


// labor page
case '/labor':
  require 'labor.php';
  break;
  
// permit page
case '/permit':
  require 'permit.php';
  break;

// bom_table page
case '/generate_bom':
  require 'bom_table.php';
  break;
  
 //view_bom
 case '/view_bom':
  require 'view_bom.php';
  break;
 
 
// shipment page
case '/shipment':
  require 'shipment.php';
  break;
  
 //confirmed_po
 case '/confirmed_po':
  require 'confirmed_po.php';
  break;
  
 //payments_to_supplier.php
 case '/payments_to_supplier':
  require 'payments_to_supplier.php';
  break;
  
 // pr_po page
case '/pr_po':
  require 'pr_po.php';
  break;
 //purchase_requests
 case '/purchase_requests':
  require 'purchase_requests.php';
  break;
  
 //purchase_requests_approved
 case '/purchase_requests_approved':
  require 'purchase_requests_approved.php';
  break;
  
 //purchase_requests_revise
  case '/purchase_requests_revise':
  require 'purchase_requests_revise.php';
  break;
  
// quote_request page
case '/quote_request':
  require 'quote_request.php';
  break;
 
 //approved_indent_quote
case '/approved_indent_quote':
  require 'approved_indent_quote.php';
  break;
  
// quote_edit page
case '/revise_quote':
  require 'quote_edit.php';
  break;
  
// quote_edit page
case '/po_attachment':
  require 'po_attachment.php';
  break;
 
 //quote_po
case '/quote_po':
  require 'quote_po.php';
  break;
    
//quote_po
case '/po_details':
  require 'po_details.php';
  break;
  
// rejected page
case '/rejected_quote':
  require 'quote_rejected.php';
  break;
// quote_pdf page
case '/quote_pdf':
  require 'quote_pdf.php';
  break;
// account_title page
case '/account_title':
    require 'account_title.php';
  break;
// Company page
case '/company':
    require 'company.php';
  break;
// Home page
case '/records':
    require 'records_dashboard.php';
  break;
// User page
case '/user':
    require 'user.php';
  break;
// Reports page
case '/reports':
    require 'reports.php';
  break;
// Customer page
case '/customer':
    require 'customers.php';
  break;
// Check page
case '/check':
    require 'check.php';
  break;

// Check page
case '/check_approval':
    require 'check_approval.php';
  break;
// CMO page
case '/cmo':
    require 'cmo.php';
  break;
// Suppliers page
case '/supplier':
    require 'suppliers.php';
  break;
// Warehouse page
case '/warehouse':
    require 'warehouses.php';
  break;
// Product page
case '/product':
    require 'products.php';
  break;
// Print Invoice page
case '/print_inv':
    require 'print_inv.php';
  break;
// Packaging page
case '/packaging':
    require 'packaging.php';
  break;
// Payee page
case '/payee':
    require 'payees.php';
  break;
// Importation page
case '/importation':
    require 'importation.php';
  break;
// New Importation page
case '/new_importation':
    require 'new_importation.php';
  break;
// View Importation page
case '/view_importation':
    require 'view_importation.php';
  break;
// View Importation page
case '/view_breakdown':
    require 'view_breakdown.php';
  break;
// View Payments page
case '/view_payments':
    require 'view_payments.php';
  break;
//view_user
case '/view_user':
    require 'view_user.php';
  break;
// View Records page
case '/view_record':
    require 'view_record.php';
  break;
// Deduction page
case '/deductions':
    require 'deductions.php';
  break;
// View Transfer page
case '/view_transfer':
    require 'view_transfer.php';
  break;
//view_payable
case '/view_payable':
    require 'view_payable.php';
  break;
// View SO page
case '/view_so':
    require 'view_so.php';
  break;
//view_impdetails
case '/view_impdetails':
    require 'view_impdetails.php';
  break;
//deductions_payable
case '/deductions_payable':
    require 'deductions_payable.php';
  break;
// Inventory page
case '/inventory':
    require 'inventory.php';
  break;
// Finance page
case '/finance':
    require 'finance.php';
  break;
// Inventory Transfer page
case '/inv_transfer':
    require 'inv_transfer.php';
  break;
// Inventory Monitoring page
case '/inv_monitoring':
    require 'inv_monitoring.php';
  break;
case '/inv_report':
    require 'inv_report.php';
  break;
// Inventory Printing page
case '/inv_printing':
    require 'inv_printing.php';
  break;
// Inventory Breakdown page
case '/inv_breakdown':
    require 'inv_breakdown.php';
  break;
// Inventory Breakdown page
case '/inv_breakdown_recs':
    require 'inv_breakdown_recs.php';
  break;
// Inventory Breakdown page
case '/breakdown':
    require 'breakdown.php';
  break;
// Attachment page
case '/attachment':
    require 'attachment.php';
  break;
// Print STF page
case '/print_stf':
    require 'print_stf.php';
  break;
// Sales page
case '/sales':
  require 'sales.php';
  break;
// Accounts page
case '/accounts':
    require 'accounts.php';
  break;
// Accounting page
case '/accounting':
  require 'accounting.php';
  break;
// So Records page
case '/so_records':
  require 'so_records.php';
  break;
// So Records page
case '/approved_records':
  require 'approved_records.php';
  break;
// So Records page
case '/sidr_records':
  require 'sidr_records.php';
  break;
// So Records page
case '/disapproved_records':
    require 'disapproved_records.php';
  break;
// Payments page
case '/payments':
    require 'payments.php';
  break;
case '/all_so_records':
    require 'all_so_records.php';
  break;
// Terms Imp page
case '/terms_imp':
    require 'terms_imp.php';
  break;

// quote page
case '/quote':
    require 'quote.php';
  break;

  // Terms SM page
case '/terms_sm':
    require 'terms_sm.php';
  break;
// Origin page
case '/origin':
    require 'origin.php';
  break;
// Terms SM page
case '/actual_product':
    require 'actual_product.php';
  break;
// Approved Quotation
case '/approved_quote':
	require 'quote_approved.php';
	break;
// Quotation Revision
case '/revision_quote':
	require 'quote_revision.php';
	break;
// PO from Customer
case '/po_from_customer':
	require 'po_from_customer.php';
	break;	
// PO to Supplier
case '/po_to_supplier':
	require 'po_to_supplier.php';
	break;	
// payments from customer
case '/payments_from_customer':
	require 'payments_from_customer.php';
	break;
// payments to supplier
case '/payments_to_supplier':
	require 'payments_to_supplier.php';
	break;
	
// Inventory
case 'inventory':
	require 'inventory.php';
	break;
	
default:
  header('HTTP/1.0 404 Not Found');
  require '404.html';
  break;
  
}
