$(function() {
      $("#navbar-collapse-target > ul.nav.navbar-nav.items").append("<li><a href='user.php'>Mí cuenta</a></li>");
      $("#navbar-collapse-target > ul.nav.navbar-nav.items").append("<li><a href='logout.php'>Desconectarse</a></li>");
      $("body > nav > div > div.navbar-header > a.navbar-brand").empty().text("Clunia Viewer - !Bienvenido!")
});