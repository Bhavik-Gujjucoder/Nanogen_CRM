<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="clinicdropdown">
                    <a href="dashboard.html">
                        <img src="images/avatar-14.png" class="img-fluid" alt="Profile">
                        <div class="user-names">
                            <h5>{{auth()->user()->name}}</h5>
                            <h6>{{auth()->user()->getRoleNames()->first()}}</h6>
                        </div>
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-layout-2"></i><span>Dashboard</span><span
                                    class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="dashboard.html" class="active">Dashboard</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <h6 class="submenu-hdr">Sales Management</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-file-invoice"></i><span>Sales Management</span><span
                                    class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="order-management.html">Order Management</a></li>
                                <li><a href="sales-persons.html">Sales Persons</a></li>
                                <li><a href="targets.html">Targets</a></li>
                                <li><a href="areawise-sales.html">Area Wise Sales</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <h6 class="submenu-hdr">Customer Type Management</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-layout-2"></i><span>Customer Management</span><span
                                    class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="distributors.html">Distributors</a></li>
                                <li><a href="dealers.html">Dealers</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <h6 class="submenu-hdr">Products</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-apps"></i><span>Products</span><span
                                    class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="product-catelog.html">Products and Catalogue</a></li>
                                <li><a href="product-category.html">Products Category</a></li>
                                <li><a href="pricing-product-variation.html">Pricing and Product
                                        Variation</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <li><a href="grade-management.html"><i class="ti ti-list-check"></i><span>Grade
                                    Management</span></a></li>
                        <li><a href="state-management.html"><i class="ti ti-map-pin-pin"></i><span>State
                                    Management</span></a>
                        </li>
                        <li><a href="city-management.html"><i class="ti ti-map-pin-pin"></i><span>City
                                    Management</span></a></li>
                        <!-- <li><a href="contacts.html"><i class="ti ti-steam"></i><span>Contacts</span></a></li> -->
                        <!-- <li><a href="tasks.html"><i class="ti ti-list-check"></i><span>Task</span></a></li> -->
                        <li><a href="sales-reports.html"><i class="ti ti-file-invoice"></i><span>Sales
                                    Reports</span></a></li>
                        <li><a href="trend-analysis.html"><i class="ti ti-chart-bar"></i><span>Trend
                                    Analysis</span></a></li>
                        <li><a href="roles-permissions.html"><i class="ti ti-navigation-cog"></i><span>Roles
                                    Permissions</span></a>
                        </li>
                        <li><a href="manage-users.html"><i class="ti ti-users"></i><span>Manage
                                    Users</span></a></li>
                    </ul>
                </li>
                <li>
                    <ul>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>