<nav class="nav-bar">
  <div class="logo" role="link" tabindex="0" onClick="openPage('index.php')">
    <i class="fas fa-headphones"></i>
    <h3>Songify</h3>
  </div>
  <div class="search">
    <div class="nav-item">
      <span class="nav-link" role="link" tabindex="0" onClick="openPage('search.php')">Search</span>
      <i class="fas fa-search"></i>
    </div>
  </div>
  <div class="nav-items">
    <div class="nav-item">
      <span class="nav-link" role="link" tabindex="0" onClick="openPage('browse.php')">Browse</span>
    </div>
    <div class="nav-item">
      <span class="nav-link" role="link" tabindex="0" onClick="openPage('yourMusic.php')">Your Music</span>
    </div>
    <div class="nav-item">
      <span class="nav-link" role="link" tabindex="0" onClick="openPage('settings.php')"><?php echo $userLoggedIn->getUsername(); ?></span>
    </div>
  </div>
</nav>
