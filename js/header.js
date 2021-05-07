// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function () {
  scrollNavbarMain();
};

function scrollNavbarMain() {
  //Get the site-navigation
  const siteNavigation = document.getElementById("site-navigation");
  const menu = siteNavigation.querySelector(".menu");
  // Get all the link elements within the menu.
  const links = menu.querySelectorAll("li > a");

  const navbarTop = document.getElementById("masthead");
  const logo = document.querySelector(".link_menu_scroll");
  const scrollTop = 70;

  //Menu bars
  //const bars = document.querySelectorAll(".bar");

  const fontColor = "#333";
  const resetFontColor = "#fff";

  if (document.body.scrollTop > scrollTop || document.documentElement.scrollTop > scrollTop) {
    navbarTop.style.backgroundColor = "white";
    navbarTop.style.padding = "0rem 3rem";
    navbarTop.style.boxShadow = "0px 0px 15px 0.5px #00000033";
    logo.style.color = fontColor;

    //All bar with color black
    // for (const bar of bars) {
    //   bar.style.backgroundColor = fontColor;
    // }

    //All link with color black
    for (const link of links) {
      link.style.color = fontColor;
    }
  } else {
    navbarTop.style.backgroundColor = "transparent";
    navbarTop.style.padding = "0 3rem";
    navbarTop.style.boxShadow = "none";
    logo.style.color = resetFontColor;

    //Reset bars' background color
    // for (const bar of bars) {
    //   bar.style.backgroundColor = resetFontColor;
    // }

    //Reset link's font color
    for (const link of links) {
      link.style.color = resetFontColor;
    }
  }
}
