<?php
if (!isset($_SESSION['account_type'])) {
    $_SESSION['account_type'] = 0;
}

if ($_SESSION['account_type'] == 0) {
    echo   "<nav class='navbar navbar-expand-lg navbar-light my_banner'>
        <div class='container-fluid nav-padding'>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse'
                data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false'
                aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='index.php'>Home</a>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button'
                            data-bs-toggle='dropdown' aria-expanded='false'>
                            Account
                        </a>
                        <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                            <li><a class='dropdown-item' href='login.php'>Login</a></li>
                            <li><a class='dropdown-item' href='signup.php'>Sign up</a></li>
                              
                        </ul>
                    </li>
                </ul>
                <form class='d-flex'>
                    <input class='form-control me-2' id='searchbar' type='search' placeholder='Search By Artist...'
                        aria-label='Search'>
                        <button class='btn btn-outline-success' id='searchbutton' type='button'>Search</button>
                </form>
            </div>
        </div>
    </nav>";
} elseif ($_SESSION['account_type'] > 0) {
    echo   "<nav class='navbar navbar-expand-lg navbar-light my_banner'>
        <div class='container-fluid nav-padding'>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse'
                data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false'
                aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='index.php'>Home</a>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button'
                            data-bs-toggle='dropdown' aria-expanded='false'>
                            Account
                        </a>
                        <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <li><a class='dropdown-item' href='logout.php' onclick='logout()'>Logout</a></li>
                        <li><a class='dropdown-item' href='useraccount.php'>My Account</a></li>
                         </ul>
               </ul>
                 <form class='d-flex'>
                     <input class='form-control me-2' id='searchbar' type='search' placeholder='Search By Artist...'
                         aria-label='Search'>
                    <button class='btn btn-outline-success' id='searchbutton' type='button'>Search</button>
                 </form>
             </div>
         </div>
     </nav>";
}
