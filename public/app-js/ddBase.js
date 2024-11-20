(function() {
    const lang = document.documentElement.getAttribute("lang") || "en";
    const images = document.querySelectorAll("img");
    const links = document.querySelectorAll('a[target="_blank"]');

    images.forEach(img => {
      const src = img.getAttribute("src");
      if (src) {
        const fileName = src.split("/").pop().split(".")[0];
        const altTitleValue = `${fileName}-${lang}`;

        if (!img.hasAttribute("alt") || img.getAttribute("alt") === "") {
          img.setAttribute("alt", img.getAttribute("title") || altTitleValue);
        }

        if (!img.hasAttribute("title") || img.getAttribute("title") === "") {
          img.setAttribute("title", img.getAttribute("alt") || altTitleValue);
        }
      }
    });

links.forEach(link => {
    if (!link.hasAttribute("rel")) {
        link.setAttribute("rel", "nofollow noopener");
    } else {
        const relValue = link.getAttribute("rel");
        if (!relValue.includes("nofollow")) {
            link.setAttribute("rel", `${relValue} nofollow`);
        }
        if (!relValue.includes("noopener")) {
            link.setAttribute("rel", `${link.getAttribute("rel")} noopener`);
        }
    }
});
}());
