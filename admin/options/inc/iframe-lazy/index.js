function lazyEmbed() {

  const youtube = document.querySelectorAll(".lazy-embed");

  for (let i = 0; i < youtube.length; i++) {

      let background_url = youtube[i].dataset.imgSrc;
      youtube[i].style.backgroundImage = `url(${background_url}`;

      youtube[i].addEventListener("click", function() {

          this.classList.remove('inactive');

          let embed = document.createElement("embed");

          embed.setAttribute("frameborder", "0");
          embed.setAttribute("allowfullscreen", "");
          let src = this.dataset.src.split('/');
          embed.setAttribute("src", "https://www.youtube.com/embed/" + src[src.length - 1] + "?rel=0&showinfo=0&autoplay=1");
          embed.setAttribute("width", this.dataset.width);
          embed.setAttribute("height", this.dataset.height);
          embed.setAttribute("style", "height: " + this.dataset.height + "px;width: " + this.dataset.width + "px;");

          this.innerHTML = "";
          this.appendChild(embed);
      }, {
          once: true,
          passive: true
      });
  }
}

if (window.scrollY > 0) {
  lazyEmbed();
} else {
  window.addEventListener('mousemove', lazyEmbed, {
      once: true,
      passive: true
  });
}