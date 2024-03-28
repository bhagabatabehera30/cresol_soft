  <div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"> 
                    <span>Main</span>
                </li>
                <li> 
                    <a href="{{ route('users.list') }}"><i class="fe fe-users"></i> <span>User List</span></a>
                </li>
                <li> 
                    <a href="{{ route('ajax-file-upload') }}"><i class="fa fa-files-o"></i> <span>Ajax File Upload</span></a>
                </li>
                <li> 
                    <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>