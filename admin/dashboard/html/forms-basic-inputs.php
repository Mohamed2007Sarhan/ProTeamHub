<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Basic Inputs - Forms | ProTeamHub</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../../proteamhub_logo1.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.php" class="app-brand-link">
              <span class="app-brand-logo demo">
                <svg width="25" height="42">
                <image href="../../../proteamhub_logo1.png" width="25" height="42" />
              </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">ProTeamHub</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Accounts -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Accounts">Accounts</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="Accounts-without-menu.php" class="menu-link">
                    <div data-i18n="Accounts Edit">Accounts Edit</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="Accounts-without-navbar.php" class="menu-link">
                    <div data-i18n="Accounts List">Accounts List</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="Accounts-container.php" class="menu-link">
                    <div data-i18n="container">container</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="Accounts-fluid.php" class="menu-link">
                    <div data-i18n="Fluid">Fluid</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="Accounts-blank.php" class="menu-link">
                    <div data-i18n="Blank">Blank</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Pages</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Notivication & News">Notivication & News</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="pages-account-settings-account.php" class="menu-link">
                    <div data-i18n="Account">Not & News</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-notifications.php" class="menu-link">
                    <div data-i18n="Notifications">Notifications</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-connections.php" class="menu-link">
                    <div data-i18n="Connections">News</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Authentications</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="auth-login-basic.php" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Login</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="auth-register-basic.php" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Register</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="auth-forgot-password-basic.php" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Forgot Password</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Misc</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="pages-misc-error.php" class="menu-link">
                    <div data-i18n="Error">Error</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-misc-under-maintenance.php" class="menu-link">
                    <div data-i18n="Under Maintenance">Under Maintenance</div>
                  </a>
                </li>
              </ul>
            </li>
            <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>
            <!-- Cards -->
            <li class="menu-item">
              <a href="cards-basic.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Cards</div>
              </a>
            </li>
            <!-- User interface -->
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="User interface">User interface</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="ui-accordion.php" class="menu-link">
                    <div data-i18n="Accordion">Accordion</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-alerts.php" class="menu-link">
                    <div data-i18n="Alerts">Alerts</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-badges.php" class="menu-link">
                    <div data-i18n="Badges">Badges</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-buttons.php" class="menu-link">
                    <div data-i18n="Buttons">Buttons</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-carousel.php" class="menu-link">
                    <div data-i18n="Carousel">Carousel</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-collapse.php" class="menu-link">
                    <div data-i18n="Collapse">Collapse</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-dropdowns.php" class="menu-link">
                    <div data-i18n="Dropdowns">Dropdowns</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-footer.php" class="menu-link">
                    <div data-i18n="Footer">Footer</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-list-groups.php" class="menu-link">
                    <div data-i18n="List Groups">List groups</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-modals.php" class="menu-link">
                    <div data-i18n="Modals">Modals</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-navbar.php" class="menu-link">
                    <div data-i18n="Navbar">Navbar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-offcanvas.php" class="menu-link">
                    <div data-i18n="Offcanvas">Offcanvas</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-pagination-breadcrumbs.php" class="menu-link">
                    <div data-i18n="Pagination &amp; Breadcrumbs">Pagination &amp; Breadcrumbs</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-progress.php" class="menu-link">
                    <div data-i18n="Progress">Progress</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-spinners.php" class="menu-link">
                    <div data-i18n="Spinners">Spinners</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-tabs-pills.php" class="menu-link">
                    <div data-i18n="Tabs &amp; Pills">Tabs &amp; Pills</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-toasts.php" class="menu-link">
                    <div data-i18n="Toasts">Toasts</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-tooltips-popovers.php" class="menu-link">
                    <div data-i18n="Tooltips & Popovers">Tooltips &amp; popovers</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-typography.php" class="menu-link">
                    <div data-i18n="Typography">Typography</div>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Extended components -->
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Extended UI">Extended UI</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="extended-ui-perfect-scrollbar.php" class="menu-link">
                    <div data-i18n="Perfect Scrollbar">Perfect scrollbar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="extended-ui-text-divider.php" class="menu-link">
                    <div data-i18n="Text Divider">Text Divider</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-item">
              <a href="icons-boxicons.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Boxicons">Boxicons</div>
              </a>
            </li>

            <!-- Forms & Tables -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Forms &amp; Tables</span></li>
            <!-- Forms -->
            <li class="menu-item active open">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Elements">Form Elements</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item active">
                  <a href="forms-basic-inputs.php" class="menu-link">
                    <div data-i18n="Basic Inputs">Basic Inputs</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="forms-input-groups.php" class="menu-link">
                    <div data-i18n="Input groups">Input groups</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Accounts">Form Accounts</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="form-Accounts-vertical.php" class="menu-link">
                    <div data-i18n="Vertical Form">Vertical Form</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="form-Accounts-horizontal.php" class="menu-link">
                    <div data-i18n="Horizontal Form">Horizontal Form</div>
                  </a>
                </li>
              </ul>
            </li>
            <!-- Tables -->
            <li class="menu-item">
              <a href="tables-basic.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Tables</div>
              </a>
            </li>
            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
              <a
                href="https://github.com/Mohamed2007Sarhan/issues"
                target="_blank"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Support</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://ProTeamHub.com/demo/ProTeamHub-bootstrap-html-admin-template/documentation/"
                target="_blank"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                  <a
                    class="github-button"
                    href="https://github.com/Mohamed2007Sarhan"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star ProTeamHub/ProTeamHub-html-admin-template-free on GitHub"
                    >Star</a
                  >
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?= htmlspecialchars($_SESSION['username']) ?> </span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="auth-login-basic.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Basic Inputs</h4>

              <div class="row">
                <div class="col-md-6">
                  <div class="card mb-4">
                    <h5 class="card-header">Default</h5>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">Name</label>
                        <input
                          type="text"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="<?= htmlspecialchars($_SESSION['username']) ?> "
                          aria-describedby="defaultFormControlHelp"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          We'll never share your details with anyone else.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-4">
                    <h5 class="card-header">Float label</h5>
                    <div class="card-body">
                      <div class="form-floating">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          placeholder="<?= htmlspecialchars($_SESSION['username']) ?> "
                          aria-describedby="floatingInputHelp"
                        />
                        <label for="floatingInput">Name</label>
                        <div id="floatingInputHelp" class="form-text">
                          We'll never share your details with anyone else.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Form controls -->
                <div class="col-md-6">
                  <div class="card mb-4">
                    <h5 class="card-header">Form Controls</h5>
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input
                          type="email"
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="name@example.com"
                        />
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Read only</label>
                        <input
                          class="form-control"
                          type="text"
                          id="exampleFormControlReadOnlyInput1"
                          placeholder="Readonly input here..."
                          readonly
                        />
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInputPlain1" class="form-label">Read plain</label>
                        <input
                          type="text"
                          readonly
                          class="form-control-plaintext"
                          id="exampleFormControlReadOnlyInputPlain1"
                          value="email@example.com"
                        />
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Example select</label>
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="exampleDataList" class="form-label">Datalist example</label>
                        <input
                          class="form-control"
                          list="datalistOptions"
                          id="exampleDataList"
                          placeholder="Type to search..."
                        />
                        <datalist id="datalistOptions">
                          <option value="San Francisco"></option>
                          <option value="New York"></option>
                          <option value="Seattle"></option>
                          <option value="Los Angeles"></option>
                          <option value="Chicago"></option>
                        </datalist>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlSelect2" class="form-label">Example multiple select</label>
                        <select
                          multiple
                          class="form-select"
                          id="exampleFormControlSelect2"
                          aria-label="Multiple select example"
                        >
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Input Sizing -->
                <div class="col-md-6">
                  <div class="card mb-4">
                    <h5 class="card-header">Input Sizing</h5>
                    <div class="card-body">
                      <small class="text-light fw-semibold">Input text</small>

                      <div class="mt-2 mb-3">
                        <label for="largeInput" class="form-label">Large input</label>
                        <input
                          id="largeInput"
                          class="form-control form-control-lg"
                          type="text"
                          placeholder=".form-control-lg"
                        />
                      </div>
                      <div class="mb-3">
                        <label for="defaultInput" class="form-label">Default input</label>
                        <input id="defaultInput" class="form-control" type="text" placeholder="Default input" />
                      </div>
                      <div>
                        <label for="smallInput" class="form-label">Small input</label>
                        <input
                          id="smallInput"
                          class="form-control form-control-sm"
                          type="text"
                          placeholder=".form-control-sm"
                        />
                      </div>
                    </div>
                    <hr class="m-0" />
                    <div class="card-body">
                      <small class="text-light fw-semibold">Input select</small>
                      <div class="mt-2 mb-3">
                        <label for="largeSelect" class="form-label">Large select</label>
                        <select id="largeSelect" class="form-select form-select-lg">
                          <option>Large select</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="defaultSelect" class="form-label">Default select</label>
                        <select id="defaultSelect" class="form-select">
                          <option>Default select</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div>
                        <label for="smallSelect" class="form-label">Small select</label>
                        <select id="smallSelect" class="form-select form-select-sm">
                          <option>Small select</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Default Checkboxes and radios & Default checkboxes and radios -->
                <div class="col-xl-6">
                  <div class="card mb-4">
                    <h5 class="card-header">Checkboxes and Radios</h5>
                    <!-- Checkboxes and Radios -->
                    <div class="card-body">
                      <div class="row gy-3">
                        <div class="col-md">
                          <small class="text-light fw-semibold">Checkboxes</small>
                          <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" />
                            <label class="form-check-label" for="defaultCheck1"> Unchecked </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" checked />
                            <label class="form-check-label" for="defaultCheck2"> Indeterminate </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck3" checked />
                            <label class="form-check-label" for="defaultCheck3"> Checked </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="disabledCheck1" disabled />
                            <label class="form-check-label" for="disabledCheck1"> Disabled Unchecked </label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="checkbox"
                              value=""
                              id="disabledCheck2"
                              disabled
                              checked
                            />
                            <label class="form-check-label" for="disabledCheck2"> Disabled Checked </label>
                          </div>
                        </div>
                        <div class="col-md">
                          <small class="text-light fw-semibold">Radio</small>
                          <div class="form-check mt-3">
                            <input
                              name="default-radio-1"
                              class="form-check-input"
                              type="radio"
                              value=""
                              id="defaultRadio1"
                            />
                            <label class="form-check-label" for="defaultRadio1"> Unchecked </label>
                          </div>
                          <div class="form-check">
                            <input
                              name="default-radio-1"
                              class="form-check-input"
                              type="radio"
                              value=""
                              id="defaultRadio2"
                              checked
                            />
                            <label class="form-check-label" for="defaultRadio2"> Checked </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="disabledRadio1" disabled />
                            <label class="form-check-label" for="disabledRadio1"> Disabled unchecked </label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="radio"
                              value=""
                              id="disabledRadio2"
                              disabled
                              checked
                            />
                            <label class="form-check-label" for="disabledRadio2"> Disabled checkbox </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr class="m-0" />
                    <!-- Inline Checkboxes -->
                    <div class="card-body">
                      <div class="row gy-3">
                        <div class="col-md">
                          <small class="text-light fw-semibold d-block">Inline Checkboxes</small>
                          <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" />
                            <label class="form-check-label" for="inlineCheckbox1">1</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" />
                            <label class="form-check-label" for="inlineCheckbox2">2</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input
                              class="form-check-input"
                              type="checkbox"
                              id="inlineCheckbox3"
                              value="option3"
                              disabled
                            />
                            <label class="form-check-label" for="inlineCheckbox3">3 (disabled)</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <small class="text-light fw-semibold d-block">Inline Radio</small>
                          <div class="form-check form-check-inline mt-3">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="inlineRadioOptions"
                              id="inlineRadio1"
                              value="option1"
                            />
                            <label class="form-check-label" for="inlineRadio1">1</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="inlineRadioOptions"
                              id="inlineRadio2"
                              value="option2"
                            />
                            <label class="form-check-label" for="inlineRadio2">2</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="inlineRadioOptions"
                              id="inlineRadio3"
                              value="option3"
                              disabled
                            />
                            <label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Switches -->
                  <div class="card mb-4">
                    <h5 class="card-header">Switches</h5>
                    <div class="card-body">
                      <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" />
                        <label class="form-check-label" for="flexSwitchCheckDefault"
                          >Default switch checkbox input</label
                        >
                      </div>
                      <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked />
                        <label class="form-check-label" for="flexSwitchCheckChecked"
                          >Checked switch checkbox input</label
                        >
                      </div>
                      <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDisabled" disabled />
                        <label class="form-check-label" for="flexSwitchCheckDisabled"
                          >Disabled switch checkbox input</label
                        >
                      </div>
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="flexSwitchCheckCheckedDisabled"
                          checked
                          disabled
                        />
                        <label class="form-check-label" for="flexSwitchCheckCheckedDisabled"
                          >Disabled checked switch checkbox input</label
                        >
                      </div>
                    </div>
                  </div>

                  <!-- Range -->
                  <div class="card mb-4 mb-xl-0">
                    <h5 class="card-header">Range</h5>
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="formRange1" class="form-label">Example range</label>
                        <input type="range" class="form-range" id="formRange1" />
                      </div>
                      <div class="mb-3">
                        <label for="disabledRange" class="form-label">Disabled range</label>
                        <input type="range" class="form-range" id="disabledRange" disabled />
                      </div>
                      <div class="mb-3">
                        <label for="formRange2" class="form-label">Min and max</label>
                        <input type="range" class="form-range" min="0" max="5" id="formRange2" />
                      </div>
                      <div>
                        <label for="formRange3" class="form-label">Steps</label>
                        <input type="range" class="form-range" min="0" max="5" step="0.5" id="formRange3" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-6">
                  <!-- HTML5 Inputs -->
                  <div class="card mb-4">
                    <h5 class="card-header">HTML5 Inputs</h5>
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Text</label>
                        <div class="col-md-10">
                          <input class="form-control" type="text" value="ProTeamHub" id="html5-text-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-search-input" class="col-md-2 col-form-label">Search</label>
                        <div class="col-md-10">
                          <input class="form-control" type="search" value="Search ..." id="html5-search-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-email-input" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                          <input class="form-control" type="email" value="<?= $_SESSION['username'] ?>@example.com" id="html5-email-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-url-input" class="col-md-2 col-form-label">URL</label>
                        <div class="col-md-10">
                          <input
                            class="form-control"
                            type="url"
                            value="https://ProTeamHub.com"
                            id="html5-url-input"
                          />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-tel-input" class="col-md-2 col-form-label">Phone</label>
                        <div class="col-md-10">
                          <input class="form-control" type="tel" value="90-(164)-188-556" id="html5-tel-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-password-input" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                          <input class="form-control" type="password" value="password" id="html5-password-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-number-input" class="col-md-2 col-form-label">Number</label>
                        <div class="col-md-10">
                          <input class="form-control" type="number" value="18" id="html5-number-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Datetime</label>
                        <div class="col-md-10">
                          <input
                            class="form-control"
                            type="datetime-local"
                            value="2021-06-18T12:30:00"
                            id="html5-datetime-local-input"
                          />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                        <div class="col-md-10">
                          <input class="form-control" type="date" value="2021-06-18" id="html5-date-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-month-input" class="col-md-2 col-form-label">Month</label>
                        <div class="col-md-10">
                          <input class="form-control" type="month" value="2021-06" id="html5-month-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-week-input" class="col-md-2 col-form-label">Week</label>
                        <div class="col-md-10">
                          <input class="form-control" type="week" value="2021-W25" id="html5-week-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-time-input" class="col-md-2 col-form-label">Time</label>
                        <div class="col-md-10">
                          <input class="form-control" type="time" value="12:30:00" id="html5-time-input" />
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="html5-color-input" class="col-md-2 col-form-label">Color</label>
                        <div class="col-md-10">
                          <input class="form-control" type="color" value="#666EE8" id="html5-color-input" />
                        </div>
                      </div>
                      <div class="row">
                        <label for="html5-range" class="col-md-2 col-form-label">Range</label>
                        <div class="col-md-10">
                          <input type="range" class="form-range mt-3" id="html5-range" />
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- File input -->
                  <div class="card">
                    <h5 class="card-header">File input</h5>
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Default file input example</label>
                        <input class="form-control" type="file" id="formFile" />
                      </div>
                      <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                        <input class="form-control" type="file" id="formFileMultiple" multiple />
                      </div>
                      <div>
                        <label for="formFileDisabled" class="form-label">Disabled file input example</label>
                        <input class="form-control" type="file" id="formFileDisabled" disabled />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://ProTeamHub.com" target="_blank" class="footer-link fw-bolder">ProTeamHub</a>
                </div>
                <div>
                  <a href="https://ProTeamHub.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://ProTeamHub.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://ProTeamHub.com/demo/ProTeamHub-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/Mohamed2007Sarhan/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <div class="buy-now">
      <a
        href="https://prof7mohamed-sarhan.netlify.app/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Content With Owner</a
      >
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <script src="../assets/js/form-basic-inputs.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
