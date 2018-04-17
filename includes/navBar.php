<?php $term = ""; ?>

<div class='nav-header'>
  <nav class="nav-bar">
    <div class="logo" role="link" tabindex="0" onClick="openPage('index.php')">
      <i class="fas fa-headphones"></i>
      <h3>Songify</h3>
    </div>
    <div class="search">
      <span class="search-container">
        <input type="text" class="search-input" value="<?php echo $term; ?>" onfocus=" var temp_val=this.value; this.value = ''; this.value=temp_val" placeholder="Search">
        <i class="fas fa-search"></i>
      </span>

      <script>
        // keeps search field active
        $(".search-input").focus();

        // auto searches 1.5 seconds after typing has stopped
        $(function() {
          $(".search-input").keyup(function() {
            clearTimeout(timer);
            var input = $('.search-input').val();
            timer = setTimeout(function() {
              openPage("search.php?term=" + input);
            }, 1500);
          });
        });
      </script>

    </div>
    <div class="nav-items">
      <div class="nav-item">
        <span class="nav-link" role="link" tabindex="0" onClick="openPage('browse.php')">Browse</span>
      </div>
      <div class="nav-item">
        <span class="nav-link" role="link" tabindex="0" onClick="openPage('yourMusic.php')">Your Music</span>
      </div>
      <div class="nav-item">
        <span class="nav-link user" role="link" tabindex="0" onClick="openPage('settings.php')"><?php echo $userLoggedIn->getUsername(); ?></span>
      </div>
    </div>
  </nav>
</div>
