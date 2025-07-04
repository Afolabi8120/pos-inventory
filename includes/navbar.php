<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <h3 class="text-white h4"><?= ucwords($getStoreData->name); ?></h3>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <?php foreach ($product->fetchAllLowStockNotification() as $fetchProduct): ?>
                <a href="edit-stock?id=<?= $fetchProduct->product_id; ?>" class="dropdown-item">
                  <div class="dropdown-item-icon bg-danger text-white">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    <span class="text-danger">
                      <?= $fetchProduct->product_code . " - " . ucwords($fetchProduct->product_name); ?>
                    </span> is out of stock, kindly plan to restock it.
                  </div>
                </a>
                <?php endforeach; ?>
                <?php foreach ($product->fetchExpiredProducts() as $fetchExpired): ?>
                <a href="edit-stock?id=<?= $fetchExpired->product_id; ?>" class="dropdown-item">
                  <div class="dropdown-item-icon bg-danger text-white">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    <span class="text-danger">
                      <?= $fetchExpired->product_code . " - " . ucwords($fetchExpired->product_name); ?>
                    </span> has expired. Expired on <?= $fetchExpired->expiry_date; ?>
                  </div>
                </a>
                <?php endforeach; ?>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= ucwords($getAdmin->fullname); ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in 5 min ago</div>
              <a href="profile" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="settings" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>