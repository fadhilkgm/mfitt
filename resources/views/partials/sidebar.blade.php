<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
{{--    <div class="app-sidebar__user"><img width="40 px" class="app-sidebar__user-avatar" src="{{ asset('images/user/admin-icn.png') }}" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->fullname }}</p>
        </div>
    </div> --}}
    <ul class="app-menu">
        <li><a class="app-menu__item {{ request()->is('/') ? 'active' : ''}}" href="/"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>



        <li class="treeview "><a class="app-menu__item {{ request()->is('invoice*') ? 'active' : ''}}" href="#"
            data-toggle="treeview"><i class="app-menu__icon fa fa-file"></i><span
                class="app-menu__label">Invoice</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item " href="{{route('invoice.create')}}"><i class="icon fa fa-plus"></i>Create
                    Invoice </a></li>
            <li><a class="treeview-item" href="{{route('invoice.index')}}"><i class="icon fa fa-edit"></i>Manage
                    Invoice</a></li>
        </ul>
    </li>


        <li class="treeview"><a class="app-menu__item {{ request()->is('product*') ? 'active' : ''}}" href="#"
                data-toggle="treeview"><i class="app-menu__icon fa fa-cube"></i><span
                    class="app-menu__label">Product</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('product.create')}}"><i class="icon fa fa-circle-o"></i> New
                        Product</a></li>
                <li><a class="treeview-item" href="{{route('product.index')}}"><i class="icon fa fa-circle-o"></i>
                        Manage Products</a></li>
            </ul>
        </li>


        <!-- <li class="treeview"><a class="app-menu__item {{ request()->is('unit*') ? 'active' : ''}}" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-bars"></i><span class="app-menu__label">Unit</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('unit.create')}}"><i class="icon fa fa-circle-o"></i> Add Unit</a></li>
                <li><a class="treeview-item" href="{{route('unit.index')}}"><i class="icon fa fa-circle-o"></i> Manage Unit</a></li>
            </ul>
        </li> -->


        <li class="treeview"><a class="app-menu__item {{ request()->is('supplier*') ? 'active' : ''}}" href="#"
                data-toggle="treeview"><i class="app-menu__icon fa fa-truck"></i><span
                    class="app-menu__label">Supplier</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('supplier.create')}}"><i class="icon fa fa-circle-o"></i> Add
                        Supplier</a></li>
                <li><a class="treeview-item" href="{{route('supplier.index')}}"><i class="icon fa fa-circle-o"></i>
                        Manage Suppliers</a></li>
            </ul>
        </li>

        <li class="treeview "><a class="app-menu__item {{ request()->is('purchase*') ? 'active' : ''}}" href="#"
                data-toggle="treeview"><i class="app-menu__icon fa fa-exchange"></i><span
                    class="app-menu__label">Purchase</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item " href="{{route('purchase.create')}}"><i
                            class="icon fa fa-plus"></i>Purchase Product </a></li>
                <li><a class="treeview-item" href="{{route('purchase.index')}}"><i class="icon fa fa-edit"></i>Manage
                        Purchase</a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item {{ request()->is('customer*') ? 'active' : ''}}" href=""
                data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span
                    class="app-menu__label">Customer</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('customer.create')}}"><i class="icon fa fa-circle-o"></i> Add
                        Customer</a></li>
                <li><a class="treeview-item" href="{{route('customer.index')}}"><i class="icon fa fa-circle-o"></i>
                        Manage Customer</a></li>
            </ul>
        </li>



        <!-- <li><a class="app-menu__item {{ request()->is('sales') ? 'active' : ''}}" href="/sales"><i
                    class="app-menu__icon fa fa-dollar"></i><span class="app-menu__label">View Sales</span></a></li> -->


    </ul>
</aside>
