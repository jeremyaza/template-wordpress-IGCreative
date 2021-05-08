// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function () {
  scrollNavbarMain();
};

function scrollNavbarMain() {
  const navbarTop = document.getElementById("masthead");
  const logo = document.querySelector(".link_menu_scroll");
  const scrollTop = 70;
  const menuToggle = document.getElementById("menu_toggle");

  //Menu bars
  const bars = document.querySelectorAll(".bar");

  const fontColor = "#333";
  const resetFontColor = "#fff";

  if (document.body.scrollTop > scrollTop || document.documentElement.scrollTop > scrollTop) {
    navbarTop.style.backgroundColor = "white";
    navbarTop.style.boxShadow = "0px 0px 15px 0.5px #00000033";
    logo.style.color = fontColor;
    menuToggle.style.setProperty("--font-color-before", fontColor);

    //All bar with color black
    for (const bar of bars) {
      bar.style.backgroundColor = fontColor;
    }
  } else {
    navbarTop.style.backgroundColor = "transparent";
    navbarTop.style.boxShadow = "none";
    logo.style.color = resetFontColor;
    menuToggle.style.setProperty("--font-color-before", resetFontColor);

    //Reset bars' background color
    for (const bar of bars) {
      bar.style.backgroundColor = resetFontColor;
    }
  }
}

function toggleMenu() {
  //Menu contain
  const menu = document.getElementById("menu_wrapper_header");
  //Body scroll
  const body = document.getElementById("body-template");
  //Menu slide
  const menuOpen = document.getElementById("menu_slide");

  //Close
  const close1 = document.getElementById("close-1");
  const close2 = document.getElementById("close-2");

  //Añadir las clases a los elementos para mostrar el menú
  menu.classList.toggle("menu_wrapper_open");
  body.classList.toggle("hidden_scroll_body_template");
  menuOpen.classList.toggle("content_menu_slide_open");
  close1.classList.toggle("close-effect-1");
  close2.classList.toggle("close-effect-2");
}

(function () {
  //Toogle icon
  const siteNavigation = document.getElementById("menu_toggle");
  //Body scroll
  const body = document.getElementById("body-template");
  //Menu contain
  const containMenu = document.getElementById("menu_wrapper_header");
  //Menu slide
  const menuSlide = document.getElementById("menu_slide");

  //Close Icon
  const close1 = document.getElementById("close-1");
  const close2 = document.getElementById("close-2");

  // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
  document.addEventListener("click", function (event) {
    const isClickInside = siteNavigation.contains(event.target);
    const isClickInsideMenuSlide = menuSlide.contains(event.target);

    if (!isClickInside && !isClickInsideMenuSlide) {
      // siteNavigation.classList.remove("toggled");
      containMenu.classList.remove("menu_wrapper_open");
      menuSlide.classList.remove("content_menu_slide_open");
      body.classList.remove("hidden_scroll_body_template");
      close1.classList.remove("close-effect-1");
      close2.classList.remove("close-effect-2");
    }
  });
})();
