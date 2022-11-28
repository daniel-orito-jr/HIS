<body>
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">  
            <div class="image">
                <img src="<?= base_url("assets/vendors/images/user.jpg") ?>" width="48" height="48" alt="User" />
            </div>
            <div class="info-container" >
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top:20px;"><?= $this->session->userdata('empname')?></div>
<!--                <div class="email"><?= $this->session->userdata('empId')?></div>-->
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="javascript:void(0);" onclick="user.show_set()"><i class="material-icons">settings</i>Account Setting</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="<?= base_url('user/sign_out'); ?>"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list" style="padding-bottom: 30px">
                <?php if($this->session->userdata('admin')=== '1')
                { ?>
                <li id="menu-dashboard">
                    <a href="<?= base_url('user/dashboard') ?>">
                        <i class="material-icons">dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li id="menu-crm">
                    <a href="<?= base_url('user/crm') ?>">
                        <i class="material-icons">description</i>
                        <span>CRM</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">people</i>
                        <span>Members Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="membersmgmt-1">
                            <a href="<?= base_url('MembersMgmt') ?>">Members Listing</a>
                        </li>
                        <li id="membersmgmt-2">
                            <a href="<?= base_url('MembersMgmt/announcementsmembers') ?>">Announcement</a>
                        </li>
                        <li id="membersmgmt-3">
                            <a href="<?= base_url('MembersMgmt/zonemangmt') ?>">Zone Management</a>
                        </li>
<!--                        <li id="census-3">
                            <a href="<?= base_url('user/census/classifications') ?>">Px Classification & Disposition</a>
                        </li>-->
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">people</i>
                        <span>Census and Stats</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="census-1">
                            <a href="<?= base_url('user/census/patients') ?>">Admitted/Discharged Patients</a>
                        </li>
                        <li id="census-2">
                            <a href="<?= base_url('user/census/doctors') ?>">Doctor's Patients</a>
                        </li>
                        <li id="census-3">
                            <a href="<?= base_url('user/census/classifications') ?>">Px Classification & Disposition</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">shopping_cart</i>
                        <span>Departmentalized Income</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="income-1">
                            <a href="<?= base_url('user/dailytransactionincome') ?>">Daily Transaction</a>
                        </li>
                        <li id="income-2">
                              <a href="<?= base_url('user/monthlytrans') ?>">Month to Date Transaction</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">account_balance</i>
                        <span>AR/AP Monitoring</span>
                    </a>
                    <ul class="ml-menu">
                        <li id="armonitoring-1">
                            <a href="<?= base_url('user/summaryaccountaging') ?>">AR/AP Summary Account Aging</a>
                        </li>
<!--                        <li id="income-2">
                              <a href="<?= base_url('user/monthlytrans') ?>">Month to Date Transaction</a>
                        </li>-->
                    </ul>
                </li>
                <li id="menu-cash">
                    <a href="<?= base_url('user/cashflow') ?>">
                        <i class="material-icons">account_balance_wallet</i>
                        <span>Cash Flows</span>
                    </a>
                </li>
                <li id="menu-expenses">
                    <a href="<?= base_url('user/expenses') ?>">
                        <i class="material-icons">attach_money</i>
                        <span>Expenses</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">shopping_cart</i>
                        <span>Purchases</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Purchase Request</span>
                            </a>
                            <ul class="ml-menu">
                                <li id="purchase-req-1">
                                    <a href="<?= base_url('user/forapproval') ?>">For Approval</a>
                                </li>
                                <li id="purchase-req-2">
                                    <a href="<?= base_url('user/onprocess') ?>">On Process</a>
                                </li>
                                <li id="purchase-req-3">
                                    <a href="<?= base_url('user/approvedPur') ?>">Approved</a>
                                </li>
                                <li id="purchase-req-4">
                                    <a href="<?= base_url('user/deffered') ?>">Deferred</a>
                                </li>
                                <li id="purchase-req-5">
                                    <a href="<?= base_url('user/disapprovedPur') ?>">Disapproved</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Purchase Order</span>
                            </a>
                            <ul class="ml-menu">
                                <li id="purchase-order-1">
                                     <a href="javascript:void(0);" onclick="user.under_development()">Purchase Order</a>
                                </li>
                            </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Philhealth Accounts</span>
                        </a>
                        <ul class="ml-menu">
                            <li id="ph-accounts-0">
                                <a href="<?= base_url('user/phicsummaryreport') ?>">
                                    <span>E-Claims Summary Report</span>
                                </a>
                            </li>
                            <li id="ph-accounts-1">
                                <a href="<?= base_url('user/phiconprocess') ?>">
                                    <span>On Process</span>
                                </a>
                            </li>
                            <li id="ph-accounts-2">
                                <a href="<?= base_url('user/unpostedpayment') ?>">
                                    <span>Unposted</span>
                                </a>
                            </li>
                            <li id="ph-accounts-3">
                                <a href="<?= base_url('user/postedpayment') ?>">
                                    <span>Posted</span>
                                </a>
                            </li>
                            <li id="ph-accounts-4">
                                <a href="<?= base_url('user/chequestat') ?>">
                                    <span>Cheque Status</span>
                                </a>
                            </li>
                            <li id="ph-accounts-5">
                                <a href="<?= base_url('user/pendingclaims') ?>">
                                    <span>Pending Claims</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Submitted Claims</span>
                                </a>
                                <ul class="ml-menu">
                                    <li id="ph-accounts-6-1">
                                        <a href="<?= base_url('user/phicinprocess') ?>">
                                            <span>In Process</span>
                                        </a>
                                    </li>
                                    <li id="ph-accounts-6-2">
                                        <a href="<?= base_url('user/phicreturn') ?>">
                                            <span>Return</span>
                                        </a>
                                    </li>
                                    <li id="ph-accounts-6-3">
                                        <a href="<?= base_url('user/phicdenied') ?>">
                                            <span>Denied</span>
                                        </a>
                                    </li>
                                    <li id="ph-accounts-6-4">
                                        <a href="<?= base_url('user/phicvoucher') ?>">
                                            <span>With Voucher</span>
                                        </a>
                                    </li>
                                    <li id="ph-accounts-6-5">
                                        <a href="<?= base_url('user/phiccheck') ?>">
                                            <span>With Check</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li id="ph-accounts-7">
                                <a href="<?= base_url('user/historylog') ?>">
                                    <span>History Log</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">card_membership</i>
                            <span>HMO Accounts</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>AR as of Date</span>
                                </a>
                                <ul class="ml-menu">
                                    <li id="hmo-ar-1">
                                        <a href="<?= base_url('user/HMOacct') ?>">
                                            <span>HMO Account Only</span>
                                        </a>
                                    </li>
                                   <li id="hmo-ar-2">
                                        <a href="<?= base_url('user/HMOasofdate') ?>">
                                            <span>Comparative  (HMO Account,PHIC & Actual)</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li id="hmo-list" class="hidden">
                                <a href="<?= base_url('user/hmolist') ?>"><span>List of HMO</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">local_pharmacy</i>
                            <span>Inventory Monitoring</span>
                        </a>
                        <ul class="ml-menu">
                            <li id="inventory-pharmacy">
                                <a href="<?= base_url('user/phinventorymonitor') ?>">Pharmacy</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Laboratory</span>
                                </a>
                                <ul class="ml-menu">
                                    <li id="inventory-lab-sales">
                                        <a href="<?= base_url('user/labsalesmonitor') ?>">
                                            <span>Sales</span>
                                        </a>
                                    </li>
                                    <li id="inventory-lab-reagents">
                                        <a href="<?= base_url('user/labinventorymonitor') ?>">
                                            <span>Reagents</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Radiology</span>
                                </a>
                                <ul class="ml-menu">
                                    <li id="inventory-rad-sales">
                                        <a href="<?= base_url('user/radsalesmonitor') ?>">
                                            <span>Sales</span>
                                        </a>
                                    </li>
                                    <li id="inventory-rad-reagents">
                                        <a href="<?= base_url('user/radinventorymonitor') ?>">
                                            <span>Reagents</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li id="inventory-csr">
                                <a href="<?= base_url('user/csrinventorymonitor') ?>">CSR and Office Supplies</a>
                                <!--<a href="<?= base_url('user/chequemonitor') ?>">Laboratory</a>-->
                            </li>    
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">confirmation_number</i>
                            <span>Voucher</span>
                        </a>
                        <ul class="ml-menu">
                            <li id="voucher-1">
                                <a href="<?= base_url('user/chequeapproval') ?>">Cheque Approval</a>
                            </li>
                            <li id="voucher-2">
                                <a href="<?= base_url('user/chequemonitor') ?>">Monitoring</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">devices_other</i>
                            <span>Fix Asset Monitoring</span>
                        </a>
                        <ul class="ml-menu">
                            <li id="asset-1">
                                <a href="<?= base_url('user/fixasset') ?>">
                                    <span>Assets</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Job Orders</span>
                                </a>
                                <ul class="ml-menu">
                                    <li id="asset-jo-1">
                                        <a href="<?= base_url('user/jobapproval') ?>">
                                            <span>For Approval</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li id="menu-payrollsummary">
                        <a href="<?= base_url('user/payrollsummary') ?>">
                            <i class="material-icons">report</i>
                            <span>Payroll Summary</span>
                        </a>
                    </li>
                   
                <?php } ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                             <i class="material-icons">report</i>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span style="font-size: 10pt;">Mandatory Monthly Hospital Report</span>
                                </a>
                                <ul class="ml-menu">
                                    <li id="mandatory-1">
                                         <a href="" data-toggle="modal" data-target="#mandamonth">General Mandatory Report</a>
                                    </li>
                                    <li id="mandatory-2">
                                        <a href="<?= base_url('user/mandadailycensus') ?>">A.1 Daily Census</a>
                                    </li>
                                    <li id="mandatory-3">
                                        <a href="<?= base_url('user/mandaquality') ?>">B. Quality Assurance Indicator</a>
                                    </li>
                                    <li id="mandatory-4">
                                        <a href="<?= base_url('user/mandanewborn') ?>">C. Newborn Census</a>
                                    </li>
                                    <li id="mandatory-5">
                                        <a href="<?= base_url('user/mandaconfine') ?>">D. Most Common Causes of Confinement</a>
                                    </li>
                                    <li id="mandatory-6">
                                        <a href="<?= base_url('user/mandasurgical') ?>">E. Surgical Output</a>
                                    </li>
                                    <li id="mandatory-7">
                                        <a href="<?= base_url('user/mandatotalsurgical') ?>">E.1. Total Surgical Sterilization</a>
                                    </li>
                                    <li id="mandatory-8">
                                        <a href="<?= base_url('user/mandaobstetric') ?>">F. Obstetrical Procedures</a>
                                    </li>
                                    <li id="mandatory-9">
                                        <a href="<?= base_url('user/mandamortality') ?>">G. Monthly Mortality Census</a>
                                    </li>
                                    <li id="mandatory-10">
                                        <a href="<?= base_url('user/mandareferrals') ?>">H. Referrals</a>
                                    </li>
                                </ul>
                            </li>
                            <li hidden>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span style="font-size: 10pt;">DOH Annual Hospital Statistical Report</span>
                                </a>
                                <ul class="ml-menu">
                                    <li id="DOH-1">
                                         <a href="" data-toggle="modal" data-target="#mandamonth">General Mandatory Report</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="menu-toggle">
                                            <span>I. General Information</span>
                                        </a>
                                        <ul class="ml-menu">
                                            <li id="DOH-2-1">
                                                <a href="<?= base_url('user/general_class') ?>">A. Classification</a>
                                            </li>
                                            <li id="DOH-2-2">
                                                <a href="<?= base_url('user/general_quality') ?>">B. Quality Management</a>
                                            </li>
                                            <li id="DOH-2-3">
                                                <a href="<?= base_url('user/general_bed') ?>">C. Bed Capacity/ Occupancy</a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="menu-toggle">
                                            <span>II. Hospital Operations</span>
                                        </a>
                                        <ul class="ml-menu">
                                            <li id="DOH-3-1">
                                                <a href="<?= base_url('user/operation_sumpahosp') ?>">A. Summary of Patients in the Hospital</a>
                                            </li>
                                            <li id="DOH-3-2">
                                                <a href="<?= base_url('user/operation_discharges') ?>">B. Discharges</a>
                                            </li>
                                            <li id="DOH-3-3">
                                                <a href="<?= base_url('user/operation_deaths') ?>">C. Deaths</a>
                                            </li>
                                            <li id="DOH-3-4">
                                                <a href="<?= base_url('user/operation_hai') ?>">D. Healthcare Associated Infections (HAI)</a>
                                            </li>
                                            <li id="DOH-3-5">
                                                <a href="<?= base_url('user/operation_surgical') ?>">E. Surgical Operations</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id="DOH-4">
                                        <a href="<?= base_url('user/staffing_pattern') ?>">III. Staffing Pattern (Total Staff Complement)</a>
                                    </li>
                                    <li id="DOH-5">
                                        <a href="<?= base_url('user/DOH_expenses') ?>">IV. Expenses</a>
                                    </li>
                                    <li id="DOH-6">
                                        <a href="<?= base_url('user/DOH_revenues') ?>">V. Revenues</a>
                                    </li>
                                </ul>
                            </li> 
                        </ul>
                    </li>
            </ul>
        </div>
    </aside>
<?php $this->load->view('pages/modals/mandamonth'); ?>
</body>


