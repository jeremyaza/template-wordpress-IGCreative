/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
  // const siteNavigation = document.getElementById("menu_toggle");

  // // Return early if the navigation don't exist.
  // if (!siteNavigation) {
  //   return;
  // }

  // const menu = siteNavigation.getElementsByTagName("ul")[0];

  // if (!menu.classList.contains("nav-menu")) {
  //   menu.classList.add("nav-menu");
  // }

  // // Get all the link elements within the menu.
  // const links = menu.getElementsByTagName("a");

  // // Get all the link elements with children within the menu.
  // const linksWithChildren = menu.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");

  // // Toggle focus each time a menu link is focused or blurred.
  // for (const link of links) {
  //   link.addEventListener("focus", toggleFocus, true);
  //   link.addEventListener("blur", toggleFocus, true);
  // }

  // // Toggle focus each time a menu link with children receive a touch event.
  // for (const link of linksWithChildren) {
  //   link.addEventListener("touchstart", toggleFocus, false);
  // }

  // /**
  //  * Sets or removes .focus class on an element.
  //  */
  // function toggleFocus() {
  //   if (event.type === "focus" || event.type === "blur") {
  //     let self = this;
  //     // Move up through the ancestors of the current link until we hit .nav-menu.
  //     while (!self.classList.contains("nav-menu")) {
  //       // On li elements toggle the class .focus.
  //       if ("li" === self.tagName.toLowerCase()) {
  //         self.classList.toggle("focus");
  //       }
  //       self = self.parentNode;
  //     }
  //   }

  //   if (event.type === "touchstart") {
  //     const menuItem = this.parentNode;
  //     event.preventDefault();
  //     for (const link of menuItem.parentNode.children) {
  //       if (menuItem !== link) {
  //         link.classList.remove("focus");
  //       }
  //     }
  //     menuItem.classList.toggle("focus");
  //   }
  // }

  //Home page
  const homePage = document.getElementById("body-template");

  //Primary menu
  const siteTitle = document.querySelector("#masthead > .site-branding > .site-title > a");
  const siteDescription = document.querySelector("#masthead > .site-branding > .site-description");

  //Menu bars
  const menuToggle = document.getElementById("menu_toggle");
  const bars = document.querySelectorAll(".bar");

  if (!homePage.classList.contains("home")) {
    siteTitle.style.setProperty("color", "#333");
  
    //If exist siteDescription add the style
    if (siteDescription) {
      siteDescription.style.setProperty("color", "#333");
    }

    menuToggle.style.setProperty("--font-color-before", "#333");
    for (const bar of bars) {
      bar.style.backgroundColor = "#333";
    }
  }
})();
