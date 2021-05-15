// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function () {
  scrollNavbarMain();
};

function scrollNavbarMain() {
  //Home page
  const homePage = document.getElementById("body-template");

  const navbarTop = document.getElementById("masthead");
  const logo = document.querySelector(".site-branding > .site-title > .link_menu_scroll");
  const siteDescription = document.querySelector(".site-branding > .site-description");
  var scrollTop = 70;
  const menuToggle = document.getElementById("menu_toggle");

  //Menu bars
  const bars = document.querySelectorAll(".bar");

  var fontColor = "#333";
  var resetFontColor = "#fff";
  var resetFontColorSiteDescription = "#e6e6e6";

  //Cuando de deshabilita el mediaHeader toma estas estilos css
  if (!(homePage.classList.contains("has-header-image") && homePage.classList.contains("absolute-header") && homePage.classList.contains("has-header-media"))) {
    fontColor = "#333";
    resetFontColor = "#333";
    resetFontColorSiteDescription = "332";
  }

  if (!homePage.classList.contains("home")) {
    fontColor = "#333";
    resetFontColor = "#333";
    resetFontColorSiteDescription = "332";
    scrollTop = 40;
  }

  if (document.body.scrollTop > scrollTop || document.documentElement.scrollTop > scrollTop) {
    navbarTop.style.backgroundColor = "white";
    navbarTop.style.boxShadow = "0px 0px 15px 0.5px #00000033";
    logo.style.color = fontColor;
    if (siteDescription) {
      siteDescription.style.color = fontColor;
    }
    menuToggle.style.setProperty("--font-color-before", fontColor);

    //All bar with color black
    for (const bar of bars) {
      bar.style.backgroundColor = fontColor;
    }
  } else {
    navbarTop.style.backgroundColor = "transparent";
    navbarTop.style.boxShadow = "none";
    logo.style.color = resetFontColor;
    if (siteDescription) {
      siteDescription.style.color = resetFontColorSiteDescription;
    }
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

  //Menu wrapper
  const menuWrapper = document.querySelector("#menu_slide > .menu_wrapper");

  //Al dar click en cualquier item que tengas submenus se hará el efecto de dropdown
  const itemHasChildren = document.getElementsByClassName("menu-item-has-children");
  const submenus = document.querySelectorAll(".menu-item-has-children > ul");

  // items clicks to show submenus
  for (let i = 0; i < itemHasChildren.length; i++) {
    for (let j = 0; j < submenus.length; j++) {
      if (i === j) {
        itemHasChildren[i].addEventListener("click", () => {
          if (!submenus[j].classList.contains("submenu-open-click")) {
            submenus[j].classList.add("submenu-open-click");
            itemHasChildren[i].style.setProperty("--rotate-icon", "0deg");
            itemHasChildren[i].style.setProperty("--align-items", "flex-start");
            itemHasChildren[i].style.setProperty("--margin-items", "1.2rem 0 0 0");
            itemHasChildren[i].style.setProperty("text-decoration-color", "white");
            menuWrapper.style.setProperty("margin-bottom", "1.5rem");
          } else {
            submenus[j].classList.remove("submenu-open-click");
            itemHasChildren[i].style.setProperty("--rotate-icon", "180deg");
            itemHasChildren[i].style.setProperty("--align-items", "center");
            itemHasChildren[i].style.setProperty("--margin-items", "0 0 0 0");
            itemHasChildren[i].style.setProperty("text-decoration-color", "black");
            menuWrapper.style.setProperty("margin-bottom", "0");
          }
        });
      }
    }
  }

  // Cuando se deshabilite el mediaHeader se coloca estos estilos css
  const homePage = document.getElementById("body-template");
  const logo = document.querySelector(".site-branding > .site-title > .link_menu_scroll");
  const siteDescription = document.querySelector(".site-branding > .site-description");
  const menuToggle = document.getElementById("menu_toggle");

  //Menu bars
  const bars = document.querySelectorAll(".bar");

  if (!(homePage.classList.contains("has-header-image") && homePage.classList.contains("absolute-header") && homePage.classList.contains("has-header-media"))) {
    logo.style.color = "#333";
    if (siteDescription) {
      siteDescription.style.color = "#333";
    }
    menuToggle.style.setProperty("--font-color-before", "#333");

    //All bar with color black
    for (const bar of bars) {
      bar.style.backgroundColor = "#333";
    }
  }
})();
