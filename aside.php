<?php
function active($url){
	$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
	
	if(str_replace('/', '', $request_uri[0]) == $url){
		echo "active";
	}
	
}
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      
      <?php
      session_start();
      if($_SESSION['access'] == 'Finance'){
    ?>
    
    <li class='<?php active("records"); ?>'>
        <a href="records">
          <i class="fa fa-dashboard"></i> <span>Records Management</span>
        </a>
      </li>
      
      <li class='treeview <?php active("quote"); ?><?php active("pending_quote"); ?><?php active("approved_quote"); ?><?php active("approved_indent_quote"); ?><?php active("revision_quote"); ?><?php active("rejected_quote"); ?><?php active("revise_quote"); ?><?php active("quote_po"); ?><?php active("quote_request"); ?><?php active("qr_archived"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Quotation</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("quote_request"); ?>'><a href="quote_request"><i class="fa fa-circle-o"></i> Quotation Requests</a></li>
          <li class='<?php active("qr_archived"); ?>'><a href="qr_archived"><i class="fa fa-circle-o"></i> Quotation Requests Archive</a></li>
          <li class='<?php active("quote"); ?>'><a href="quote"><i class="fa fa-circle-o"></i> Generate Quotation</a></li>
          <li class='<?php active("approved_quote"); ?><?php active("quote_po"); ?>'><a href="approved_quote"><i class="fa fa-circle-o"></i>Approved Trade Quotation</a></li>
          <li class='<?php active("approved_indent_quote"); ?>'><a href="approved_indent_quote"><i class="fa fa-circle-o"></i>Approved Indent Quotation</a></li>
          <li class='<?php active("accepted_indent_quote"); ?>'><a href="accepted_indent_quote"><i class="fa fa-circle-o"></i>Accepted Indent Quotation</a></li>
          <li class='<?php active("revision_quote"); ?><?php active("revise_quote"); ?>'><a href="revision_quote"><i class="fa fa-circle-o"></i> Quotation for Revision</a></li>
          <li class='<?php active("rejected_quote"); ?>'><a href="rejected_quote"><i class="fa fa-circle-o"></i> Rejected Trade Quotation</a></li>
          <li class='<?php active("rejected_indent_quote"); ?>'><a href="rejected_indent_quote"><i class="fa fa-circle-o"></i> Rejected Indent Quotation</a></li>
        </ul>
      </li>
	  
	  
	  <li class='treeview <?php active("purchase_requests"); ?><?php active("pr_po"); ?><?php active("purchase_requests_approved"); ?><?php active("purchase_requests_revise"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Purchase Requests</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("purchase_requests"); ?>'><a href="purchase_requests"><i class="fa fa-circle-o"></i> Pending PRs</a></li>
          <li class='<?php active("purchase_requests_approved"); ?>'><a href="purchase_requests_approved"><i class="fa fa-circle-o"></i> Approved PRs</a></li>
          <li class='<?php active("purchase_requests_revise"); ?>'><a href="purchase_requests_revise"><i class="fa fa-circle-o"></i> PRs for Revision</a></li>
        </ul>
      </li>
	  
	  
	  <li class='<?php active("po_from_customer"); ?><?php active("po_attachment"); ?><?php active("po_details"); ?>'>
        <a href="po_from_customer">
          <i class="glyphicon glyphicon-list"></i> <span>Sales Order</span>
        </a>
	  </li>
	  
	  <li class='<?php active("po_to_supplier"); ?><?php active("confirmed_po"); ?><?php active("shipment"); ?>'>
        <a href="po_to_supplier">
          <i class="glyphicon glyphicon-list"></i> <span>PO to Supplier</span>
        </a>
	  </li>
	  
	  <li class='<?php active("payments_to_supplier"); ?>'>
        <a href="payments_to_supplier">
          <i class="glyphicon glyphicon-credit-card"></i> <span>Payments to Supplier</span>
        </a>
	  </li>
	  
	  <li class='treeview <?php active("payable_accounts"); ?><?php active("payable_monitoring"); ?><?php active("receivable_monitoring"); ?>'>
        <a href="#">
          <i class="fa fa-calculator"></i> <span>Accounting</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("payable_accounts"); ?>'><a href="payable_accounts"><i class="fa fa-circle-o"></i> Payable Accounts</a></li>
          <li class='<?php active("payable_monitoring"); ?>'><a href="payable_monitoring"><i class="fa fa-circle-o"></i>Payable Monitoring</a></li>
          <li class='<?php active("receivable_monitoring"); ?>'><a href="receivable_monitoring"><i class="fa fa-circle-o"></i> Receivable Monitoring</a></li>
        </ul>
      </li>
    
    <?php
      }
      elseif($_SESSION['access'] == 'Support'){
    ?>
    
    <li class='<?php active("records"); ?>'>
        <a href="records">
          <i class="fa fa-dashboard"></i> <span>Records Management</span>
        </a>
      </li>
    
    <li class='<?php active("generate_bom"); ?><?php active("foreign"); ?><?php active("local"); ?><?php active("labor"); ?><?php active("permit"); ?><?php active("subcon"); ?>'>
        <a href="generate_bom">
          <i class="glyphicon glyphicon-file"></i> <span>Generate BOM</span>
        </a>
	  </li>
	  
    <li class='treeview <?php active("quote"); ?><?php active("pending_quote"); ?><?php active("approved_quote"); ?><?php active("approved_indent_quote"); ?><?php active("revision_quote"); ?><?php active("rejected_quote"); ?><?php active("revise_quote"); ?><?php active("quote_po"); ?><?php active("quote_request"); ?><?php active("qr_archived"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Quotation</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("quote_request"); ?>'><a href="quote_request"><i class="fa fa-circle-o"></i> Quotation Requests</a></li>
          <li class='<?php active("qr_archived"); ?>'><a href="qr_archived"><i class="fa fa-circle-o"></i> Quotation Requests Archive</a></li>
          
          <li class='<?php active("pending_quote"); ?>'><a href="pending_quote"><i class="fa fa-circle-o"></i> Pending Quotation</a></li>
          <li class='<?php active("quote"); ?>'><a href="quote"><i class="fa fa-circle-o"></i> Generate Quotation</a></li>
          <li class='<?php active("approved_quote"); ?><?php active("quote_po"); ?>'><a href="approved_quote"><i class="fa fa-circle-o"></i>Approved Trade Quotation</a></li>
          <li class='<?php active("approved_indent_quote"); ?>'><a href="approved_indent_quote"><i class="fa fa-circle-o"></i>Approved Indent Quotation</a></li>
          <li class='<?php active("accepted_indent_quote"); ?>'><a href="accepted_indent_quote"><i class="fa fa-circle-o"></i>Accepted Indent Quotation</a></li>
          <li class='<?php active("revision_quote"); ?><?php active("revise_quote"); ?>'><a href="revision_quote"><i class="fa fa-circle-o"></i> Quotation for Revision</a></li>
          <li class='<?php active("rejected_quote"); ?>'><a href="rejected_quote"><i class="fa fa-circle-o"></i> Rejected Trade Quotation</a></li>
          <li class='<?php active("rejected_indent_quote"); ?>'><a href="rejected_indent_quote"><i class="fa fa-circle-o"></i> Rejected Indent Quotation</a></li>
        </ul>
      </li>
      
    <?php
      }
      elseif($_SESSION['access'] == 'Customer'){
    ?>
    
    <li class='<?php active("records"); ?>'>
        <a href="records">
          <i class="fa fa-dashboard"></i> <span>Records Management</span>
        </a>
      </li>
      
      <li class='<?php active("generate_bom"); ?><?php active("foreign"); ?><?php active("local"); ?><?php active("labor"); ?><?php active("permit"); ?><?php active("subcon"); ?>'>
        <a href="generate_bom">
          <i class="glyphicon glyphicon-file"></i> <span>Generate BOM</span>
        </a>
	  </li>
      
      <li class='<?php active("po_from_customer"); ?><?php active("po_attachment"); ?><?php active("po_details"); ?>'>
        <a href="po_from_customer">
          <i class="glyphicon glyphicon-list"></i> <span>Sales Order</span>
        </a>
	  </li>
      
      <li class='treeview <?php active("quote"); ?><?php active("pending_quote"); ?><?php active("approved_quote"); ?><?php active("approved_indent_quote"); ?><?php active("revision_quote"); ?><?php active("rejected_quote"); ?><?php active("revise_quote"); ?><?php active("quote_po"); ?><?php active("quote_request"); ?><?php active("qr_archived"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Quotation</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("quote_request"); ?>'><a href="quote_request"><i class="fa fa-circle-o"></i> Quotation Requests</a></li>
          <li class='<?php active("qr_archived"); ?>'><a href="qr_archived"><i class="fa fa-circle-o"></i> Quotation Requests Archive</a></li>
          
          <li class='<?php active("pending_quote"); ?>'><a href="pending_quote"><i class="fa fa-circle-o"></i> Pending Quotation</a></li>
          <li class='<?php active("quote"); ?>'><a href="quote"><i class="fa fa-circle-o"></i> Generate Quotation</a></li>
          <li class='<?php active("approved_quote"); ?><?php active("quote_po"); ?>'><a href="approved_quote"><i class="fa fa-circle-o"></i>Approved Trade Quotation</a></li>
          <li class='<?php active("approved_indent_quote"); ?>'><a href="approved_indent_quote"><i class="fa fa-circle-o"></i>Approved Indent Quotation</a></li>
          <li class='<?php active("accepted_indent_quote"); ?>'><a href="accepted_indent_quote"><i class="fa fa-circle-o"></i>Accepted Indent Quotation</a></li>
          <li class='<?php active("revision_quote"); ?><?php active("revise_quote"); ?>'><a href="revision_quote"><i class="fa fa-circle-o"></i> Quotation for Revision</a></li>
          <li class='<?php active("rejected_quote"); ?>'><a href="rejected_quote"><i class="fa fa-circle-o"></i> Rejected Trade Quotation</a></li>
          <li class='<?php active("rejected_indent_quote"); ?>'><a href="rejected_indent_quote"><i class="fa fa-circle-o"></i> Rejected Indent Quotation</a></li>
        </ul>
      </li>
      
	  <li class='treeview <?php active("purchase_requests"); ?><?php active("pr_po"); ?><?php active("purchase_requests_approved"); ?><?php active("purchase_requests_revise"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Purchase Requests</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("purchase_requests"); ?>'><a href="purchase_requests"><i class="fa fa-circle-o"></i> Pending PRs</a></li>
          <li class='<?php active("purchase_requests_approved"); ?>'><a href="purchase_requests_approved"><i class="fa fa-circle-o"></i> Approved PRs</a></li>
          <li class='<?php active("purchase_requests_revise"); ?>'><a href="purchase_requests_revise"><i class="fa fa-circle-o"></i> PRs for Revision</a></li>
        </ul>
      </li>
	  
      <li class='<?php active("po_to_supplier"); ?><?php active("confirmed_po"); ?><?php active("shipment"); ?>'>
        <a href="po_to_supplier">
          <i class="glyphicon glyphicon-list"></i> <span>PO to Supplier</span>
        </a>
	  </li>
	       
	  
    <?php
      }
      elseif($_SESSION['access'] == 'Assets'){
        ?>
        
    <li class='<?php active("records"); ?>'>
        <a href="records">
          <i class="fa fa-dashboard"></i> <span>Records Management</span>
        </a>
      </li>
      
	  <li class='<?php active("po_from_customer"); ?><?php active("po_attachment"); ?><?php active("po_details"); ?>'>
        <a href="po_from_customer">
          <i class="glyphicon glyphicon-list"></i> <span>Sales Order</span>
        </a>
	  </li>
	  
	  <li class='treeview <?php active("purchase_requests"); ?><?php active("pr_po"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Purchase Requests</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("purchase_requests"); ?>'><a href="purchase_requests"><i class="fa fa-circle-o"></i> Purchase Requests</a></li>
        </ul>
      </li>
	  
	  
	  <li class='<?php active("po_to_supplier"); ?><?php active("confirmed_po"); ?><?php active("shipment"); ?>'>
        <a href="po_to_supplier">
          <i class="glyphicon glyphicon-list"></i> <span>PO to Supplier</span>
        </a>
	  </li>
	        
    <?php 
      }
      else{ //Admin
      ?>
      
      <li class='<?php active("records"); ?>'>
        <a href="records">
          <i class="fa fa-dashboard"></i> <span>Records Management</span>
        </a>
      </li>
      
      <li class='<?php active("generate_bom"); ?><?php active("foreign"); ?><?php active("local"); ?><?php active("labor"); ?><?php active("permit"); ?><?php active("subcon"); ?>'>
        <a href="generate_bom">
          <i class="glyphicon glyphicon-file"></i> <span>Generate BOM</span>
        </a>
	  </li>
	  
      <li class='treeview <?php active("quote"); ?><?php active("pending_quote"); ?><?php active("approved_quote"); ?><?php active("approved_indent_quote"); ?><?php active("revision_quote"); ?><?php active("rejected_quote"); ?><?php active("revise_quote"); ?><?php active("quote_po"); ?><?php active("quote_request"); ?><?php active("qr_archived"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Quotation</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("quote_request"); ?>'><a href="quote_request"><i class="fa fa-circle-o"></i> Quotation Requests</a></li>
          <li class='<?php active("qr_archived"); ?>'><a href="qr_archived"><i class="fa fa-circle-o"></i> Quotation Requests Archive</a></li>
          
          <li class='<?php active("quote"); ?>'><a href="quote"><i class="fa fa-circle-o"></i> Generate Quotation</a></li>
          <li class='<?php active("pending_quote"); ?>'><a href="pending_quote"><i class="fa fa-circle-o"></i> Pending Quotation</a></li>
          <li class='<?php active("approved_quote"); ?><?php active("quote_po"); ?>'><a href="approved_quote"><i class="fa fa-circle-o"></i>Approved Trade Quotation</a></li>
          <li class='<?php active("approved_indent_quote"); ?>'><a href="approved_indent_quote"><i class="fa fa-circle-o"></i>Approved Indent Quotation</a></li>
          <li class='<?php active("accepted_indent_quote"); ?>'><a href="accepted_indent_quote"><i class="fa fa-circle-o"></i>Accepted Indent Quotation</a></li>
          <li class='<?php active("revision_quote"); ?><?php active("revise_quote"); ?>'><a href="revision_quote"><i class="fa fa-circle-o"></i> Quotation for Revision</a></li>
          <li class='<?php active("rejected_quote"); ?>'><a href="rejected_quote"><i class="fa fa-circle-o"></i> Rejected Trade Quotation</a></li>
          <li class='<?php active("rejected_indent_quote"); ?>'><a href="rejected_indent_quote"><i class="fa fa-circle-o"></i> Rejected Indent Quotation</a></li>
        </ul>
      </li>
	  
	  <li class='<?php active("po_from_customer"); ?><?php active("po_attachment"); ?><?php active("po_details"); ?>'>
        <a href="po_from_customer">
          <i class="glyphicon glyphicon-list"></i> <span>Sales Order</span>
        </a>
	  </li>
	  
	  <li class='treeview <?php active("purchase_requests"); ?><?php active("pr_po"); ?><?php active("purchase_requests_approved"); ?><?php active("purchase_requests_revise"); ?>'>
        <a href="#">
          <i class="fa fa-file-o"></i> <span>Purchase Requests</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("purchase_requests"); ?>'><a href="purchase_requests"><i class="fa fa-circle-o"></i> Pending PRs</a></li>
          <li class='<?php active("purchase_requests_approved"); ?>'><a href="purchase_requests_approved"><i class="fa fa-circle-o"></i> Approved PRs</a></li>
          <li class='<?php active("purchase_requests_revise"); ?>'><a href="purchase_requests_revise"><i class="fa fa-circle-o"></i> PRs for Revision</a></li>
        </ul>
      </li>
	  
	  
	  <li class='<?php active("po_to_supplier"); ?><?php active("confirmed_po"); ?><?php active("shipment"); ?>'>
        <a href="po_to_supplier">
          <i class="glyphicon glyphicon-list"></i> <span>PO to Supplier</span>
        </a>
	  </li>
	  
	  <li class='<?php active("payments_to_supplier"); ?>'>
        <a href="payments_to_supplier">
          <i class="glyphicon glyphicon-credit-card"></i> <span>Payments to Supplier</span>
        </a>
	  </li>
	  
	  <li class='treeview <?php active("payable_accounts"); ?><?php active("payable_monitoring"); ?><?php active("receivable_monitoring"); ?>'>
        <a href="#">
          <i class="fa fa-calculator"></i> <span>Accounting</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class='<?php active("payable_accounts"); ?>'><a href="payable_accounts"><i class="fa fa-circle-o"></i> Payable Accounts</a></li>
          <li class='<?php active("payable_monitoring"); ?>'><a href="payable_monitoring"><i class="fa fa-circle-o"></i>Payable Monitoring</a></li>
          <li class='<?php active("receivable_monitoring"); ?>'><a href="receivable_monitoring"><i class="fa fa-circle-o"></i> Receivable Monitoring</a></li>
        </ul>
      </li>
	  
      <?php
      }
      ?>
      
    </ul>
  </section>
</aside>
