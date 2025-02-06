<!DOCTYPE html>

<?php
// التحقق من وجود الكوكيز
if(isset($_COOKIE['admin_id'])) {

} else {

    header("Location: ../../../");
    exit();
}
?>

<?php
// التحقق من وجود الكوكيز
if(isset($_COOKIE['admin_id'])) {

} else {

    header("Location: ../../../");
    exit();
}
?>

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

    <title>List groups - UI elements | ProTeamHub</title>

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
            <li class="menu-item active open">
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
                <li class="menu-item active">
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
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Elements">Form Elements</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">UI elements /</span> List groups</h4>

              <div class="card mb-4">
                <h5 class="card-header">List groups</h5>
                <div class="card-body">
                  <div class="row">
                    <!-- Basic List group -->
                    <div class="col-lg-6 mb-4 mb-xl-0">
                      <small class="text-light fw-semibold">Basic</small>
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group">
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action active"
                            >Bear claw cake biscuit</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Soufflé pastry pie ice</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action disabled"
                            >Tart tiramisu cake</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Bonbon toffee muffin</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Dragée tootsie roll</a
                          >
                        </div>
                      </div>
                    </div>
                    <!--/ Basic List group -->
                    <!-- List group with Badges & Pills -->
                    <div class="col-lg-6">
                      <small class="text-light fw-semibold">With Bagdes & Pills</small>
                      <div class="demo-inline-spacing mt-3">
                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Soufflé pastry pie ice
                            <span class="badge bg-primary">5</span>
                          </li>
                          <li class="list-group-item disabled">Bear claw cake biscuit</li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tart tiramisu cake
                            <span class="badge bg-success">2</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Bonbon toffee muffin
                            <span class="badge bg-danger rounded-pill">3</span>
                          </li>
                          <li class="list-group-item">Dragée tootsie roll</li>
                        </ul>
                      </div>
                    </div>
                    <!--/ List group with Badges & Pills -->
                  </div>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                  <div class="row">
                    <!-- List group Flush (Without main border) -->
                    <div class="col-lg-6 mb-4 mb-xl-0">
                      <small class="text-light fw-semibold">Flush</small>
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group list-group-flush">
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Bear claw cake biscuit</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Soufflé pastry pie ice</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Tart tiramisu cake</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Bonbon toffee muffin</a
                          >
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action"
                            >Dragée tootsie roll</a
                          >
                        </div>
                      </div>
                    </div>
                    <!--/ List group Flush (Without main border) -->
                    <!-- List group Icons -->
                    <div class="col-lg-6">
                      <small class="text-light fw-semibold">With Icons</small>
                      <div class="demo-inline-spacing mt-3">
                        <ul class="list-group">
                          <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-tv me-2"></i>
                            Soufflé pastry pie ice
                          </li>
                          <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-bell me-2"></i>
                            Bear claw cake biscuit
                          </li>
                          <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-support me-2"></i>
                            Tart tiramisu cake
                          </li>
                          <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-purchase-tag-alt me-2"></i>
                            Bonbon toffee muffin
                          </li>
                          <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-closet me-2"></i>
                            Dragée tootsie roll
                          </li>
                        </ul>
                      </div>
                    </div>
                    <!--/ List group Icons -->
                  </div>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                  <div class="row">
                    <!-- List group Numbered -->
                    <div class="col-lg-6 mb-4 mb-xl-0">
                      <small class="text-light fw-semibold">Numbered</small>
                      <div class="demo-inline-spacing mt-3">
                        <ol class="list-group list-group-numbered">
                          <li class="list-group-item">Bear claw cake biscuit</li>
                          <li class="list-group-item">Soufflé pastry pie ice</li>
                          <li class="list-group-item">Tart tiramisu cake</li>
                          <li class="list-group-item">Bonbon toffee muffin</li>
                          <li class="list-group-item">Dragée tootsie roll</li>
                        </ol>
                      </div>
                    </div>
                    <!--/ List group Numbered -->
                    <!-- List group checkbox -->
                    <div class="col-lg-6">
                      <small class="text-light fw-semibold">List Group With Checkbox</small>
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group">
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" />
                            Soufflé pastry pie ice
                          </label>
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" />
                            Bear claw cake biscuit
                          </label>
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" />
                            Tart tiramisu cake
                          </label>
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" />
                            Bonbon toffee muffin
                          </label>
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" />
                            Dragée tootsie roll
                          </label>
                        </div>
                      </div>
                    </div>
                    <!--/ List group checkbox -->
                  </div>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                  <div class="row">
                    <!-- Contextual List group -->
                    <div class="col-lg-6 mb-4 mb-xl-0">
                      <small class="text-light fw-semibold">Contextual classes</small>
                      <div class="demo-inline-spacing mt-3">
                        <ul class="list-group">
                          <li class="list-group-item list-group-item-primary">Primary list group item</li>
                          <li class="list-group-item list-group-item-secondary">Secondary list group item</li>
                          <li class="list-group-item list-group-item-success">Success list group item</li>
                          <li class="list-group-item list-group-item-danger">Danger list group item</li>
                          <li class="list-group-item list-group-item-warning">Warning list group item</li>
                          <li class="list-group-item list-group-item-info">Info list group item</li>
                          <li class="list-group-item list-group-item-dark">Dark list group item</li>
                        </ul>
                      </div>
                    </div>
                    <!--/ Contextual List group -->
                    <!-- Custom content with heading -->
                    <div class="col-lg-6">
                      <small class="text-light fw-semibold">Custom content</small>
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group">
                          <a
                            href="javascript:void(0);"
                            class="list-group-item list-group-item-action flex-column align-items-start active"
                          >
                            <div class="d-flex justify-content-between w-100">
                              <h6>List group item heading</h6>
                              <small>3 days ago</small>
                            </div>
                            <p class="mb-1">
                              Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius
                              blandit.
                            </p>
                            <small>Donec id elit non mi porta.</small>
                          </a>
                          <a
                            href="javascript:void(0);"
                            class="list-group-item list-group-item-action flex-column align-items-start"
                          >
                            <div class="d-flex justify-content-between w-100">
                              <h6>List group item heading</h6>
                              <small class="text-muted">3 days ago</small>
                            </div>
                            <p class="mb-1">
                              Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius
                              blandit.
                            </p>
                            <small class="text-muted">Donec id elit non mi porta.</small>
                          </a>
                          <a
                            href="javascript:void(0);"
                            class="list-group-item list-group-item-action flex-column align-items-start"
                          >
                            <div class="d-flex justify-content-between w-100">
                              <h6>List group item heading</h6>
                              <small class="text-muted">3 days ago</small>
                            </div>
                            <p class="mb-1">
                              Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius
                              blandit.
                            </p>
                            <small class="text-muted">Donec id elit non mi porta.</small>
                          </a>
                        </div>
                      </div>
                    </div>
                    <!--/ Custom content with heading -->
                  </div>
                </div>
              </div>

              <div class="card mb-4">
                <h5 class="card-header">Javascript behavior</h5>
                <div class="card-body">
                  <div class="row">
                    <!-- Custom content with heading -->
                    <div class="col-lg-6 mb-4 mb-xl-0">
                      <small class="text-light fw-semibold">Vertical</small>
                      <div class="mt-3">
                        <div class="row">
                          <div class="col-md-4 col-12 mb-3 mb-md-0">
                            <div class="list-group">
                              <a
                                class="list-group-item list-group-item-action active"
                                id="list-home-list"
                                data-bs-toggle="list"
                                href="#list-home"
                                >Home</a
                              >
                              <a
                                class="list-group-item list-group-item-action"
                                id="list-profile-list"
                                data-bs-toggle="list"
                                href="#list-profile"
                                >Profile</a
                              >
                              <a
                                class="list-group-item list-group-item-action"
                                id="list-messages-list"
                                data-bs-toggle="list"
                                href="#list-messages"
                                >Messages</a
                              >
                              <a
                                class="list-group-item list-group-item-action"
                                id="list-settings-list"
                                data-bs-toggle="list"
                                href="#list-settings"
                                >Settings</a
                              >
                            </div>
                          </div>
                          <div class="col-md-8 col-12">
                            <div class="tab-content p-0">
                              <div class="tab-pane fade show active" id="list-home">
                                Donut sugar plum sweet roll biscuit. Cake oat cake gummi bears. Tart wafer wafer halvah
                                gummi bears cheesecake. Topping croissant cake sweet roll. Dessert fruitcake gingerbread
                                halvah marshmallow pudding bear claw cheesecake. Bonbon dragée cookie gummies. Pudding
                                marzipan liquorice. Sugar plum dragée cupcake cupcake cake dessert chocolate bar. Pastry
                                lollipop lemon drops lollipop halvah croissant. Pastry sweet gingerbread lemon drops
                                topping ice cream.
                              </div>
                              <div class="tab-pane fade" id="list-profile">
                                Muffin lemon drops chocolate chupa chups jelly beans dessert jelly-o. Soufflé gummies
                                gummies. Ice cream powder marshmallow cotton candy oat cake wafer. Marshmallow
                                gingerbread tootsie roll. Chocolate cake bonbon jelly beans lollipop jelly beans halvah
                                marzipan danish pie. Oat cake chocolate cake pudding bear claw liquorice gingerbread
                                icing sugar plum brownie. Toffee cookie apple pie cheesecake bear claw sugar plum wafer
                                gummi bears fruitcake.
                              </div>
                              <div class="tab-pane fade" id="list-messages">
                                Ice cream dessert candy sugar plum croissant cupcake tart pie apple pie. Pastry
                                chocolate chupa chups tiramisu. Tiramisu cookie oat cake. Pudding brownie bonbon. Pie
                                carrot cake chocolate macaroon. Halvah jelly jelly beans cake macaroon jelly-o. Danish
                                pastry dessert gingerbread powder halvah. Muffin bonbon fruitcake dragée sweet sesame
                                snaps oat cake marshmallow cheesecake. Cupcake donut sweet bonbon cheesecake soufflé
                                chocolate bar.
                              </div>
                              <div class="tab-pane fade" id="list-settings">
                                Marzipan cake oat cake. Marshmallow pie chocolate. Liquorice oat cake donut halvah
                                jelly-o. Jelly-o muffin macaroon cake gingerbread candy cupcake. Cake lollipop lollipop
                                jelly brownie cake topping chocolate. Pie oat cake jelly. Lemon drops halvah jelly
                                cookie bonbon cake cupcake ice cream. Donut tart bonbon sweet roll soufflé gummies
                                biscuit. Wafer toffee topping jelly beans icing pie apple pie toffee pudding. Tiramisu
                                powder macaroon tiramisu cake halvah.
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <small class="text-light fw-semibold">Horizontal</small>
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group list-group-horizontal-md text-md-center">
                          <a
                            class="list-group-item list-group-item-action active"
                            id="home-list-item"
                            data-bs-toggle="list"
                            href="#horizontal-home"
                            >Home</a
                          >
                          <a
                            class="list-group-item list-group-item-action"
                            id="profile-list-item"
                            data-bs-toggle="list"
                            href="#horizontal-profile"
                            >Profile</a
                          >
                          <a
                            class="list-group-item list-group-item-action"
                            id="messages-list-item"
                            data-bs-toggle="list"
                            href="#horizontal-messages"
                            >Messages</a
                          >
                          <a
                            class="list-group-item list-group-item-action"
                            id="settings-list-item"
                            data-bs-toggle="list"
                            href="#horizontal-settings"
                            >Settings</a
                          >
                        </div>
                        <div class="tab-content px-0 mt-0">
                          <div class="tab-pane fade show active" id="horizontal-home">
                            Donut sugar plum sweet roll biscuit. Cake oat cake gummi bears. Tart wafer wafer halvah
                            gummi bears cheesecake. Topping croissant cake sweet roll. Dessert fruitcake gingerbread
                            halvah marshmallow pudding bear claw cheesecake. Bonbon dragée cookie gummies. Pudding
                            marzipan liquorice. Sugar plum dragée cupcake cupcake cake dessert chocolate bar. Pastry
                            lollipop lemon drops lollipop halvah croissant. Pastry sweet gingerbread lemon drops topping
                            ice cream.
                          </div>
                          <div class="tab-pane fade" id="horizontal-profile">
                            Muffin lemon drops chocolate chupa chups jelly beans dessert jelly-o. Soufflé gummies
                            gummies. Ice cream powder marshmallow cotton candy oat cake wafer. Marshmallow gingerbread
                            tootsie roll. Chocolate cake bonbon jelly beans lollipop jelly beans halvah marzipan danish
                            pie. Oat cake chocolate cake pudding bear claw liquorice gingerbread icing sugar plum
                            brownie. Toffee cookie apple pie cheesecake bear claw sugar plum wafer gummi bears
                            fruitcake.
                          </div>
                          <div class="tab-pane fade" id="horizontal-messages">
                            Ice cream dessert candy sugar plum croissant cupcake tart pie apple pie. Pastry chocolate
                            chupa chups tiramisu. Tiramisu cookie oat cake. Pudding brownie bonbon. Pie carrot cake
                            chocolate macaroon. Halvah jelly jelly beans cake macaroon jelly-o. Danish pastry dessert
                            gingerbread powder halvah. Muffin bonbon fruitcake dragée sweet sesame snaps oat cake
                            marshmallow cheesecake. Cupcake donut sweet bonbon cheesecake soufflé chocolate bar.
                          </div>
                          <div class="tab-pane fade" id="horizontal-settings">
                            Marzipan cake oat cake. Marshmallow pie chocolate. Liquorice oat cake donut halvah jelly-o.
                            Jelly-o muffin macaroon cake gingerbread candy cupcake. Cake lollipop lollipop jelly brownie
                            cake topping chocolate. Pie oat cake jelly. Lemon drops halvah jelly cookie bonbon cake
                            cupcake ice cream. Donut tart bonbon sweet roll soufflé gummies biscuit. Wafer toffee
                            topping jelly beans icing pie apple pie toffee pudding. Tiramisu powder macaroon tiramisu
                            cake halvah.
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--/ Custom content with heading -->
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

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
