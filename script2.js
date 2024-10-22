function able() {
  var text = ["Our Teacher", "Our Student", "Our Courses", "Our Sallery"];
  var rols = ["See More ...", "See More ...", "See More ...", "See More ..."];
  let row = document.querySelector("#box-2");
  for (let i = 1; i <= 4; i++) {
    let item = document.createElement("div");
    item.className = "col-lg-3 col-6";
    item.innerHTML = `
    <div class=bg${i}>
      <div>
      <ul>
          <li><a href="#"><span class="fa fa-phone" id="facebook"></span></a></li>
          <li><a href="#"><span class="fab fa-linkedin-in" id="facebook"></span></a></li>
          <li><a href="#"><span class="fab fa-facebook-square" id="facebook"></span></a></li>
          <li><a href="#"><span class="fab fa-instagram" id="instagram"></span></a></li>
          <li><a href="#"><span class="fab fa-whatsapp" id="whatsapp"></span></a></li>
       </ul>
      </div>
  </div>
  <a href="#">${text[i - 1]}</a>
  <a href="index.php">${rols[i - 1]}</a>`;
    row.appendChild(item);
    let bg_i = document.querySelector(`.bg${i}`);
    bg_i.style.backgroundImage = `url(Image/test${i}.jpg)`;
  }
}
